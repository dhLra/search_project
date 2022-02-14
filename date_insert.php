<?php

$hostName = "database";
$dbName = "provedores";
$dbLogin = "root";
$dbPass = "GDS3243!sdfN";

try {
    $conn = new pdo('mysql:host=' . $hostName . '; dbname=' . $dbName, $dbLogin, $dbPass);
} catch (PDOException $e) {
    echo "Erro foi " . $e->getMessage();
}

$tsv = fopen('/home/jjaeger/pc-b/Downloads/buscador_provedores.tsv', 'r');

$first = true;
while (!feof($tsv)) {
    $line = fgets($tsv, 2048);
    $data = str_getcsv($line, "\t");

    if ($first) {
        $first = false;
        continue;
    }

    $cnpj = $data[3];
    $dataDeInclusao = $data[11];

    $dataDeInclusao = DateTime::createFromFormat('d/m/Y H:i', $dataDeInclusao);
    if ($dataDeInclusao) {
        $dataDeInclusao = $dataDeInclusao->format("Y-m-d H:i:s");

        $stmt = $conn->prepare(
                "UPDATE provedores SET Data_de_Inclusão = :valor
                WHERE CNPJCPF = :cond"
                );

        $stmt->bindParam(':valor', $dataDeInclusao);
        $stmt->bindParam(':cond', $cnpj);

        echo $stmt->execute(). " Data $dataDeInclusao\n";
    } else {
        echo "Data $data[11] inválida!\n";
    }
}

fclose($tsv);
