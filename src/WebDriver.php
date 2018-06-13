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
    }

    public function getDriver()
    {
        $driver = RemoteWebDriver::create(
            $this->configuration->get('selenium:host'),
            DesiredCapabilities::chrome()
        );
        return $driver;
    }
}
