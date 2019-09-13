<?php

use WebCrawler\Handle\Volvo\Crawler;
use WebCrawler\Handle\Volvo\File\Csv;
use WebCrawler\Handle\Volvo\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];
