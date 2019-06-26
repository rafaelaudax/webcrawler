<?php

return [
    'web' => \WebCrawler\Product\Web\Megaron::class,
    'crawler' => \WebCrawler\Product\Crawler\Megaron::class,
    'handle' => \WebCrawler\File\Csv\Handle\Megaron::class,
];