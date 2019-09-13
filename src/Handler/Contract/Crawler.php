<?php

namespace WebCrawler\Handler\Contract;

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
     * @param string $paramSearch
     * @param array $data
     * @return mixed
     */
    abstract protected function HandlerItemSuccessful(Response $result, $paramSearch, $data);

    /**
     * @param ClientException $result
     * @param string $paramSearch
     * @param array $data
     * @return mixed
     */
    abstract protected function HandlerItemUnsuccessful(ClientException $result, $paramSearch, $data);

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
     * @param string $html
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
    public function getFormattedResults($successful)
    {
        $resultsFormatted = [];
        foreach ($this->getResults() as $key => $result) {
            $this->clearDomCrawler();

            $resultCrawler = $successful
                ? $this->HandlerItemSuccessful($result['response'], $key, $result['data'])
                : $this->HandlerItemUnsuccessful($result['response'], $key, $result['data']);

            $resultsFormatted[$key] = [
                'resultCrawler' => $resultCrawler,
                'data' => $result['data'],
            ];
        }
        return $resultsFormatted;
    }
}
