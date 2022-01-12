<?php

require __DIR__ . '/database.php';

/* $statistics = []; */

/* // Total de provedores */
/* $stmt = $conn->prepare('SELECT count(id) as total FROM provedores'); */
/* $stmt->execute(); */
/* $statistics['total'] = ($stmt->fetch(PDO::FETCH_ASSOC))['total']; */

/* // Total de provedores por estado */
/* $stmt = $conn->prepare('SELECT p.UF_Sede as estado, COUNT(p.UF_Sede) as total FROM provedores as p GROUP BY p.UF_Sede'); */
/* $stmt->execute(); */
/* $statistics['by_state'] = $stmt->fetchAll(PDO::FETCH_ASSOC); */

/* // Total de provedores por região */
/* $stmt = $conn->prepare('SELECT p.Regiao as regiao, COUNT(p.Regiao) as total FROM provedores as p GROUP BY p.Regiao'); */
/* $stmt->execute(); */
/* $statistics['by_region'] = $stmt->fetchAll(PDO::FETCH_ASSOC); */

function totalASN() {
    global $conn;
    $stmt = $conn->prepare("
        SELECT
            COUNT(*) AS provedores
        FROM provedores AS p
        WHERE p.ASN <> ''"
    );

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function totalISP() {
    global $conn;
    $stmt = $conn->prepare("
        SELECT
            COUNT(*) AS provedores
        FROM provedores AS p
        WHERE p.ASN = ''"
    );

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function totalProviderBy($paramName, $paramValue) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT
            COUNT(*) AS provedores
        FROM provedores AS p
        WHERE p.`$paramName` = :pv"
    );

    $stmt->bindParam(":pv", $paramValue);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function totalASNBy($paramName, $paramValue) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT
            COUNT(*) AS provedores
        FROM provedores AS p
        WHERE p.ASN <> '' AND
              p.`$paramName` = :pv"
    );

    $stmt->bindParam(":pv", $paramValue);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function totalISPBy($paramName, $paramValue) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT
            COUNT(*) AS provedores
        FROM provedores AS p
        WHERE p.ASN = '' AND
              p.`$paramName` = :pv"
    );

    $stmt->bindParam(":pv", $paramValue);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function activeCircuitsByCity($city) {
    global $conn;
    $sql = "
        SELECT c.nome as cidade, count(tc.id_circuito) as circuitos
        FROM tabela_ponto AS tp
        LEFT JOIN tabela_infotecnica as it
            ON it.id_ponto = tp.id_ponto
        LEFT JOIN tabela_circuito AS tc
            ON tc.id_ponto_a = tp.id_ponto OR tc.id_ponto_b = tp.id_ponto
        LEFT JOIN tabela_cidade AS c
            ON tp.cidade = c.nome
        WHERE c.nome IS NOT NULL 
                AND tc.status_flag = 'ATIVO'
                AND (it.ip IS NOT NULL OR (it.login IS NOT NULL AND it.pwd IS NOT NULL))
    ";

    if (strlen($city) > 0) {
        $sql .= "
            AND c.nome LIKE :city
        ";
    }

    $sql .= "
        GROUP BY c.id_cidade
        HAVING circuitos > 0
        ORDER BY circuitos DESC
    ";

    $stmt = $conn->prepare($sql);

    if (strlen($city) > 0) {
    $stmt->bindParam(":city", $city);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function activeCircuitsByCityRegion($region) {
    global $conn;
    $sql = "
        SELECT c.nome as cidade, r.`Região` as regiao, count(tc.id_circuito) as circuitos
        FROM tabela_ponto AS tp
        LEFT JOIN tabela_infotecnica as it
            ON it.id_ponto = tp.id_ponto
        LEFT JOIN tabela_circuito AS tc
            ON tc.id_ponto_a = tp.id_ponto OR tc.id_ponto_b = tp.id_ponto
        LEFT JOIN tabela_cidade AS c
            ON tp.cidade = c.nome
        LEFT JOIN regiao as r
            ON UPPER(r.`Município`) = c.nome
        WHERE c.nome IS NOT NULL 
                AND tc.status_flag = 'ATIVO'
                AND (it.ip IS NOT NULL OR (it.login IS NOT NULL AND it.pwd IS NOT NULL))
    ";

    if (strlen($region) > 0) {
        $sql .= "
            AND r.`Região` LIKE :region
        ";
    }

    $sql .= "
        GROUP BY c.id_cidade
        HAVING circuitos > 0
        ORDER BY circuitos DESC
    ";

    $stmt = $conn->prepare($sql);

    if (strlen($region) > 0) {
    $stmt->bindParam(":region", $region);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function activeCircuitsByCityUF($uf) {
    global $conn;
    $sql = "
        SELECT c.nome as cidade, r.UF as estado, count(tc.id_circuito) as circuitos
        FROM tabela_ponto AS tp
        LEFT JOIN tabela_infotecnica as it
            ON it.id_ponto = tp.id_ponto
        LEFT JOIN tabela_circuito AS tc
            ON tc.id_ponto_a = tp.id_ponto OR tc.id_ponto_b = tp.id_ponto
        LEFT JOIN tabela_cidade AS c
            ON tp.cidade = c.nome
        LEFT JOIN regiao as r
            ON UPPER(r.`Município`) = c.nome
        WHERE c.nome IS NOT NULL 
                AND tc.status_flag = 'ATIVO'
                AND (it.ip IS NOT NULL OR (it.login IS NOT NULL AND it.pwd IS NOT NULL))
    ";

    if (strlen($uf) > 0) {
        $sql .= "
            AND r.UF LIKE :uf
        ";
    }

    $sql .= "
        GROUP BY c.id_cidade
        HAVING circuitos > 0
        ORDER BY circuitos DESC
    ";

    $stmt = $conn->prepare($sql);

    if (strlen($uf) > 0) {
        $stmt->bindParam(":uf", $uf);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function coverageAreaCity() {
    global $conn;
    $sql = "
        SELECT
            c.nome as cidade,
          (
            SELECT COUNT(tc.id_cidade)
            FROM tabela_cobertura_fornecedor as tc
            WHERE tc.id_cidade = c.id_cidade
          ) as fornecedores
        FROM tabela_cidade as c
        HAVING fornecedores > 0
        ORDER BY fornecedores DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function coverageAreaCityByRegion($region) {
    global $conn;
    $sql = "
        SELECT
            c.nome as cidade,
            r.`Região` as regiao,
            (
                SELECT COUNT(tc.id_cidade)
                FROM tabela_cobertura_fornecedor as tc
                WHERE tc.id_cidade = c.id_cidade
            ) as fornecedores
        FROM tabela_cidade as c
        LEFT JOIN regiao as r
            ON UPPER(r.`Município`) = c.nome
        WHERE `r`.`Região` = :region
        HAVING fornecedores > 0
        ORDER BY fornecedores DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":region", $region);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function coverageAreaCityByUF($uf) {
    global $conn;
    $sql = "
        SELECT
          c.nome as cidade,
          r.UF as estado,
          (
            SELECT COUNT(tc.id_cidade)
            FROM tabela_cobertura_fornecedor as tc
            WHERE tc.id_cidade = c.id_cidade
          ) as fornecedores
        FROM tabela_cidade as c
        LEFT JOIN regiao as r
            ON UPPER(r.`Município`) = c.nome
        WHERE r.UF = :uf
        HAVING fornecedores > 0
        ORDER BY fornecedores DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":uf", $uf);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function providerWithContractByUF($uf) {
    global $conn;
    $sql = '
        SELECT
            f.nome as nome,
            COUNT(fdc.id_doc) AS contratos,
            CONCAT(
                (SELECT GROUP_CONCAT(DISTINCT e2.nome SEPARATOR ", ")
                    FROM tabela_cobertura_fornecedor AS tcf2
                    INNER JOIN tabela_cidade as c2
                        ON tcf2.id_cidade = c2.id_cidade
                    INNER JOIN tabela_estado as e2
                        ON e2.id_estado = c2.id_estado
                    WHERE tcf2.id_fornecedor = f.id_fornecedor
                    GROUP BY NULL),
                ",") AS cobertura_estado
        FROM fornecedor_doc_contratual AS fdc
        LEFT JOIN tabela_fornecedor AS f
            ON f.id_fornecedor = fdc.id_fornecedor
        WHERE fdc.statusFlag = "ATIVO" AND f.status_flag = "ATIVO"
        GROUP BY f.nome
        HAVING cobertura_estado LIKE CONCAT("% ", :uf, ",%")
    ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":uf", $uf);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function providerWithoutContractByUF($ufName, $ufInitials) {
    global $conn;
    $sql = '
        SELECT p.Nome_Fantasia as nome
        FROM provedores AS p
        WHERE
            p.UF_Sede = :ufi AND
            p.CNPJCPF NOT IN (
                SELECT _f.cnpj
                FROM (
                    SELECT f.cnpj as cnpj, f.nome as nome,
                    COUNT(fdc.id_doc) AS contratos,
                    CONCAT(
                        (SELECT GROUP_CONCAT(DISTINCT e2.nome SEPARATOR ", ")
                         FROM tabela_cobertura_fornecedor AS tcf2
                         INNER JOIN tabela_cidade as c2
                           ON tcf2.id_cidade = c2.id_cidade
                         INNER JOIN tabela_estado as e2
                           ON e2.id_estado = c2.id_estado
                         WHERE tcf2.id_fornecedor = f.id_fornecedor
                         GROUP BY NULL),
                         ",") AS cobertura_estado
                    FROM fornecedor_doc_contratual AS fdc
                    LEFT JOIN tabela_fornecedor AS f
                        ON f.id_fornecedor = fdc.id_fornecedor
                    WHERE fdc.statusFlag = "ATIVO" AND f.status_flag = "ATIVO"
                    GROUP BY f.nome
                    HAVING cobertura_estado LIKE CONCAT("% ", :uf, ",%")) as _f
                WHERE _f.cnpj IS NOT NULL)
    ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":ufi", $ufInitials);
    $stmt->bindParam(":uf", $ufName);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function providerWithContractByRegion($region) {
    global $conn;
    $sql = '
        SELECT
            f.nome as nome,
            COUNT(fdc.id_doc) AS contratos,
            CONCAT(
             (SELECT GROUP_CONCAT(DISTINCT r3.`Região` SEPARATOR ", ")
                FROM tabela_cobertura_fornecedor AS tcf3
                INNER JOIN tabela_cidade as c3
                    ON tcf3.id_cidade = c3.id_cidade
                INNER JOIN regiao AS r3
                    ON UPPER(r3.`Município`) = c3.nome
                WHERE tcf3.id_fornecedor = f.id_fornecedor
                GROUP BY NULL
            ), ",") AS cobertura_regiao
        FROM fornecedor_doc_contratual AS fdc
        LEFT JOIN tabela_fornecedor AS f
            ON f.id_fornecedor = fdc.id_fornecedor
        WHERE fdc.statusFlag = "ATIVO" AND f.status_flag = "ATIVO"
        GROUP BY f.nome
        HAVING cobertura_regiao LIKE CONCAT("% ", :region, ",%")
    ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":region", $region);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function providerWithContractByCity($city) {
    global $conn;
    $sql = '
        SELECT
            f.nome as nome,
            COUNT(fdc.id_doc) AS contratos,
            CONCAT(
             (SELECT GROUP_CONCAT(DISTINCT c1.nome SEPARATOR ", ")
                FROM tabela_cobertura_fornecedor AS tcf1
                INNER JOIN tabela_cidade as c1
                    ON tcf1.id_cidade = c1.id_cidade
                WHERE tcf1.id_fornecedor = f.id_fornecedor
                GROUP BY NULL
             ), ",") AS cobertura_cidade
        FROM fornecedor_doc_contratual AS fdc
        LEFT JOIN tabela_fornecedor AS f
            ON f.id_fornecedor = fdc.id_fornecedor
        WHERE fdc.statusFlag = "ATIVO" AND f.status_flag = "ATIVO"
        GROUP BY f.nome
        HAVING cobertura_cidade LIKE CONCAT("% ", :city, ",%")
    ';

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":city", $city);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function providerWithContract() {
    global $conn;
    $sql = '
        SELECT
            f.nome as nome,
            COUNT(fdc.id_doc) AS contratos
        FROM fornecedor_doc_contratual AS fdc
        LEFT JOIN tabela_fornecedor AS f
            ON f.id_fornecedor = fdc.id_fornecedor
        WHERE fdc.statusFlag = "ATIVO" AND f.status_flag = "ATIVO"
        GROUP BY f.nome
    ';

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
