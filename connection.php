<?php

$hostName = "localhost";
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

    switch ($tipo) {

        case 0:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `ASN` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;

        case 1:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `CNPJCPF` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;

        case 2:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `NomeRazão_Social` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;

        case 3:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `Nome_do_Serviço` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;

        case 4:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `Municipio` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

           foreach($sth as $row){
                echo "<button></button>";
            }
            
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;

        case 5:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `UF_Sede` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;

        case 6:
            $nome = "%" . $paremetro . "%";
            $sth = $conn->prepare('SELECT * FROM `provedores` WHERE `CEP_Sede` LIKE :nome');
            $sth->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($result);
            break;
    }
}

/*
$nome = "%" . trim($_GET['param']) . "%";
$sth = $conn->prepare('SELECT * FROM `provedores` WHERE `Municipio` LIKE :nome');
$sth->bindParam(':nome', $nome, PDO::PARAM_STR);
$sth->execute();

$result = $sth->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($result);
exit;
*/
?>