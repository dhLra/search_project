<?php

require __DIR__ . "/statistics.php";

$body = file_get_contents("php://input");
$post = json_decode($body, true);

switch ($post["action"]) {
    case "statistic/provider/uf":
        providerUFStatistics();
        break;
}

function providerUFStatistics() {
    global $post;
    echo json_encode([
        "provider" => totalProviderByUF($post["uf"])["provedores"],
        "asn" => quantASNByUf($post["uf"])["provedores"],
        "isp" => quantISPByUf($post["uf"])["provedores"],
    ]);
}
