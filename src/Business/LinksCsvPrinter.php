<?php

namespace RPagliuca\AmazonCrawler\Business;

class LinksCsvPrinter
{
    public function __construct(
        \Doctrine\ORM\EntityManager $em
    ) {
        $this->db = $em->getConnection();
    }

    public function print()
    {
        $st = $this->db->query('
            SELECT L.fromNode_id, L.toNode_id FROM Link L
            INNER JOIN Node N1 ON N1.id = L.fromNode_id AND N1.title IS NOT NULL
            INNER JOIN Node N2 ON N2.id = L.toNode_id AND N2.title IS NOT NULL;
        ');
        $results = $st->fetchAll(\PDO::FETCH_ASSOC);
        return $this->array2csv($results);
    }

    private function array2csv($array, $delimiter = ",", $enclosure = '"', $escape_char = "\\")
    {
        /* Open buffer */
        $buffer = fopen('php://temp', 'r+');

        /* Format CSV into buffer */
        $first = true;
        foreach ($array as $line) {
            if ($first) {
                fputcsv($buffer, array_keys($line), $delimiter, $enclosure, $escape_char);
            }
            $first = false;
            fputcsv($buffer, $line, $delimiter, $enclosure, $escape_char);
        }

        /* Read contents */
        rewind($buffer);
        $csv = stream_get_contents($buffer);
        fclose($buffer);
        return $csv;
    }
}
