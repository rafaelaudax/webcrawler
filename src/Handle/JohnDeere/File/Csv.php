<?php

namespace WebCrawler\Handle\JohnDeere\File;

use Iterator;
use WebCrawler\Handle\Contract\File\Csv as CsvContract;

class Csv extends CsvContract
{
    public function handleResultRows($results)
    {
        $rows = [];
        return $rows;
    }

    public function getHeader()
    {
        $header = [];
        return $header;
    }

    /**
     * @return array|Iterator
     */
    public function getParamsSearch()
    {
        $params = $this->setFileData(FILE_DATA)->getReaderData()->fetchColumn();
        if ($params) {
            return array_chunk(iterator_to_array($params), 10);
        }
        return [];
    }
}
