<?php


namespace WebCrawler\Handle\Contract;

use InvalidArgumentException;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;

abstract class File
{
    /**
     * @var string|null
     */
    protected $extension;

    /**
     * @var string
     */
    protected $fileName = FILE_NAME;

    /**
     * @var Reader
     */
    private $readerData;

    /**
     * @var Writer
     */
    private $writerSuccessful;

    /**
     * @var Writer
     */
    private $writerUnsuccessful;

    /**
     * @return array
     */
    abstract public function getDataForSearch();

    /**
     * @param array $results
     * @return array
     */
    abstract public function handleResultRows($results);


    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function getExtension()
    {
        if (!$this->extension) {
            throw new InvalidArgumentException('Extension required.');
        }
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        if (!$this->fileName) {
            throw new InvalidArgumentException('File name required.');
        }
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function setReaderData()
    {
        $fileName = "{$this->getFileName()}.{$this->getExtension()}";
        $this->readerData = Reader::createFromPath($this->joinPath(BASE_PATH, 'data', $fileName));
        return $this;
    }

    /**
     * @return Reader
     * @throws Exception
     */
    public function getReaderData()
    {
        if (!$this->readerData) {
            $this->setReaderData();
        }
        return $this->readerData;
    }

    /**
     * @return $this
     */
    public function setWriterSuccessful()
    {
        $this->writerSuccessful = Writer::createFromPath($this->getFileResult('success'), 'w');
        return $this;
    }

    /**
     * @return Writer
     */
    public function getWriterSuccessful()
    {
        if (!$this->writerSuccessful) {
            $this->setWriterSuccessful();
        }
        return $this->writerSuccessful;
    }

    /**
     * @return $this
     */
    public function setWriterUnsuccessful()
    {
        $this->writerUnsuccessful = Writer::createFromPath($this->getFileResult('unsuccess'), 'w');
        return $this;
    }

    /**
     * @return Writer
     */
    public function getWriterUnsuccessful()
    {
        if (!$this->writerUnsuccessful) {
            $this->setWriterUnsuccessful();
        }
        return $this->writerUnsuccessful;
    }

    /**
     * @param string $suffix
     * @return bool|string
     */
    private function getFileResult($suffix = 'default')
    {
        $fileName = sprintf('%s-%s.%s', $this->getFileName(), $suffix, $this->getExtension());
        return $this->joinPath(BASE_PATH, 'results', $fileName);
    }

    /**
     * @param array $results
     * @param bool $success
     * @throws CannotInsertRecord
     */
    public function writing($results, $success)
    {
        $writer = $success ? $this->getWriterSuccessful() : $this->getWriterUnsuccessful();
        $rows = $this->handleResultRows($results);
        foreach ($rows as $row) {
            $writer->insertOne($row);
        }
    }

    /**
     * @param mixed ...$paths
     * @return string
     * @throws InvalidArgumentException
     */
    public function joinPath(...$paths)
    {
        if (!$paths) {
            throw new InvalidArgumentException('Specify at least one path');
        }
        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}
