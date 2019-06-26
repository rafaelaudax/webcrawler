<?php

namespace WebCrawler\File\Csv;

use Iterator;
use League\Csv\Reader;
use League\Csv\Writer;

abstract class Handle
{
    const EXTENSION_DEFAULT = '.csv';
    const PATH_DATA_DEFAULT = 'data';
    const PATH_RESULT_DEFAULT = 'result';

    /**
     * @var Writer
     */
    private $writerSuccessful;

    /**
     * @var Writer
     */
    private $writerUnsuccessful;
    /**
     * @var string
     */
    private $fileResult = 'results';

    /**
     * @var string
     */
    private $fileData;

    /**
     * @return array|Iterator
     */
    abstract public function getParamsSearch();

    abstract public function handleResultRows($results);

    abstract public function getHeader();

    /**
     * @return Handle
     */
    public function setWriterSuccessful()
    {
        $this->writerSuccessful = Writer::createFromPath($this->getFileResultSuccessful(), 'w+');
        return $this;
    }

    /**
     * @return Writer
     */
    public function getWriterSuccessful()
    {
        return $this->writerSuccessful;
    }

    /**
     * @return Handle
     */
    public function setWriterUnsuccessful()
    {
        $this->writerUnsuccessful = Writer::createFromPath($this->getFileResultUnsuccessful(), 'w+');
        return $this;
    }

    /**
     * @return Writer
     */
    public function getWriterUnsuccessful()
    {
        return $this->writerUnsuccessful;
    }

    /**
     * @return string
     */
    public function getPathData()
    {
        return BASE_PATH . self::PATH_DATA_DEFAULT . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getPathResult()
    {
        return BASE_PATH . self::PATH_RESULT_DEFAULT . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $fileResult
     * @return $this
     */
    public function setFileResult($fileResult)
    {
        $this->fileResult = $fileResult;
        return $this;
    }

    /**
     * @param $suffix
     * @return string
     */
    public function getFileResult($suffix)
    {
        return $this->getPathResult() . $this->fileData . '-' . $this->fileResult . '-' . $suffix . self::EXTENSION_DEFAULT;
    }

    /**
     * @return string
     */
    public function getFileResultSuccessful()
    {
        return $this->getFileResult('success');
    }

    /**
     * @return string
     */
    public function getFileResultUnsuccessful()
    {
        return $this->getFileResult('unsuccess');
    }

    /**
     * @param $fileData
     * @return $this
     */
    public function setFileData($fileData)
    {
        $this->fileData = $fileData;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileData()
    {
        return $this->getPathData() . $this->fileData . self::EXTENSION_DEFAULT;
    }

    /**
     * @return Reader
     */
    public function getReaderData()
    {
        return Reader::createFromPath($this->getFileData(), 'r');
    }

    public function setResultSuccessful($results)
    {
        $rows = $this->handleResultRows($results);
        foreach ($rows as $row) {
            $this->getWriterSuccessful()->insertOne($row);
        }
    }

    public function setResultUnsuccessful($results)
    {
        $rows = $this->handleResultRows($results);
        foreach ($rows as $row) {
            $this->getWriterUnsuccessful()->insertOne($row);
        }
    }
}
