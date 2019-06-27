<?php

namespace WebCrawler\Handle\AgaParts\File;

use Iterator;
use WebCrawler\Handle\Contract\File\Csv as CsvContract;

class Csv extends CsvContract
{

    public function handleResultRows($results)
    {
        $rows = [];
        foreach ($results as $sku => $items) {
            $rows[$sku][] = $sku;
            if (is_array($items)) {
                foreach ($items as $item) {
                    if ($item) {
                        $rows[$sku][] = $item['description'];
                        $rows[$sku][] = $item['brand'];
                    }
                }
            }
        }
        return $rows;
    }

    public function getHeader()
    {
        $header = ['sku'];
        for ($i = 1;$i <= 30;$i++) {
            $header[] = 'Nome ' . $i;
            $header[] = 'Marca ' . $i;
        }
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
