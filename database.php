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
