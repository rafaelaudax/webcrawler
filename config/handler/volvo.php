<?php

use WebCrawler\Handler\Volvo\Crawler;
use WebCrawler\Handler\Volvo\File\Csv;
use WebCrawler\Handler\Volvo\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
