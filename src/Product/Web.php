<?php

namespace WebCrawler\Product;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use http\Exception\InvalidArgumentException;

class Web
{
    const BASE_URL_DEFAULT = 'https://www.aga-parts.com/';
    const URL_DEFAULT = 'search';
    const NAME_QUERY_PARAM_DEFAULT = 'p';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $responses;

    /**
     * @var array
     */
    protected $promises = [];

    /**
     * @var array
     */
    protected $queryParam = [];

    /**
     * @var string
     */
    protected $nameQueryParam;

    protected function getClient($url = false)
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => $url ? $url : self::BASE_URL_DEFAULT,
                'verify' => false,
            ]);
        }
        return $this->client;
    }

    /**
     * @param array $queryParam
     * @return $this
     */
    public function setQueryParam(array $queryParam)
    {
        $this->queryParam = $queryParam;
        return $this;
    }

    /**
     * @return array
     */
    public function getQueryParam()
    {
        return $this->queryParam ? $this->queryParam : [];
    }

    /**
     * @return string
     */
    public function getNameQueryParam()
    {
        return $this->nameQueryParam ? $this->nameQueryParam : self::NAME_QUERY_PARAM_DEFAULT;
    }

    /**
     * @param string $nameQueryParam
     */
    public function setNameQueryParam($nameQueryParam)
    {
        $this->nameQueryParam = $nameQueryParam;
    }

    /**
     *
     */
    protected function makePromises()
    {
        foreach ($this->getQueryParam() as $queryParam) {
            $this->promises[] = $this->getClient()->getAsync('search', [
                'query' => [$this->getNameQueryParam() => $queryParam]
            ]);
        }
    }

    /**
     * @return $this
     */
    public function resolveAllPromises()
    {
        $this->makePromises();
        $this->responses = Promise\settle($this->promises)->wait();
        return $this;
    }

    /**
     * @return array
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param array $responses
     */
    public function setResponses($responses)
    {
        $this->responses = $responses;
    }

}
