<?php

require 'bootstrap.php';

try {
    $app = $container->get('RPagliuca\AmazonCrawler\App');
    $app->run();
} catch (\Exception $e) {
    /* Try to close webdriver if already opened, to avoid memory leak */
    $container->get('RPagliuca\AmazonCrawler\WebDriver')->getDriver()->close();
    throw $e;
}
