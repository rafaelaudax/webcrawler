<?php

use WebCrawler\Handler\MercedesBenz\Crawler;
use WebCrawler\Handler\MercedesBenz\File\Csv;
use WebCrawler\Handler\MercedesBenz\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
