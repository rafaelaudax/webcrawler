<?php

namespace WebCrawler\Handler\Caterpillar;

use GuzzleHttp\Client;
use WebCrawler\Handler\Contract\Web as WebContract;

class Web extends WebContract
{
    const BASE_URL_DEFAULT = 'https://www.vemap.com.br/';
    const URL_DEFAULT = '';
    const NAME_QUERY_PARAM_DEFAULT = 's';

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
        return $client->getAsync(self::URL_DEFAULT, [
            'query' => [
                self::NAME_QUERY_PARAM_DEFAULT => $this->clearParam($param),
                'post_type' => 'product',
            ],
        ]);
    }

    /**
     * @param string $param
     * @return mixed
     */
    private function clearParam($param)
    {
        return str_replace('-','', $param);
    }
}
