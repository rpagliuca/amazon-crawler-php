<?php

namespace RPagliuca\AmazonCrawler;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine
{
    public function __construct(
        Configuration $configuration
    ) {
        $this->entityManager = null;
        $this->configuration = $configuration;
        $this->initializeEntityManager();
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    private function initializeEntityManager()
    {
        $doctrineIsDevMode = true;
        $entitiesPath = [__DIR__ . "/Entity"];
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration(
            $entitiesPath,
            $doctrineIsDevMode,
            null,
            null,
            false
        );
        if (!empty($loader)) {
            \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
        }

        $doctrineDbParams = array(
            'driver'   => 'pdo_mysql',
            'host'     => $this->configuration->get('db:host'),
            'dbname'   => $this->configuration->get('db:name'),
            'port'   => $this->configuration->get('db:port'),
            'user'     => $this->configuration->get('db:user'),
            'password' => $this->configuration->get('db:password'),
            'driverOptions' => [
                1002 => 'SET NAMES utf8'
            ],
            'url' => $this->configuration->get('db:url')
        );

        $doctrineEntityManager = EntityManager::create($doctrineDbParams, $doctrineConfig);
        $platform = $doctrineEntityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        $this->entityManager = $doctrineEntityManager;
    }
}
