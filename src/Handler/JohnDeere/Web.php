<?php

namespace WebCrawler\Handler\JohnDeere;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use WebCrawler\Handler\Contract\Web as WebContract;

class Web extends WebContract
{
    const BASE_URL_DEFAULT = 'https://jdparts.deere.com/';
    const URL_DEFAULT = 'servlet/com.deere.u90.jdparts.view.servlets.partinfocontroller.PartDetails/';
    const NAME_QUERY_PARAM_DEFAULT = 'partSearchNumber';

    protected $clientOptions = [
        'base_uri' => self::BASE_URL_DEFAULT,
        'verify' => false,
        'cookies' => true,
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
            'form_params' => [
                'screenName' => 'JDSearch',
                'userAction' => 'exactSearch',
                self::NAME_QUERY_PARAM_DEFAULT => $param,
                'searchby' => 'complete_pn',
            ],
        ]);
    }
}
