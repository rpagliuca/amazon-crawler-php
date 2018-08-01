<?php

namespace RPagliuca\AmazonCrawler;

class Setup
{
    public function __construct(
        Repository\Queue $queueRepository,
        \Doctrine\ORM\EntityManager $em,
        Configuration $configuration
    ) {
        $this->queueRepository = $queueRepository;
        $this->em = $em;
        $this->configuration = $configuration;
    }

    public function run()
    {
        try {
            $item = $this->queueRepository->findAll();
        } catch (\Exception $e) {
            die("Error running database query. Make sure you have run `vendor/bin/doctrine orm:schema-tool:create`.\n");
        }

        if (count($item)) {
            die("Setup already ok.\n");
        }

        $url = $this->configuration->get('target:first-node', null, true);
        $item = (new Entity\Queue())
            ->setUrl($url)
            ->setStatus('new')
            ->setModifiedAt(new \DateTime)
            ->setCreatedAt(new \DateTime)
        ;
        $this->em->persist($item);

        $node = (new Entity\Node())
            ->setUrl($url)
        ;
        $this->em->persist($node);

        $this->em->flush();
        die("Success.\n");
    }
}
