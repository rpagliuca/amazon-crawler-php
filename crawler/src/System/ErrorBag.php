<?php

namespace RPagliuca\AmazonCrawler\System;

class ErrorBag
{
    private $errorMessages = array();
    private $allowDuplicateErrors;

    public function __construct($allowDuplicateErrors = false)
    {
        $this->allowDuplicateErrors = $allowDuplicateErrors;
    }

    public function add($errorMessage)
    {
        if ($this->allowDuplicateErrors or !in_array($errorMessage, $this->getErrors())) {
            $this->errorMessages[] = $errorMessage;
        }
    }

    public function hasErrors()
    {
        return (count($this->getErrors()) > 0);
    }

    public function getErrors()
    {
        return $this->errorMessages;
    }

    public function isEmpty()
    {
        return !$this->hasErrors();
    }

    public function __toString()
    {
        $this->getMessage();
    }
}
