<?php

namespace RPagliuca\AmazonCrawler;

class App
{
    public function __construct(
        Configuration $configuration,
        QueueFetcher $queueFetcher,
        ItemProcessor $itemProcessor,
        Logger $logger
    ) {
        $this->configuration = $configuration;
        $this->queueFetcher = $queueFetcher;
        $this->itemProcessor = $itemProcessor;
        $this->logger = $logger;
    }

    public function run()
    {
        $processId = getmypid();
        $this->logger->setProcessId($processId);
        while (true) {
            $nextItem = $this->queueFetcher->fetchNext($processId);
            if (null !== $nextItem) {
                $this->itemProcessor->process($nextItem, $processId);
            }
            sleep($this->configuration->get('system:sleep'));
        }
    }
}
