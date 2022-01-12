<?php

require __DIR__ . "/database.php";

function appendAND($sql, $bindings) {
    if (count($bindings) > 0) {
        return "$sql AND ";
    }

    return $sql;
}

if (isset($_POST['submit'])) {
    /* echo "<pre>"; */
    /* var_dump($_POST); */
    /* echo "</pre>"; */
    /* die(); */

    $search_param = "";
    $search_type = "";
    // Resultados da busca
    $result = []; 

    $bindings = [];
    $sql = 'SELECT * FROM `provedores` WHERE ';

    if (strlen($_POST["uf"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "UF_SEDE LIKE :uf ";
        $bindings[] = [":uf", $_POST["uf"]];
    }

    if (strlen($_POST["cnpj"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "CNPJCPF LIKE :cnpj ";
        $bindings[] = [":cnpj", $_POST["cnpj"]];
    }

    if (strlen($_POST["cidade"]) > 0) {
        $sql = appendAND($sql, $bindings);
        $sql .= "Municipio LIKE :cidade ";
        $bindings[] = [":cidade", $_POST["cidade"]];
    }

    $sql .= '
        ORDER BY Municipio ASC
    ';

    $stmt = $conn->prepare($sql);

    for ($i = 0; $i < count($bindings); $i++) {
        $stmt->bindParam($bindings[$i][0], $bindings[$i][1]);
    }

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require __DIR__ . '/results.php';
    /* require __DIR__ . '/result_provider.php'; */
}
