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

$app = $container->get('RPagliuca\AmazonCrawler\App');
$app->run();
