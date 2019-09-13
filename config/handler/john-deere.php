<?php

use WebCrawler\Handler\JohnDeere\Crawler;
use WebCrawler\Handler\JohnDeere\File\Csv;
use WebCrawler\Handler\JohnDeere\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
