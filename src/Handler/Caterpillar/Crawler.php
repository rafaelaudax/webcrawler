<?php

namespace WebCrawler\Handler\Caterpillar;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handler\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = '.product .product_title, .product .summary .product_meta .posted_in a';

    /**
     * @param Response $result
     * @param string $paramSearch
     * @param array $data
     * @return array|mixed
     */
    protected function HandlerItemSuccessful(Response $result, $paramSearch, $data)
    {
        $domFilter = $this->domFilter((string) $result->getBody(), self::CSS_SELECTOR);
        $items = [];
        foreach (array_chunk($domFilter->extract(['_text']), 2) as $values) {
            [$title, $category] = $values;
            $items[] = compact('title', 'category');
        }

        if (!$items) {
            $items[] = [
                'name' => 'Código não encontrado',
            ];
        }

        return $items;
    }

    /**
     * @param ClientException $result
     * @param string $paramSearch
     * @param array $data
     * @return mixed|string
     */
    protected function HandlerItemUnsuccessful(ClientException $result, $paramSearch, $data)
    {
        return [$result->getMessage()];
    }
}
