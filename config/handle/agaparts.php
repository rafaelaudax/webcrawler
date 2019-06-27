<?php

use WebCrawler\Handle\AgaParts\Crawler;
use WebCrawler\Handle\AgaParts\File\Csv;
use WebCrawler\Handle\AgaParts\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];