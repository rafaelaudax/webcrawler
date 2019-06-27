<?php

use WebCrawler\Handle\JohnDeere\Crawler;
use WebCrawler\Handle\JohnDeere\File\Csv;
use WebCrawler\Handle\JohnDeere\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];