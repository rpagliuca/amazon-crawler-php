<?php

namespace RPagliuca\AmazonCrawler\Business;

class NodesCsvPrinter
{
    public function __construct(
        \Doctrine\ORM\EntityManager $em,
        \RPagliuca\AmazonCrawler\System\ArrayToCsvConverter $arrayToCsvConverter,
        \RPagliuca\AmazonCrawler\Configuration $configuration
    ) {
        $this->db = $em->getConnection();
        $this->arrayToCsvConverter = $arrayToCsvConverter;
        $this->configuration = $configuration;
    }

    public function print()
    {
        $baseUrl = $this->configuration->get('target:domain');
        $st = $this->db->prepare('
            SELECT id, title,
            REPLACE(REPLACE(price, "R$ ", ""), ",", ".") AS price,
            CONCAT(:baseUrl, url) AS url,
            authors,
            rating,
            reviewCount,
            coverType,
            pages,
            width,
            height,
            depth,
            weight,
            publisher,
            edition,
            publicationDate,
            rankingCategory,
            ranking,
            category1,
            category2,
            category3,
            category4,
            category5,
            category6,
            category7,
            category8,
            category9,
            category10,
            isbn10,
            isbn13,
            language,
            postProcessed
            FROM Node
            WHERE Node.title IS NOT NULL
        ');
        $st->bindValue(':baseUrl', $baseUrl);
        $st->execute();
        $results = $st->fetchAll(\PDO::FETCH_ASSOC);
        return $this->arrayToCsvConverter->convert($results);
    }
}
