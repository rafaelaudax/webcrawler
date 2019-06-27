<?php

use WebCrawler\Handle\Megaron\Crawler;
use WebCrawler\Handle\Megaron\File\Csv;
use WebCrawler\Handle\Megaron\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];