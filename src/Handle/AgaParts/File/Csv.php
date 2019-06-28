<?php

namespace WebCrawler\Handle\AgaParts\File;

use WebCrawler\Handle\Contract\File\Csv as CsvContract;

class Csv extends CsvContract
{
    public function handleResultRows($results)
    {
        $rows = [];
        foreach ($results as $sku => $items) {
            ['resultCrawler' => $resultCrawler, 'data' => $data] = $items;
            foreach ($resultCrawler as $item) {
                $rows[] = array_values(array_merge($data, $item));
            }
        }
        return $rows;
    }

    /**
     * @return array
     */
    public function getHeaderSuccess()
    {
        $header = [];
        for ($i = 1;$i <= 30;$i++) {
            $header[] = 'Nome ' . $i;
            $header[] = 'Marca ' . $i;
        }
        return array_merge($this->getHeaderReaderData(), $header);
    }

    /**
     * @return array
     */
    public function getHeaderUnsuccess()
    {
        return array_merge($this->getHeaderReaderData(), [ 'Messagem' ]);
    }

    /**
     * @return array
     */
    public function getHeaderReaderData()
    {
        return [ 'ID_ORIGINAL', 'COD_COMPL' ];
    }

    /**
     * @return string
     */
    public function getReaderDataParamSearch()
    {
        return 'COD_COMPL';
    }
}
