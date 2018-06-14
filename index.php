<?php

require 'vendor/autoload.php';

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAnnotations(true);
$containerBuilder->addDefinitions([
    \Doctrine\ORM\EntityManager::class => function ($container) {
        return $container->get('RPagliuca\AmazonCrawler\Doctrine')->getEntityManager();
    },
    \RPagliuca\AmazonCrawler\Repository\Node::class => function ($container) {
        return $container->get('Doctrine\ORM\EntityManager')
            ->getRepository('\RPagliuca\AmazonCrawler\Entity\Node');
    }
]);
$container = $containerBuilder->build();

if (!empty($argv[1])) {
    $configuration = $container->get('RPagliuca\AmazonCrawler\Configuration');
    $configuration->setSocksPort($argv[1]);
}

try {
    $app = $container->get('RPagliuca\AmazonCrawler\App');
    $app->run();
} catch (\Exception $e) {
    /* Try to close webdriver if already opened, to avoid memory leak */
    $container->get('RPagliuca\AmazonCrawler\WebDriver')->getDriver()->close();
    throw $e;
}
