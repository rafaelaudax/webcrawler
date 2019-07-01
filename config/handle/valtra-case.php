<?php

use WebCrawler\Handle\ValtraCase\Crawler;
use WebCrawler\Handle\ValtraCase\File\Csv;
use WebCrawler\Handle\ValtraCase\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];