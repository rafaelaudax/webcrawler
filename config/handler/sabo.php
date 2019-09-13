<?php

use WebCrawler\Handler\Sabo\Crawler;
use WebCrawler\Handler\Sabo\File\Csv;
use WebCrawler\Handler\Sabo\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
