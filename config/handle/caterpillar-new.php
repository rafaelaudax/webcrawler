<?php

use WebCrawler\Handle\CaterpillarNew\Crawler;
use WebCrawler\Handle\CaterpillarNew\File\Csv;
use WebCrawler\Handle\CaterpillarNew\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'handle' => Csv::class,
];
