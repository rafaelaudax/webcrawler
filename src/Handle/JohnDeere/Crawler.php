<?php

namespace WebCrawler\Handle\JohnDeere;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handle\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = '.viewContent .catalogResults.widthLimit .partsResult .col-lg-9.col-xm-9.col-md-9.col-xl-9.col-xs-6 span';

    /**
     * @param Response $result
     * @param string $paramSearch
     * @param array $data
     * @return mixed
     */
    protected function handleItemSuccessful(Response $result, $paramSearch, $data)
    {
        // TODO: Implement handleItemSuccessful() method.
        return [];
    }

    /**
     * @param ClientException $result
     * @param string $paramSearch
     * @param array $data
     * @return mixed
     */
    protected function handleItemUnsuccessful(ClientException $result, $paramSearch, $data)
    {
        // TODO: Implement handleItemUnsuccessful() method.
        return [];
    }
}
