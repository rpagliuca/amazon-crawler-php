<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

$container = new \DI\Container();

$doctrine = $container->get('RPagliuca\AmazonCrawler\Doctrine');

return ConsoleRunner::createHelperSet($doctrine->getEntityManager());
