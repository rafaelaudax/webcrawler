<?php

namespace WebCrawler\Handler\MercedesBenz;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handler\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = '.search-results .produtos-search .produto-search-title span';

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
        foreach ($domFilter->extract(['_text']) as $values) {
            [ $name, $code ] = array_map('trim', explode('(', $values));
            $code = str_replace(')', '', $code);
            $items[] = compact('code', 'name');
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
