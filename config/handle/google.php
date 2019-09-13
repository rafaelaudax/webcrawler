<?php

use WebCrawler\Handle\Google\Crawler;
use WebCrawler\Handle\Google\File\Csv;
use WebCrawler\Handle\Google\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];
