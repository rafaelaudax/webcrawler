<?php

namespace WebCrawler\Handle\ValtraCase;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handle\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = '#produtos-search-result-list .item .produto-name, #produtos-search-result-list .item .font-detalhes';

    /**
     * @param Response $result
     * @param string $paramSearch
     * @param array $data
     * @return array|mixed
     */
    protected function handleItemSuccessful(Response $result, $paramSearch, $data)
    {
        $domFilter = $this->domFilter((string) $result->getBody(), self::CSS_SELECTOR);
        $items = [];
        foreach (array_chunk($domFilter->extract(['_text']), 3) as $values) {
            [$name, $code, $brand] = $values;

            $code = str_replace('CÓDIGO: ', '', $code);
            $brand = str_replace([ 'MARCA: ', 'Clique aqui para escolher' ], '', $brand);

            $items[] = compact('code', 'name', 'brand');
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
    protected function handleItemUnsuccessful(ClientException $result, $paramSearch, $data)
    {
        return [$result->getMessage()];
    }
}
