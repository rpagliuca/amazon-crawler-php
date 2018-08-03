<?php

namespace RPagliuca\AmazonCrawler\Business;

class StatisticsGatherer
{
    public function __construct(
        \Doctrine\ORM\EntityManager $em
    ) {
        $this->db = $em->getConnection();
    }

    public function getStatistics()
    {
        return [
            'queue' => $this->queueSummary(),
            'links' => $this->countAllLinks(),
            'full-processed-links' => $this->countFullProcessedLinks()
        ];
    }

    public function queueSummary()
    {
        $st = $this->db->query('SELECT status, COUNT(*) AS count FROM Queue GROUP BY status');
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countAllLinks()
    {
        $st = $this->db->query('SELECT COUNT(*) AS count FROM Link');
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countFullProcessedLinks()
    {
        $st = $this->db->query('
            SELECT COUNT(*) as count FROM (
                SELECT L.fromNode_id, L.toNode_id FROM Link L
                INNER JOIN Node N1 ON N1.id = L.fromNode_id AND N1.title IS NOT NULL
                INNER JOIN Node N2 ON N2.id = L.toNode_id AND N2.title IS NOT NULL
            ) TMP
        ');
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }
}
