<?php

namespace RPagliuca\AmazonCrawler;

class Logger
{
    public function setProcessId($processId)
    {
        $this->processId = $processId;
    }

    public function log($message)
    {
        $message = "[ CRAWLER {$this->processId} ] " . $message;
        error_log($message);
    }
}
