<?php

namespace RPagliuca\AmazonCrawler\Repository;

use Doctrine\ORM\EntityRepository;

class Node extends EntityRepository
{
    public function findBatchUnprocessed()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("
            SELECT n FROM \RPagliuca\AmazonCrawler\Entity\Node n
            WHERE (n.postProcessed IS NULL OR n.postProcessed = false)
            AND n.title IS NOT NULL
        ");
        $query->setMaxResults(500);
        $objects = $query->getResult();
        return $objects;
    }
}
