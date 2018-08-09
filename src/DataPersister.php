<?php

namespace RPagliuca\AmazonCrawler;

class DataPersister
{
    public function __construct(
        Repository\Node $nodeRepository,
        \Doctrine\ORM\EntityManager $entityManager,
        \RPagliuca\AmazonCrawler\Configuration $configuration
    ) {
        $this->nodeRepository = $nodeRepository;
        $this->em = $entityManager;
        $this->configuration = $configuration;
    }

    public function persistData(Entity\Queue $item, $data)
    {
        /* Update root node */
        $rootNode = $this->nodeRepository->findOneByUrl($item->getUrl())
            ->setTitle($data['title'])
            ->setPrice($data['price'])
            ->setUrl($item->getUrl())
            ->setAuthors($data['authors'])
            ->setDetails($data['details'])
            ->setRating($data['rating'])
            ->setReviewCount($data['reviewCount'])
        ;

        /* Add child nodes if non-existant */
        if ($this->configuration->get('system:save-links', true)) {
            foreach ($data['suggested_urls'] as $url) {
                $node = $this->nodeRepository->findOneByUrl($url);
                if (null === $node) {
                    $node = new Entity\Node;
                    $node->setUrl($url);
                    $this->em->persist($node);

                    $queue = new Entity\Queue;
                    $queue->setUrl($url);
                    $queue->setStatus('new');
                    $queue->setModifiedAt(new \DateTime);
                    $queue->setCreatedAt(new \DateTime);
                    $this->em->persist($queue);
                }
                $link = new Entity\Link;
                $link->setFromNode($rootNode);
                $link->setToNode($node);
                $this->em->persist($link);
            }
        }

        /* Commit */
        $this->em->flush();
    }
}
