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
        $errors_in_a_row = 0;
        while (true) {
            $nextItem = $this->queueFetcher->fetchNext($processId);
            if (null !== $nextItem) {
                try {
                    $this->itemProcessor->process($nextItem, $processId);
                    $errors_in_a_row = 0;
                } catch (\Exception $e) {
                    $errors_in_a_row++;
                    $this->itemProcessor->flagAsFailed($nextItem, get_class($e));
                    $this->logger->log("Errors in a row: $errors_in_a_row");
                    if (!is_a($e, \Facebook\WebDriver\Exception\NoSuchElementException::class)
                        or $errors_in_a_row >= $this->configuration->get('system:errors-in-a-row', 3)
                    ) {
                        /* Too many NoSuchElement failures, or any other exception
                         * so let's kill this process to start fresh
                         */
                        throw $e;
                    }
                }
            }
            sleep($this->configuration->get('system:sleep'));
        }
    }
}
