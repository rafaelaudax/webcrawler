<?php

use WebCrawler\Handle\Sabo\Crawler;
use WebCrawler\Handle\Sabo\File\Csv;
use WebCrawler\Handle\Sabo\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];