<?php

namespace WebCrawler\Handle\Megaron;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handle\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = '#listagem_produtos td a';

    /**
     * @param Response $result
     * @param $paramSearch
     * @return array|mixed
     */
    protected function handleItemSuccessful(Response $result, $paramSearch)
    {
        $data = $this->domFilter((string) $result->getBody(), self::CSS_SELECTOR);
        $item = [];
        foreach (array_chunk($data->extract(['_text']), 2) as $values) {
            list($code, $name) = $values;
            $item[] = compact('code', 'name');
        }

        if ($this->hasCode($paramSearch, $item)) {
            return $item[$this->getIndexCode($paramSearch, $item)];
        }

        return [
            'code' => (string) $paramSearch,
            'name' => 'Código não encontrado'
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

    /**
     * @param $code
     * @param $array
     * @return false|int|string
     */
    private function getIndexCode($code, $array)
    {
        return array_search($code, array_column($array, 'code'));
    }

    /**
     * @param $code
     * @param $array
     * @return bool
     */
    private function hasCode($code, $array)
    {
        return $this->getIndexCode($code, $array) !== false;
    }
}
