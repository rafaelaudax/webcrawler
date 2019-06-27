<?php

namespace WebCrawler\Handle\MercedesBenz\File;

use Iterator;
use WebCrawler\Handle\Contract\File\Csv as CsvContract;

class Csv extends CsvContract
{

    /**
     * @param $results
     * @return array
     */
    public function handleResultRows($results)
    {
        $rows = [];
        foreach ($results as $code => $items) {
            foreach ($items as $item) {
                $rows[] = array_values($item);
            }
        }
        return $rows;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return [ 'COD_COMPL', 'Código', 'Descrição' ];
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
