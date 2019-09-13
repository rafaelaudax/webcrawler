<?php

use WebCrawler\Handler\Caterpillar\Crawler;
use WebCrawler\Handler\Caterpillar\File\Csv;
use WebCrawler\Handler\Caterpillar\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
