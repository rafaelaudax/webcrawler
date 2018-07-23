<?php

namespace WebCrawler\Product;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class Crawler
{
    const CSS_SELECTOR = '.catalog__partlookup .catalog__partlookup-item .catalog__partlookup-item-data span';

    /**
     * @var \WebCrawler\Product\Web
     */
    private $web;

    /**
     * @var DomCrawler
     */
    private $domCrawler;

    /**
     * Crawler constructor.
     */
    public function __construct()
    {
        $this->web = new Web();
        $this->domCrawler = new DomCrawler();
    }

    /**
     * @return \WebCrawler\Product\Web
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @return DomCrawler
     */
    public function getDomCrawler()
    {
        return $this->domCrawler;
    }

    /**
     * @param array|\Iterator $params
     * @return Crawler
     */
    public function handleRequests($params)
    {
        $this->getWeb()->setQueryParam($params)->resolveAllPromises();
        return $this;
    }

    /**
     * @return \GuzzleHttp\Psr7\Response[]
     */
    public function getPagesSuccessful()
    {
        return $this->getWeb()->getResponsesSuccessful();
    }

    /**
     * @return \GuzzleHttp\Exception\ClientException[]
     */
    public function getPagesUnsuccessful()
    {
        return $this->getWeb()->getResponsesUnsuccessful();
    }

    /**
     * @return \Symfony\Component\DomCrawler\Crawler[]
     */
    public function getResultsSuccessful()
    {
        $results = [];
        foreach ($this->getPagesSuccessful() as $key => $page) {
            $this->getDomCrawler()->clear();
            $this->getDomCrawler()->add((string) $page->getBody());

            $results[$key] = $this->getDomCrawler()->filter(self::CSS_SELECTOR);
        }
        return $results;
    }

    /**
     * @return array
     */
    public function getResultsUnsuccessful()
    {
        $results = [];
        foreach ($this->getPagesUnsuccessful() as $key => $error) {
            $results[$key] = $error->getMessage();
        }
        return $results;
    }

    public function getFormattedResult($successful = true)
    {
        $resultsFormatted = [];

        $results = $successful ? $this->getResultsSuccessful() : $this->getResultsUnsuccessful();
        foreach ($results as $key => $result) {
            $item = $result;
            if (!is_string($result)) {
                $item = $this->handleItemSuccessful($result);
            }
            $resultsFormatted[$key] = $item;
        }
        return $resultsFormatted;
    }

    /**
     * @param DomCrawler $result
     * @return array
     */
    private function handleItemSuccessful(DomCrawler $result)
    {
        $item = [];
        foreach (array_chunk($result->extract(['_text']), 3) as $values) {
            list($sku, $description, $brand) = $values;
            $item[] = compact('sku', 'description', 'brand');
        }
        return $item;
    }
}
