<?php

namespace WebCrawler\Handle\MercedesBenz;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handle\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = '.search-results .produtos-search .produto-search-title span';

    /**
     * @param Response $result
     * @param $paramSearch
     * @return array|mixed
     */
    protected function handleItemSuccessful(Response $result, $paramSearch)
    {
        $data = $this->domFilter((string) $result->getBody(), self::CSS_SELECTOR);
        $items = [];
        foreach ($data->extract(['_text']) as $values) {
            list($name, $code) = array_map('trim', explode('(', $values));
            $code = str_replace(')', '', $code);
            $items[] = compact('paramSearch','code', 'name');
        }

        if ($items) {
            return $items;
        }

        return $items[] = [
            'paramSearch' => (string) $paramSearch,
            'code' => '',
            'name' => 'Código não encontrado',
        ];
    }

    /**
     * @param ClientException $result
     * @param $paramSearch
     * @return mixed|string
     */
    protected function handleItemUnsuccessful(ClientException $result, $paramSearch)
    {
        return $result->getMessage();
    }
}
