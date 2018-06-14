<?php

namespace RPagliuca\AmazonCrawler;

class App
{
    public function __construct(
        Configuration $configuration,
        WebDriver $webDriver,
        QueueFetcher $queueFetcher,
        Doctrine $doctrine
    ) {
        $this->configuration = $configuration;
        $this->webDriver = $webDriver;
        $this->queueFetcher = $queueFetcher;
        $this->em = $doctrine->getEntityManager();
    }

    public function run()
    {
        $processId = getmypid();
        while (true) {
            $this->runOnce($processId);
            sleep($this->configuration->get('system:sleep'));
        }
    }

    public function runOnce($processId)
    {
        $nextItem = $this->queueFetcher->fetchNext($processId);
        if (null === $nextItem) {
            return;
        }
        $this->webDriver->getDriver()->get($nextItem->getUrl());
        $nextItem->setStatus('processed');
        $this->em->flush();
    }
}
