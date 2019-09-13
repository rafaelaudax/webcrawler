<?php

use WebCrawler\Handler\Bing\Crawler;
use WebCrawler\Handler\Bing\File\Csv;
use WebCrawler\Handler\Bing\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
