<?php

namespace WebCrawler\Product;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;

class Web
{
    const BASE_URL_DEFAULT = 'https://www.aga-parts.com/';
    const URL_DEFAULT = 'search';
    const NAME_QUERY_PARAM_DEFAULT = 'q';

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

    /**
     * @param bool $url
     * @return Client
     */
    protected function getClient($url = false)
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => $url ?: self::BASE_URL_DEFAULT,
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
        return $this->queryParam ?: [];
    }

    /**
     * @return string
     */
    public function getNameQueryParam()
    {
        return $this->nameQueryParam ?: self::NAME_QUERY_PARAM_DEFAULT;
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
            $this->promises[$queryParam] = $this->getClient()->getAsync('search', [
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
        $this->setResponses(Promise\settle($this->promises)->wait());
        return $this;
    }

    /**
     * @return Response[]
     */
    public function getResponsesSuccessful()
    {
        $successful = [];
        foreach ($this->getResponses() as $key => $response) {
            if ($this->isSuccess($response['value'])) {
                $successful[$key] = $response['value'];
            }
        }
        return $successful;
    }

    /**
     * @return ClientException[]
     */
    public function getResponsesUnsuccessful()
    {
        $unsuccessful = [];
        foreach ($this->getResponses() as $key => $response) {
            if ($this->isError($response['value'])) {
                $unsuccessful[$key] = $response['value'];
            }
        }
        return $unsuccessful;
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

    /**
     * @param $object
     * @return bool
     */
    public function isSuccess($object)
    {
        return $object instanceof Response;
    }

    /**
     * @param $object
     * @return bool
     */
    public function isError($object)
    {
        return $object instanceof ClientException;
    }
}
