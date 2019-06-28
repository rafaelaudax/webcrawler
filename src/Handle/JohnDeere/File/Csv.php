<?php

namespace WebCrawler\Handle\JohnDeere\File;

use WebCrawler\Handle\Contract\File\Csv as CsvContract;

class Csv extends CsvContract
{
    public function handleResultRows($results)
    {
        $rows = [];
        return $rows;
    }

    /**
     * @return array
     */
    public function getHeaderSuccess()
    {
        $header = [];
        return $header;

    }

    /**
     * @return array
     */
    public function getHeaderUnsuccess()
    {
        $header = [];
        return $header;
    }

    /**
     * @return array
     */
    public function getHeaderReaderData()
    {
        $header = [''];
        return $header;
    }

    /**
     * @return string
     */
    public function getReaderDataParamSearch()
    {
        return '';
    }
}
