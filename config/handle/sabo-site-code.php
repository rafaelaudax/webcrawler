<?php

use WebCrawler\Handle\SaboSiteCode\Crawler;
use WebCrawler\Handle\SaboSiteCode\File\Csv;
use WebCrawler\Handle\SaboSiteCode\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];
