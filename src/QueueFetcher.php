<?php

namespace RPagliuca\AmazonCrawler;

class QueueFetcher
{
    public function __construct(
        Doctrine $doctrine,
        Configuration $configuration
    ) {
        $this->em = $doctrine->getEntityManager();
        $this->db = $doctrine->getEntityManager()->getConnection();
        $this->configuration = $configuration;
    }

    public function fetchNext($processId)
    {
        $db = $this->db;
        $db->beginTransaction();
        $st = $db->prepare('
            SELECT id FROM Queue WHERE
            (attempts < :maxAttempts OR attempts IS NULL)
            AND (
                (status LIKE "new")
                OR
                (status LIKE "running" AND TIMESTAMPDIFF(SECOND, modifiedAt, :now) > :timeout)
            )
            ORDER BY id ASC LIMIT 0, 1 FOR UPDATE
        ');
        $st->bindValue(':now', date('Y-m-d H:i:s'));
        $st->bindValue(':timeout', $this->configuration->get('system:queue-timeout', 120));
        $st->bindValue(':maxAttempts', $this->configuration->get('system:max-attempts-per-node', 10));
        $st->execute();
        $results = $st->fetchAll(\PDO::FETCH_ASSOC);
        $item = null;
        if (!empty($results[0]['id'])) {
            $this->em->clear();
            $item = $this->em->find('\RPagliuca\AmazonCrawler\Entity\Queue', $results[0]['id']);
            $item->setStatus('running');
            $item->setAttempts($item->getAttempts() + 1);
            $item->setProcessId($processId);
            $item->setModifiedAt(new \DateTime);
            $this->em->flush();
        }
        $success = $db->commit();
        if ($success !== false) {
            return $item;
        } else {
            return null;
        }
    }
}
