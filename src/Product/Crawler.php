<?php

namespace WebCrawler\Product;

use  WebCrawler\Product\Web;
use  WebCrawler\Product\Parser;

class Crawler
{
    private $web;
    private $parser;

    /**
     * Crawler constructor.
     */
    public function __construct()
    {
        $this->web = new Web();
        $this->parser = new Parser();
    }
}
