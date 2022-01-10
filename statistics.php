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
