<?php

namespace WebCrawler\Product;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

abstract class Crawler
{
    /**
     * @var DomCrawler
     */
    private $domCrawler;

    /**
     * @var array 
     */
    protected $results = [];

    /**
     * @param Response $result
     * @param $paramSearch
     * @return mixed
     */
    abstract protected function handleItemSuccessful(Response $result, $paramSearch);

    /**
     * @param ClientException $result
     * @param $paramSearch
     * @return mixed
     */
    abstract protected function handleItemUnsuccessful(ClientException $result, $paramSearch);

    /**
     * Crawler constructor.
     */
    public function __construct()
    {
        $this->setDomCrawler(new DomCrawler());
    }

    /**
     * @param DomCrawler $domCrawler
     */
    public function setDomCrawler($domCrawler)
    {
        $this->domCrawler = $domCrawler;
    }

    /**
     * @return DomCrawler
     */
    public function getDomCrawler()
    {
        return $this->domCrawler;
    }

    /**
     * @param array $results
     * @return Crawler
     */
    public function setResults($results)
    {
        $this->results = $results;
        return $this;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return $this
     */
    public function clearDomCrawler()
    {
        $this->getDomCrawler()->clear();
        return $this;
    }

    /**
     * @param $html
     * @param string $rule
     * @return DomCrawler
     */
    protected function domFilter($html, $rule)
    {
        $this->getDomCrawler()->add($html);
        return $this->getDomCrawler()->filter($rule);
    }

    /**
     * @param bool $successful
     * @return array
     */
    public function getFormattedResults($successful = true)
    {
        $resultsFormatted = [];
        foreach ($this->getResults() as $key => $result) {
            $this->clearDomCrawler();
            $resultsFormatted[$key] = $successful
                    ? $this->handleItemSuccessful($result, $key)
                    : $this->handleItemUnsuccessful($result, $key);
        }
        return $resultsFormatted;
    }
}
