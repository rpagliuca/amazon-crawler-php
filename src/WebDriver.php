<?php

namespace RPagliuca\AmazonCrawler;

use \Facebook\WebDriver\Remote\RemoteWebDriver;
use \Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;

class WebDriver
{
    public function __construct(
        Configuration $configuration
    ) {
        $options = new ChromeOptions();
        $options->addArguments([
            '--proxy-server='
                . $configuration->get('proxy:socks_host')
                . ":"
                . $configuration->get('proxy:socks_port'),
            '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
            . '(KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36',
        ]);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        $this->driver = RemoteWebDriver::create(
            $configuration->get('selenium:host'),
            $capabilities,
            60 * 1000,
            60 * 1000
        );
        $this->driver->manage()->window()->maximize();
    }

    public function getDriver()
    {
        return $this->driver;
    }
}
