<?php

use WebCrawler\Handler\ValtraCase\Crawler;
use WebCrawler\Handler\ValtraCase\File\Csv;
use WebCrawler\Handler\ValtraCase\Web;

return [
    'web' => Web::class,
    'crawler' => Crawler::class,
    'Handler' => Csv::class,
];
