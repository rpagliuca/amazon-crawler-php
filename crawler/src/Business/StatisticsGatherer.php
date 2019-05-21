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
            'full-processed-links' => $this->countFullProcessedLinks(),
            'recently-processed' => [
                'ten-seconds' => $this->countProcessedLastSeconds(10),
                'one-minute' => $this->countProcessedLastSeconds(60),
                'five-minutes' => $this->countProcessedLastSeconds(5 * 60),
                'thirty-minutes' => $this->countProcessedLastSeconds(30 * 60),
                'one-day' => $this->countProcessedLastSeconds(24 * 60 * 60),
            ]
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

    public function countProcessedLastSeconds($seconds = 60)
    {
        $st = $this->db->prepare('
            SELECT COUNT(*) as count FROM Queue WHERE status LIKE "processed"
            AND TIMESTAMPDIFF(SECOND, modifiedAt, :now) <= :seconds
        ');
        $st->bindValue(':now', date('Y-m-d H:i:s'));
        $st->bindValue(':seconds', $seconds);
        $st->execute();
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }
}
