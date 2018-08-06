<?php

namespace RPagliuca\AmazonCrawler\Business;

class NodesCsvPrinter
{
    public function __construct(
        \Doctrine\ORM\EntityManager $em,
        \RPagliuca\AmazonCrawler\System\ArrayToCsvConverter $arrayToCsvConverter
    ) {
        $this->db = $em->getConnection();
        $this->arrayToCsvConverter = $arrayToCsvConverter;
    }

    public function print()
    {
        $st = $this->db->query('
            SELECT id, title, REPLACE(REPLACE(price, "R$ ", ""), ",", ".") AS price FROM Node
            WHERE Node.title IS NOT NULL
        ');
        $results = $st->fetchAll(\PDO::FETCH_ASSOC);
        return $this->arrayToCsvConverter->convert($results);
    }
}
