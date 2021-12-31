<?php
$hostName = "127.0.0.1";
$dbName = "provedores";
$dbLogin = "mvp";
$dbPass = "fir3link4";

try {
    $conn = new pdo('mysql:host=' . $hostName . '; dbname=' . $dbName, $dbLogin, $dbPass);
} catch (PDOException $e) {
    echo "Erro foi " . $e->getMessage();
}

function getAllCities() {
    global $conn;

    $stmt = $conn->prepare('SELECT Município as cidade FROM regiao');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProviders() {
    global $conn;

    $stmt = $conn->prepare('SELECT Nome_Fantasia as nome FROM provedores');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAllProvidersRazaoSocial() {
    global $conn;

    $stmt = $conn->prepare('SELECT `NomeRazão_Social` as nome FROM provedores');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
