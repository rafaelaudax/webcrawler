<?php

use WebCrawler\Handle\MercedesBenz\Crawler;
use WebCrawler\Handle\MercedesBenz\File\Csv;
use WebCrawler\Handle\MercedesBenz\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];