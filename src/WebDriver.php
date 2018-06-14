<?php

namespace RPagliuca\AmazonCrawler;

use \Facebook\WebDriver\Remote\RemoteWebDriver;
use \Facebook\WebDriver\Remote\DesiredCapabilities;

class WebDriver
{
    public function __construct(
        Configuration $configuration
    ) {
        $this->configuration = $configuration;
        $this->driver = RemoteWebDriver::create(
            $this->configuration->get('selenium:host'),
            DesiredCapabilities::chrome()
        );
        $this->driver->manage()->window()->maximize();
    }

    public function getDriver()
    {
        return $this->driver;
    }
}
