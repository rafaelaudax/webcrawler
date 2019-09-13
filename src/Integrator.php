<?php

namespace WebCrawler;

use DirectoryIterator;
use Exception;
use WebCrawler\Handle\Contract\Crawler;
use WebCrawler\Handle\Contract\File;
use WebCrawler\Handle\Contract\Web;
use GuzzleHttp\Client;

class Integrator
{
    private $type;

    private $instances = [];

    private $handlesOptions = [];

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

    public function setHandlesOptions()
    {
        $directoryIterator = new DirectoryIterator(BASE_PATH.'/config/handle/');
        foreach ($directoryIterator as $file) {
            if ($file->isFile()) {
                $this->handlesOptions[$file->getBasename('.php')] = require $file->getPathname();
            }
        }
        return $this;
    }

    /**
     * @return bool|Web
     */
    protected function getWeb()
    {
        if (isset($this->handlesOptions[$this->getType()])) {
            return $this->getInstanceByClass($this->handlesOptions[$this->getType()]['web'] ?: false);
        }
        return false;
    }

    /**
     * @return bool|Crawler
     */
    protected function getCrawler()
    {
        if (isset($this->handlesOptions[$this->getType()])) {
            return $this->getInstanceByClass($this->handlesOptions[$this->getType()]['crawler'] ?: false);
        }
        return false;
    }

    /**
     * @return bool|File
     */
    protected function getHandle()
    {
        if (isset($this->handlesOptions[$this->getType()])) {
            return $this->getInstanceByClass($this->handlesOptions[$this->getType()]['handle'] ?: false);
        }
        return false;
    }

    public function handleSaveData()
    {
        try {
            $dataForSearch = $this->getHandle()->getDataForSearch();

            if (TYPE_CRAWLER === 'john-deere') {
                $this
                    ->getWeb()
                    ->getClient()
                    ->get('servlet/com.deere.u90.jdparts.view.publicservlets.HomeUnsigned?selectedMenu=JDPARTS_HOME&userAction=countrySelected&country=BR&language=54');
            }

            foreach ($dataForSearch as $params) {
                $this->getWeb()->setParams($params)->resolveAllPromises();
                $resultsSuccessful = $this->getWeb()->getResponsesSuccessful();
                $resultsUnsuccessful = $this->getWeb()->getResponsesUnsuccessful();

                $resultsSuccessfulFormatted = $this->getCrawler()->setResults($resultsSuccessful)->getFormattedResults(true);
                $resultsUnsuccessfulFormatted = $this->getCrawler()->setResults($resultsUnsuccessful)->getFormattedResults(false);


                $this->getHandle()->writing($resultsSuccessfulFormatted, true);
                $this->getHandle()->writing($resultsUnsuccessfulFormatted, false);

                $this->getWeb()->clear();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
