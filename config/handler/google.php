<?php

use WebCrawler\Handler\Google\Crawler;
use WebCrawler\Handler\Google\File\Csv;
use WebCrawler\Handler\Google\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
