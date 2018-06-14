<?php

namespace RPagliuca\AmazonCrawler;

class ItemProcessor
{
    public function __construct(
        WebDriver $webDriver,
        Doctrine $doctrine,
        ItemParser $itemParser,
        DataPersister $dataPersister,
        Configuration $configuration
    ) {
        $this->webDriver = $webDriver;
        $this->em = $doctrine->getEntityManager();
        $this->itemParser = $itemParser;
        $this->dataPersister = $dataPersister;
        $this->configuration = $configuration;
    }

    public function process($nextItem)
    {
        $this->visit($nextItem);
        $data = $this->itemParser->parse($nextItem);
        $this->dataPersister->persistData($nextItem, $data);
        $this->flagAsProcessed($nextItem);
    }

    private function visit($nextItem)
    {
        $url = $this->configuration->get('target:domain') . $nextItem->getUrl();
        $this->webDriver->getDriver()->get($url);
    }

    private function flagAsProcessed($nextItem)
    {
        $nextItem->setStatus('processed');
        $this->em->flush();
    }
}
