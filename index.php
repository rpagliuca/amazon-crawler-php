<?php

require 'vendor/autoload.php';

$container = new \DI\Container();

$app = $container->get('RPagliuca\AmazonCrawler\App');
$app->run();
