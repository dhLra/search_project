<?php

require __DIR__ . '/database.php';

$statistics = [];

// Total de provedores
$stmt = $conn->prepare('SELECT count(id) as total FROM provedores');
$stmt->execute();
$statistics['total'] = ($stmt->fetch(PDO::FETCH_ASSOC))['total'];

// Total de provedores por cidade
$stmt = $conn->prepare('SELECT p.Municipio as cidade, COUNT(p.Municipio) as total FROM provedores as p GROUP BY p.Municipio');
$stmt->execute();
$statistics['by_city'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
