<?php

namespace RPagliuca\AmazonCrawler;

class ItemProcessor
{
    public function __construct(
        WebDriver $webDriver,
        Doctrine $doctrine,
        ItemParser $itemParser,
        DataPersister $dataPersister,
        Configuration $configuration,
        Logger $logger
    ) {
        $this->webDriver = $webDriver;
        $this->em = $doctrine->getEntityManager();
        $this->itemParser = $itemParser;
        $this->dataPersister = $dataPersister;
        $this->configuration = $configuration;
        $this->logger = $logger;
    }

    public function process($nextItem)
    {
        $this->visit($nextItem);
        $data = $this->itemParser->parse($nextItem);
        try {
            $this->em->beginTransaction();
            $this->dataPersister->persistData($nextItem, $data);
            $this->flagAsProcessed($nextItem);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

    private function visit($nextItem)
    {
        $url = $this->configuration->get('target:domain') . $nextItem->getUrl();
        $this->logger->log("Visiting $url...");
        $this->webDriver->getDriver()->get($url);
    }

    private function flagAsProcessed($nextItem)
    {
        $nextItem->setModifiedAt(new \DateTime);
        $nextItem->setStatus('processed');
        $this->em->flush();
    }

    public function flagAsFailed($nextItem, $failureType)
    {
        $nextItem->setModifiedAt(new \DateTime);
        $nextItem->setStatus('failed');
        $nextItem->setLastFailureType($failureType);
        $this->em->flush();
    }
}
