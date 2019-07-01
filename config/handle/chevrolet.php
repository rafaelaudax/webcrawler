<?php

use WebCrawler\Handle\Chevrolet\Crawler;
use WebCrawler\Handle\Chevrolet\File\Csv;
use WebCrawler\Handle\Chevrolet\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];