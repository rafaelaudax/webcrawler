<?php

namespace WebCrawler\Product;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;

abstract class Web
{
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
    protected $params = [];

    /**
     * @var array
     */
    protected $clientOptions= [];

    /**
     * @param Client $client
     * @param $param
     * @return mixed
     */
    abstract protected function makeRequest(Client $client, $param);

    /**
     * @return Client
     */
    protected function getClient()
    {
        if (!$this->client) {
            $this->client = new Client($this->getClientOptions());
        }
        return $this->client;
    }

    /**
     * @return PromiseInterface[]
     */
    public function getPromises()
    {
        return $this->promises;
    }

    /**
     * @param PromiseInterface[] $promises
     */
    public function setPromises($promises)
    {
        $this->promises = $promises;
    }

    /**
     * @param $key
     * @param PromiseInterface $promise
     */
    public function addPromises($key, $promise)
    {
        $this->promises[$key] = $promise;
    }
    
    /**
     * @param array|\Iterator $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array|\Iterator
     */
    public function getParams()
    {
        return $this->params ?: [];
    }

    /**
     * @param array $clientOptions
     * @return Web
     */
    public function setClientOptions($clientOptions)
    {
        $this->clientOptions = $clientOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getClientOptions()
    {
        return $this->clientOptions ?: [];
    }

    /**
     * @return $this
     */
    protected function makePromises()
    {
        foreach ($this->getParams() as $param) {
            $this->addPromises($param, $this->makeRequest($this->getClient(), $param));
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function resolveAllPromises()
    {
        $this->makePromises();
        $this->setResponses(Promise\settle($this->getPromises())->wait());
        return $this;
    }

    /**
     * @return Response[]
     */
    public function getResponsesSuccessful()
    {
        $successful = [];
        foreach ($this->getResponses() as $key => $response) {
            if ($this->isSuccess($response)) {
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
            if ($this->isError($response)) {
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
        return isset($object['value']) && $object['value'] instanceof Response;
    }

    /**
     * @param $object
     * @return bool
     */
    public function isError($object)
    {
        return isset($object['value']) && $object['value'] instanceof ClientException;
    }

    public function clear()
    {
        $this->promises = [];
        $this->params = [];
    }
}
