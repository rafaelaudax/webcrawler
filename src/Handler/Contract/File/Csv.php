<?php

namespace WebCrawler\Handler\Contract\File;

use Exception;
use WebCrawler\Handler\Contract\File;

abstract class Csv extends File
{
    /**
     * @var string
     */
    protected $extension = 'csv';

    public function __construct()
    {
        try {
            $this->getWriterSuccessful()->insertOne($this->getHeaderSuccess());
            $this->getWriterUnsuccessful()->insertOne($this->getHeaderUnsuccess());
        } catch (Exception $e) {}
    }

    /**
     * @return array
     */
    abstract public function getHeaderSuccess();

    /**
     * @return array
     */
    abstract public function getHeaderUnsuccess();

    /**
     * @return array
     */
    abstract public function getHeaderReaderData();

    /**
     * @return string
     */
    abstract public function getReaderDataParamSearch();

    /**
     * @return array
     * @throws \League\Csv\Exception
     */
    public function getDataForSearch()
    {
        $params = $this->getReaderData()->getRecords($this->getHeaderReaderData());
        if ($params) {
            $paramsToArray = iterator_to_array($params);
            $paramsFiltered = array_filter($paramsToArray, function ($param) {
                return (bool) ($param[$this->getReaderDataParamSearch()] ?? false);
            });

            $paramsFormatted = array_map(function($param) {
                return [
                    'paramSearch' => $param[$this->getReaderDataParamSearch()] ?? false,
                    'data' => $param
                ];
            }, $paramsFiltered);

            return array_chunk($paramsFormatted, 10);
        }
        return [];
    }
}
