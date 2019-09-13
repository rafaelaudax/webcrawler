<?php

namespace WebCrawler\Handle\CaterpillarNew;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handle\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = 'h1.main_header';

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
        foreach ($domFilter->extract(['_text']) as $values) {
            $description = trim(str_replace("{$paramSearch}: ", '', $values));
            $items[] = compact('description');
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
