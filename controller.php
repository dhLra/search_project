<?php

require __DIR__ . "/statistics.php";

$body = file_get_contents("php://input");
$post = json_decode($body, true);

switch ($post["action"]) {
    case "statistic/provider/city":
        providerCityStatistics();
        break;

    case "statistic/provider/uf":
        providerUFStatistics();
        break;

    case "statistic/provider/region":
        providerRegionStatistics();
        break;
}

function providerCityStatistics() {
    global $post;
    echo json_encode([
        "provider" => totalProviderBy("Municipio", $post["city"])["provedores"],
        "asn" => totalASNBy("Municipio", $post["city"])["provedores"],
        "isp" => totalISPBy("Municipio", $post["city"])["provedores"],
    ]);
}

function providerUFStatistics() {
    global $post;
    echo json_encode([
        "provider" => totalProviderBy("UF_Sede", $post["uf"])["provedores"],
        "asn" => totalASNBy("UF_Sede", $post["uf"])["provedores"],
        "isp" => totalISPBy("UF_Sede", $post["uf"])["provedores"],
    ]);
}

function providerRegionStatistics() {
    global $post;
    echo json_encode([
        "provider" => totalProviderBy("Regiao", $post["region"])["provedores"],
        "asn" => totalASNBy("Regiao", $post["region"])["provedores"],
        "isp" => totalISPBy("Regiao", $post["region"])["provedores"],
    ]);
}
