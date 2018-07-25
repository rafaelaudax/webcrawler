<?php

namespace WebCrawler\Product\Web;

use GuzzleHttp\Client;
use WebCrawler\Product\Web;

class JohnDeere extends Web
{
    const BASE_URL_DEFAULT = 'https://partscatalog.deere.com/';
    const URL_DEFAULT = 'jdrc/search/type/parts/equipment/338792/term/';

    protected $clientOptions = [
        'base_uri' => self::BASE_URL_DEFAULT,
        'verify' => false,
    ];

    protected function makeRequest(Client $client, $param)
    {
        return $client->getAsync(self::URL_DEFAULT . $param);
    }
}
