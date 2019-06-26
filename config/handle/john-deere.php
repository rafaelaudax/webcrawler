<?php

return [
    'web' => \WebCrawler\Product\Web\JohnDeere::class,
    'crawler' => \WebCrawler\Product\Crawler\JohnDeere::class,
    'handle' => \WebCrawler\File\Csv\Handle\JohnDeere::class,
];