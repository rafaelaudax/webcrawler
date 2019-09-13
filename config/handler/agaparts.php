<?php

use WebCrawler\Handler\AgaParts\Crawler;
use WebCrawler\Handler\AgaParts\File\Csv;
use WebCrawler\Handler\AgaParts\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
