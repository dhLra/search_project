<?php

require __DIR__ . '/auth.php';
require __DIR__ . "/statistics.php";

$estadosBrasileiros = [
    'AC'=>'Acre',
    'AL'=>'Alagoas',
    'AP'=>'Amapá',
    'AM'=>'Amazonas',
    'BA'=>'Bahia',
    'CE'=>'Ceará',
    'DF'=>'Distrito Federal',
    'ES'=>'Espírito Santo',
    'GO'=>'Goiás',
    'MA'=>'Maranhão',
    'MT'=>'Mato Grosso',
    'MS'=>'Mato Grosso do Sul',
    'MG'=>'Minas Gerais',
    'PA'=>'Pará',
    'PB'=>'Paraíba',
    'PR'=>'Paraná',
    'PE'=>'Pernambuco',
    'PI'=>'Piauí',
    'RJ'=>'Rio de Janeiro',
    'RN'=>'Rio Grande do Norte',
    'RS'=>'Rio Grande do Sul',
    'RO'=>'Rondônia',
    'RR'=>'Roraima',
    'SC'=>'Santa Catarina',
    'SP'=>'São Paulo',
    'SE'=>'Sergipe',
    'TO'=>'Tocantins'
];

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

    case "statistic/city/circuit-active":
        activeCityCircuitsStatistics();
        break;

    case "statistic/region-city/circuit-active":
        activeCityRegionCircuitsStatistics();
        break;

    case "statistic/uf-city/circuit-active":
        activeCityUFCircuitsStatistics();
        break;

    case "statistic/city/area-coverage":
        areaCoverageStatistics();
        break;

    case "statistic/uf-city/area-coverage":
        areaCoverageUfStatistics();
        break;

    case "statistic/region-city/area-coverage":
        areaCoverageRegionStatistics();
        break;

    case "statistic/uf-provider/homologated":
        homologatedProvidersUfStatistics();
        break;

    case "statistic/region-provider/homologated":
        homologatedProvidersRegionStatistics();
        break;

    case "statistic/city-provider/homologated":
        homologatedProvidersCityStatistics();
        break;

    case "statistic/provider/homologated":
        homologatedProvidersStatistics();
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

function activeCityCircuitsStatistics() {
    global $post;
    echo json_encode([
        "circuits" => activeCircuitsByCity($post["city"]),
    ]);
}

function activeCityRegionCircuitsStatistics() {
    global $post;
    echo json_encode([
        "circuits" => activeCircuitsByCityRegion($post["region"]),
    ]);
}

function activeCityUFCircuitsStatistics() {
    global $post;
    echo json_encode([
        "circuits" => activeCircuitsByCityUF($post["uf"]),
    ]);
}

function areaCoverageStatistics() {
    echo json_encode([
        "cities" => coverageAreaCity(),
    ]);
}

function areaCoverageUfStatistics() {
    global $post;
    echo json_encode([
        "cities" => coverageAreaCityByUF($post["uf"]),
    ]);
}

function areaCoverageRegionStatistics() {
    global $post;
    echo json_encode([
        "cities" => coverageAreaCityByRegion($post["region"]),
    ]);
}

function homologatedProvidersUfStatistics() {
    global $post;
    echo json_encode([
        "homologated" => providerWithContractByUF($post["uf"]),
        /* "notHomologated" => providerWithoutContractByUF( */
        /*     $estadosBrasileiros[$post["uf"]], */
        /*     $post["uf"] */
        /* ) */
    ]);
}

function homologatedProvidersRegionStatistics() {
    global $post;
    echo json_encode([
        "homologated" => providerWithContractByRegion($post["region"]),
    ]);
}

function homologatedProvidersCityStatistics() {
    global $post;
    echo json_encode([
        "homologated" => providerWithContractByCity($post["city"]),
    ]);
}

function homologatedProvidersStatistics() {
    echo json_encode([
        "homologated" => providerWithContract(),
    ]);
}
