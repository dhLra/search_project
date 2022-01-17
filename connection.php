<?php

require __DIR__ . "/database.php";

function appendAND($sql, $bindings) {
    if (count($bindings) > 0) {
        return "$sql AND ";
    }

    return $sql;
}

$sql = "";
$search_param = "";
$search_type = "";
$order_by = "Municipio";
$order_by_direction = "ASC";
$order_by_direction_invertion = "desc";

// Resultados da busca
$result = []; 
$formInputs = [];
$adaQuery = false;

function providerMainTableQuery() {
    global $sql, $conn, $order_by, $order_by_direction,
        $order_by_direction_invertion, $formInputs, $adaQuery;

    $sql = "";
    $order_by = "Municipio";
    $order_by_direction = "ASC";
    $order_by_direction_invertion = "desc";
    $formInputs = [];
    $adaQuery = false;
    $bindings = [];

    $sql = 'SELECT * FROM `provedores` WHERE ';

    if (isset($_POST["nome"]) && strlen($_POST["nome"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "Nome_Fantasia LIKE :nome ";
        $bindings[] = [":nome", $_POST["nome"]];
        $formInputs[] = "<input type='hidden' name='nome' value='$_POST[nome]' />";
    }

    if (isset($_POST["uf"]) && strlen($_POST["uf"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "UF_SEDE LIKE :uf ";
        $bindings[] = [":uf", $_POST["uf"]];
        $formInputs[] = "<input type='hidden' name='uf' value='$_POST[uf]' />";
    }

    if (isset($_POST["cnpj"]) && strlen($_POST["cnpj"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "CNPJCPF LIKE :cnpj ";
        $bindings[] = [":cnpj", $_POST["cnpj"]];
        $formInputs[] = "<input type='hidden' name='cnpj' value='$_POST[cnpj]' />";
    }

    if (isset($_POST["cidade"]) && strlen($_POST["cidade"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "Municipio LIKE :cidade ";
        $bindings[] = [":cidade", $_POST["cidade"]];
        $formInputs[] = "<input type='hidden' name='cidade' value='$_POST[cidade]' />";

    }

    if (isset($_POST["regiao"]) && strlen($_POST["regiao"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "Regiao LIKE :regiao ";
        $bindings[] = [":regiao", $_POST["regiao"]];
        $formInputs[] = "<input type='hidden' name='regiao' value='$_POST[regiao]' />";
    }

    switch ($_POST["order_by_direction"]) {
        case "asc":
            $order_by_direction = "ASC";
            $order_by_direction_invertion = "desc";
            break;
        case "desc":
            $order_by_direction = "DESC";
            $order_by_direction_invertion = "asc";
            break;
    }

    switch ($_POST["order_by"]) {
        case "nome":
            $order_by = "Nome_Fantasia";
            break;
        case "uf":
            $order_by = "UF_SEDE";
            break;
        case "cidade":
            $order_by = "Municipio $order_by_direction, UF_SEDE";
            break;
        case "telefone":
            $order_by = "Telefone_Principal";
            break;
    }

    $sql .= "
        ORDER BY $order_by $order_by_direction
        ";

    $stmt = $conn->prepare($sql);

    for ($i = 0; $i < count($bindings); $i++) {
        $pType = PDO::PARAM_STR;

        if (isset($bindings[$i][2])) {
            $pType = $bindings[$i][2];
        }

        $stmt->bindParam(
                $bindings[$i][0],
                $bindings[$i][1],
                $pType
                );
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function providerADATableQuery() {
    global $sql, $conn, $order_by, $order_by_direction,
        $order_by_direction_invertion, $adaQuery, $formInputs;

    $sql = "";
    $order_by = "Municipio";
    $order_by_direction = "ASC";
    $order_by_direction_invertion = "desc";
    $formInputs = [];
    $adaQuery = false;
    $bindings = [];

    $adaQuery = true;
    $sql = '
        SELECT
            tf.nome AS Nome_Fantasia,
            tt.numero_telefone AS Telefone_Principal,
            "-" AS Municipio,
            "" AS UF_SEDE
        FROM tabela_fornecedor AS tf
        INNER JOIN tabela_contato AS tc
            ON tc.id_fornecedor = tf.id_fornecedor
        INNER JOIN tabela_telefone AS tt
            ON tt.id_contato = tc.id_contato
        WHERE tf.id_fornecedor = :id
        GROUP BY tf.nome
    ';

    $bindings[] = [":id", intval($_POST["id_ada"]), PDO::PARAM_INT];

    switch ($_POST["order_by_direction"]) {
        case "asc":
            $order_by_direction = "ASC";
            $order_by_direction_invertion = "desc";
            break;
        case "desc":
            $order_by_direction = "DESC";
            $order_by_direction_invertion = "asc";
            break;
    }

    switch ($_POST["order_by"]) {
        case "nome":
            $order_by = "Nome_Fantasia";
            break;
        case "uf":
            $order_by = "UF_SEDE";
            break;
        case "cidade":
            $order_by = "Municipio $order_by_direction, UF_SEDE";
            break;
        case "telefone":
            $order_by = "Telefone_Principal";
            break;
    }

    $sql .= "
        ORDER BY $order_by $order_by_direction
    ";

    $stmt = $conn->prepare($sql);

    for ($i = 0; $i < count($bindings); $i++) {
        $pType = PDO::PARAM_STR;

        if (isset($bindings[$i][2])) {
            $pType = $bindings[$i][2];
        }

        $stmt->bindParam(
                $bindings[$i][0],
                $bindings[$i][1],
                $pType
                );
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST["ada_query"]) && strlen($_POST["id_ada"]) > 0) {
    $result = providerADATableQUery();
} else {
    $result = providerMainTableQuery();

    if (count($result) == 0 && strlen($_POST["id_ada"]) > 0) {
        $result = providerADATableQuery();
    }
}

/* echo "<pre>"; */
/* var_dump($result); */
/* var_dump($sql); */
/* var_dump($_POST); */
/* var_dump($bindings); */
/* echo "</pre>"; */
/* die(); */

require __DIR__ . '/results.php';
/* require __DIR__ . '/result_provider.php'; */
