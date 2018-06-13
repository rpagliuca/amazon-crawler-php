<?php

namespace RPagliuca\AmazonCrawler;

class App
{
    public function __construct(
        Configuration $configuration,
        WebDriver $webDriver
    ) {
        $this->configuration = $configuration;
        $this->webDriver = $webDriver;
    }

    public function run()
    {
        $driver = $this->webDriver->getDriver();
        $driver->get('http://www.amazon.com.br');
        echo $driver->getPageSource();
    }
}
