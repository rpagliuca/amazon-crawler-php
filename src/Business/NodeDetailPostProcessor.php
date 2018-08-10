<?php

namespace RPagliuca\AmazonCrawler\Business;

class NodeDetailPostProcessor
{
    public function __construct(
        \Doctrine\ORM\EntityManager $em,
        \RPagliuca\AmazonCrawler\Repository\Node $nodeRepository,
        \RPagliuca\AmazonCrawler\Business\NodeDetailExtractor $detailExtractor
    ) {
        $this->em = $em;
        $this->nodeRepository = $nodeRepository;
        $this->detailExtractor = $detailExtractor;
    }

    public function execute()
    {
        $count = 0;
        while (true) {
            $this->em->beginTransaction();
            $nodes = $this->nodeRepository->findBatchUnprocessed();
            foreach ($nodes as $node) {
                $count++;
                $nodeDetails = $this->detailExtractor->extract($node->getDetails());
                $node
                    ->setCoverType($nodeDetails['coverType'])
                    ->setPages($nodeDetails['pages'])
                    ->setPublisher($nodeDetails['publisher'])
                    ->setPublicationDate($nodeDetails['publicationDate'])
                    ->setLanguage($nodeDetails['language'])
                    ->setIsbn10($nodeDetails['isbn10'])
                    ->setIsbn13($nodeDetails['isbn13'])
                    ->setWidth($nodeDetails['width'])
                    ->setHeight($nodeDetails['height'])
                    ->setDepth($nodeDetails['depth'])
                    ->setWeight($nodeDetails['weight'])
                    ->setRankingCategory($nodeDetails['rankingCategory'])
                    ->setRanking($nodeDetails['ranking'])
                    ->setCategory1($nodeDetails['category1'])
                    ->setCategory2($nodeDetails['category2'])
                    ->setCategory3($nodeDetails['category3'])
                    ->setCategory4($nodeDetails['category4'])
                    ->setCategory5($nodeDetails['category5'])
                    ->setCategory6($nodeDetails['category6'])
                    ->setCategory7($nodeDetails['category7'])
                    ->setCategory8($nodeDetails['category8'])
                    ->setCategory9($nodeDetails['category9'])
                    ->setCategory10($nodeDetails['category10'])
                    ->setPostProcessed(true);
                echo $count . " - " . $node->getId() . "\n";
            }
            $this->em->flush();
            $this->em->commit();
            if (!count($nodes)) {
                break;
            }
        }
        return true;
    }
}
