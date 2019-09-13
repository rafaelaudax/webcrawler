<?php

namespace WebCrawler\Handler\JohnDeere;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use WebCrawler\Handler\Contract\Crawler as CrawlerContract;

class Crawler extends CrawlerContract
{
    const CSS_SELECTOR = 'form[name="PartDetails"] > table > tr:nth-of-type(2) > td:last-of-type > table > tr';

    /**
     * @param Response $result
     * @param string $paramSearch
     * @param array $data
     * @return mixed
     */
    protected function HandlerItemSuccessful(Response $result, $paramSearch, $data)
    {
        $domFilter = $this->domFilter((string) $result->getBody(), self::CSS_SELECTOR);
        $items = [];
        foreach ($domFilter->extract(['_text']) as $values) {
            $values = mb_convert_encoding($values, 'ISO-8859-1', 'UTF-8');
            $values = trim(preg_replace('/[\s  ]+/', ' ', $values));
            if (strpos($values, 'Descrição') !== false) {
                $values = trim(str_replace('Descrição:', '', $values));
                $items[] = compact('values');
            }
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
     * @return mixed
     */
    protected function HandlerItemUnsuccessful(ClientException $result, $paramSearch, $data)
    {
        return [$result->getMessage()];
    }
}
