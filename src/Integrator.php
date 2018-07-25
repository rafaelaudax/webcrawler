<?php

namespace WebCrawler;

use WebCrawler\File\Csv\Handle;
use WebCrawler\Product\Crawler;
use WebCrawler\Product\Web;

class Integrator
{
    private $type;

    private $instances = [];

    private $handlesByType = [
        'megaron' => [
            'web' => \WebCrawler\Product\Web\Megaron::class,
            'crawler' => \WebCrawler\Product\Crawler\Megaron::class,
            'handle' => \WebCrawler\File\Csv\Handle\Megaron::class,
        ],
        'agaparts' => [
            'web' => \WebCrawler\Product\Web\AgaParts::class,
            'crawler' => \WebCrawler\Product\Crawler\AgaParts::class,
            'handle' => \WebCrawler\File\Csv\Handle\AgaParts::class,
        ]
    ];

    /**
     * @param mixed $type
     * @return Integrator
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    protected function getInstanceByClass($class)
    {
        if ($class) {
            if (isset($this->instances[$class])) {
                return $this->instances[$class];
            }
            return $this->instances[$class] = new $class;
        }
        return false;
    }

    /**
     * @return bool|Web
     */
    protected function getWeb()
    {
        if (isset($this->handlesByType[$this->getType()])) {
            return $this->getInstanceByClass($this->handlesByType[$this->getType()]['web'] ?: false);
        }
        return false;
    }

    /**
     * @return bool|Crawler
     */
    protected function getCrawler()
    {
        if (isset($this->handlesByType[$this->getType()])) {
            return $this->getInstanceByClass($this->handlesByType[$this->getType()]['crawler'] ?: false);
        }
        return false;
    }

    /**
     * @return bool|Handle
     */
    protected function getHandle()
    {
        if (isset($this->handlesByType[$this->getType()])) {
            return $this->getInstanceByClass($this->handlesByType[$this->getType()]['handle'] ?: false);
        }
        return false;
    }

    public function handleSaveData()
    {
        try {
            $paramsSearch = $this->getHandle()->getParamsSearch();

            $this->getHandle()->setWriterSuccessful();
            $this->getHandle()->setWriterUnsuccessful();

            $header = $this->getHandle()->getHeader();
            $this->getHandle()->getWriterSuccessful()->insertOne($header);
            $this->getHandle()->getWriterUnsuccessful()->insertOne(['sku', 'message']);

            foreach ($paramsSearch as $params) {
                $this->getWeb()->setParams($params)->resolveAllPromises();
                $resultsSuccessful = $this->getWeb()->getResponsesSuccessful();
                $resultsUnsuccessful = $this->getWeb()->getResponsesUnsuccessful();

                $resultsSuccessfulFormatted = $this->getCrawler()->setResults($resultsSuccessful)->getFormattedResults();
                $resultsUnsuccessfulFormatted = $this->getCrawler()->setResults($resultsUnsuccessful)->getFormattedResults(false);

                $this->getHandle()->setResultSuccessful($resultsSuccessfulFormatted);
                $this->getHandle()->setResultUnsuccessful($resultsUnsuccessfulFormatted);

                $this->getWeb()->clear();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
