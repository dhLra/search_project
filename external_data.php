<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

function searchASNUpstreams($asn) {
    try {
        $client = new Client([
                'base_uri' => 'https://api.bgpview.io/',
        ]);

        $response = $client->request('GET', "/asn/$asn/upstreams");
        $body = $response->getBody()->getContents();
        $responseJson = json_decode($body, true);

        /* echo "<pre>"; */
        /* var_dump($responseJson['data']); */
        /* echo "</pre>"; */

        return $responseJson['data'];
    } catch (Exception $e) {
        return null;
    }
}

function searchASNIXs($asn) {
    try {
        $client = new Client([
                'base_uri' => 'https://api.bgpview.io/',
        ]);

        $response = $client->request('GET', "/asn/$asn/ixs");
        $body = $response->getBody()->getContents();
        $responseJson = json_decode($body, true);

        /* echo "<pre>"; */
        /* var_dump($responseJson['data']); */
        /* echo "</pre>"; */

        return $responseJson['data'];
    } catch (Exception $e) {
        return null;
    }
}
