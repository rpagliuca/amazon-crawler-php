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
    },
    \RPagliuca\AmazonCrawler\Repository\Queue::class => function ($container) {
        return $container->get('Doctrine\ORM\EntityManager')
            ->getRepository('\RPagliuca\AmazonCrawler\Entity\Queue');
    }
]);
$container = $containerBuilder->build();

if (!empty($argv[1])) {
    $configuration = $container->get('RPagliuca\AmazonCrawler\Configuration');
    $configuration->setSocksPort($argv[1]);
}
