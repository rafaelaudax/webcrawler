<?php

use WebCrawler\Handler\Chevrolet\Crawler;
use WebCrawler\Handler\Chevrolet\File\Csv;
use WebCrawler\Handler\Chevrolet\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
