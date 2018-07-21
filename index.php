<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

use WebCrawler\Product\Crawler;

require_once __DIR__. '/vendor/autoload.php';

$crawler = new Crawler();

$crawler->handleRequests([
    'T82612',
    '0005721',
    '0032143',
    '5P1076',
    '0029488',
    '0005722',
    '0005875',
]);

$resultsSuccessful = $crawler->getFormattedResult();
$resultsUnsuccessful = $crawler->getFormattedResult(false);
