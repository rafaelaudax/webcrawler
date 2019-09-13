<?php

use WebCrawler\Handler\CaterpillarNew\Crawler;
use WebCrawler\Handler\CaterpillarNew\File\Csv;
use WebCrawler\Handler\CaterpillarNew\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
