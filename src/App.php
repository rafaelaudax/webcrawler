<?php

namespace WebCrawler;

final class App
{
    static private $instance;

    static public function init()
    {
        self::getInstance()->initObStart();
        self::getInstance()->handleRequest();
        self::getInstance()->setHeader()->endObFlush();
        self::getInstance()->handleApp();
    }

    private function handleRequest()
    {
        echo 'aplicação iniciada com sucesso, os dados estão sendo carregados e
        salvo no arquivo .csv na pasta result na raiz do projeto';
    }

    private function handleApp()
    {
        (new Integrator())->setHandlesOptions()->setType(TYPE_CRAWLER)->handleSaveData();
    }

    private function setHeader()
    {
        header('Connection: close');
        header('Content-Length: '.ob_get_length());
        header('Content-Type: text/html; charset=utf-8');
        return $this;
    }

    private function initObStart()
    {
        ob_start();
        return $this;
    }

    private function endObFlush()
    {
        ob_end_flush();
        ob_flush();
        flush();
        return $this;
    }

    static public function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
