<?php

namespace WebCrawler\Product\Crawler;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Product\Crawler;

class JohnDeere extends Crawler
{
    const CSS_SELECTOR = '.viewContent .catalogResults.widthLimit .partsResult .col-lg-9.col-xm-9.col-md-9.col-xl-9.col-xs-6 span';

    /**
     * @param Response $result
     * @param $paramSearch
     * @return mixed
     */
    protected function handleItemSuccessful(Response $result, $paramSearch)
    {
        $data = $this->domFilter((string) $result->getBody(), self::CSS_SELECTOR);
        $item = [];
        foreach (array_chunk($data->extract(['_text']), 3) as $values) {
            list($sku, $description, $brand) = $values;
            $item[] = compact('sku', 'description', 'brand');
        }
        return $item;
    }

    /**
     * @param ClientException $result
     * @param $paramSearch
     * @return mixed
     */
    protected function handleItemUnsuccessful(ClientException $result, $paramSearch)
    {
        // TODO: Implement handleItemUnsuccessful() method.
    }
}
