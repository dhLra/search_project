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

function getAllCities() {
    global $conn;

    $stmt = $conn->prepare('SELECT Município as cidade FROM regiao');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCitiesWithStates() {
    global $conn;

    $stmt = $conn->prepare('SELECT Município as cidade, UF as estado FROM regiao');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllStates() {
    global $conn;

    $stmt = $conn->prepare('SELECT UF as estado FROM regiao GROUP BY UF ORDER BY UF');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllRegions() {
    global $conn;

    $stmt = $conn->prepare('SELECT `Região` as regiao FROM regiao
                                GROUP BY `Região` ORDER BY `Região`');
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

function logUser($username, $password) {
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM `turing_usuario` WHERE login = :login');
    $stmt->bindParam(":login", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['senha'])) {
            return $user;
        }
    }

    return false;
}
