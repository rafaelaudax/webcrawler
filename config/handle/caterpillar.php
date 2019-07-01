<?php

use WebCrawler\Handle\Caterpillar\Crawler;
use WebCrawler\Handle\Caterpillar\File\Csv;
use WebCrawler\Handle\Caterpillar\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];