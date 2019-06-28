<?php

namespace WebCrawler\Handle\Megaron;

use GuzzleHttp\Client;
use WebCrawler\Handle\Contract\Web as WebContract;

class Web extends WebContract
{
    const BASE_URL_DEFAULT = 'http://megaronpecas.com.br/';
    const URL_DEFAULT = 'categoria/21-scania';

    protected $clientOptions = [
        'base_uri' => self::BASE_URL_DEFAULT,
        'verify' => false,
    ];

    /**
     * @param Client $client
     * @param string $param
     * @param array $data
     * @return mixed
     */
    protected function makeRequest(Client $client, $param, $data)
    {
        return $client->postAsync(self::URL_DEFAULT, [
            'multipart' => [
                [ 'name' => 'cbusca', 'contents' => $param ]
            ]
        ]);
    }
}
