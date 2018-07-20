<?php

require_once 'vendor/autoload.php';

$skus = ['T82612', 'AT203579'];

try {

    foreach ($responses as $response) {
        var_dump($response);
//        $crawler = new Crawler((string) $response->getBody());
//        $info = $crawler->filter(CSS_SELECTOR);
//
//        var_dump($info);
    }

} catch (Exception $e) {
    var_dump($e->getMessage());
}

