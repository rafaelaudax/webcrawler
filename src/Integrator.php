<?php

namespace WebCrawler;

use WebCrawler\File\Csv\Handle;
use WebCrawler\Product\Crawler;

class Integrator
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var Handle
     */
    private $handleFile;

    /**
     * Integrator constructor.
     */
    public function __construct()
    {
        $this->crawler = new Crawler();
        $this->handleFile = new Handle();
    }

    /**
     * @return \Iterator
     */
    private function getSkus()
    {
        return $this->handleFile->setFileData(FILE_DATA)->getDataSku();
    }

    /**
     * @param int $size
     * @return array
     */
    private function getSkusChucked($size = 10)
    {
        $iterator = $this->getSkus();
        return array_chunk(iterator_to_array($iterator), $size);
    }

    public function handleSaveData()
    {
        try {
            $skusChucked = $this->getSkusChucked();

            $this->handleFile->setWriterSuccessful();
            $this->handleFile->setWriterUnsuccessful();

            $header = $this->handleFile->getHeader();
            $this->handleFile->getWriterSuccessful()->insertOne($header);
            $this->handleFile->getWriterUnsuccessful()->insertOne(['sku', 'message']);

            foreach ($skusChucked as $skus) {
                $this->request($skus);
                $resultsSuccessful = $this->getSuccessful();
                $resultsUnsuccessful = $this->getUnsuccessful();

                $this->handleFile->setResultSuccessful($resultsSuccessful);
                $this->handleFile->setResultUnsuccessful($resultsUnsuccessful);

                $this->crawler->getWeb()->clear();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $params
     * @return $this
     */
    private function request($params)
    {
        $this->crawler->handleRequests($params);
        return $this;
    }

    private function getSuccessful()
    {
        return $this->crawler->getFormattedResult();
    }

    private function getUnsuccessful()
    {
        return $this->crawler->getFormattedResult(false);
    }
}