<?php

namespace RPagliuca\AmazonCrawler;

class QueueFetcher
{
    public function __construct(
        Doctrine $doctrine
    ) {
        $this->em = $doctrine->getEntityManager();
        $this->db = $doctrine->getEntityManager()->getConnection();
    }

    public function fetchNext($processId)
    {
        $db = $this->db;
        $db->exec('START TRANSACTION');
        $st = $db->query('SELECT id FROM Queue WHERE status LIKE "new" ORDER BY id ASC LIMIT 0, 1 FOR UPDATE');
        $results = $st->fetchAll(\PDO::FETCH_ASSOC);
        $item = null;
        if (!empty($results[0]['id'])) {
            $this->em->clear();
            $item = $this->em->find('\RPagliuca\AmazonCrawler\Entity\Queue', $results[0]['id']);
            $item->setStatus('running');
            $item->setProcessId($processId);
            $item->setModifiedAt(new \DateTime);
            $this->em->flush();
        }
        $db->exec('COMMIT');
        return $item;
    }
}
