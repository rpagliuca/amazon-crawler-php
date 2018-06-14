<?php

namespace RPagliuca\AmazonCrawler;

class App
{
    public function __construct(
        Configuration $configuration,
        QueueFetcher $queueFetcher,
        ItemProcessor $itemProcessor
    ) {
        $this->configuration = $configuration;
        $this->queueFetcher = $queueFetcher;
        $this->itemProcessor = $itemProcessor;
    }

    public function run()
    {
        $processId = getmypid();
        while (true) {
            $nextItem = $this->queueFetcher->fetchNext($processId);
            if (null !== $nextItem) {
                $this->itemProcessor->process($nextItem);
            }
            sleep($this->configuration->get('system:sleep'));
        }
    }
}
