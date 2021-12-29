<?php
$hostName = "127.0.0.1";
$dbName = "adabd";
$dbLogin = "adabduser";
$dbPass = "hightechsinuca1337";

try {
    $conn = new pdo('mysql:host=' . $hostName . '; dbname=' . $dbName, $dbLogin, $dbPass);
} catch (PDOException $e) {
    echo "Erro foi " . $e->getMessage();
}
