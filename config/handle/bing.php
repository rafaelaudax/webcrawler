<?php

use WebCrawler\Handle\Bing\Crawler;
use WebCrawler\Handle\Bing\File\Csv;
use WebCrawler\Handle\Bing\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];
