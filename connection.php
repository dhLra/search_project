<?php

$hostName = "127.0.0.1";
$dbName = "provedores";
$dbLogin = "root";
$dbPass = "";

try {
    $conn = new pdo('mysql:host=' . $hostName . '; dbname=' . $dbName, $dbLogin, $dbPass);
} catch (PDOException $e) {
    echo "Erro foi " . $e->getMessage();
}

if (isset($_POST['submit'])) {
    $paremetro = ($_POST['param']);
    $tipo = ($_POST['type']);

    $search_param = $paremetro;
    // Resultados da busca
    $result = []; 

    switch ($tipo) {
        case 0:
            $search_type = "ASN";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `ASN` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;

        case 1:
            $search_type = "CNPJ/CPF";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `CNPJCPF` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;

        case 2:
            $search_type = "Razão Social";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `NomeRazão_Social` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;

        case 3:
            $search_type = "Serviço";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `Nome_do_Serviço` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;

        case 4:
            $search_type = "Minicípio";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `Municipio` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;

        case 5:
            $search_type = "UF";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `UF_Sede` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;

        case 6:
            $search_type = "CEP";
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `CEP_Sede` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            
            break;
    }

    require __DIR__ . '/results.php';
    require __DIR__ . '/result_provider.php';
}

/*
$nome = "%" . trim($_GET['param']) . "%";
$sth = $conn->prepare('SELECT * FROM `provedores` WHERE `Municipio` LIKE :nome');
$sth->bindParam(':nome', $nome, PDO::PARAM_STR);
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);


exit;
*/
?>
