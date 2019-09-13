<?php

use WebCrawler\Handler\Megaron\Crawler;
use WebCrawler\Handler\Megaron\File\Csv;
use WebCrawler\Handler\Megaron\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
