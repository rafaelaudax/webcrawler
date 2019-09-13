<?php

use WebCrawler\Handler\SaboSiteCode\Crawler;
use WebCrawler\Handler\SaboSiteCode\File\Csv;
use WebCrawler\Handler\SaboSiteCode\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
