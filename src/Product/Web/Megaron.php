<?php

namespace WebCrawler\Product\Web;

use GuzzleHttp\Client;
use WebCrawler\Product\Web;

class Megaron extends Web
{
    const BASE_URL_DEFAULT = 'http://megaronpecas.com.br/';
    const URL_DEFAULT = 'categoria/21-scania';

    protected $clientOptions = [
        'base_uri' => self::BASE_URL_DEFAULT,
        'verify' => false,
    ];

    protected function makeRequest(Client $client, $param)
    {
        return $client->postAsync(self::URL_DEFAULT, [
            'multipart' => [
                [ 'name' => 'cbusca', 'contents' => $param ]
            ]
        ]);
    }
}
