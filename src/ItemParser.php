<?php

namespace RPagliuca\AmazonCrawler;

use \Facebook\WebDriver\WebDriverBy;

class ItemParser
{
    public function __construct(
        WebDriver $webDriver,
        Configuration $configuration,
        Logger $logger
    ) {
        $this->webDriver = $webDriver;
        $this->configuration = $configuration;
        $this->logger = $logger;
    }

    public function parse(Entity\Queue $item)
    {
        $driver = $this->webDriver->getDriver();

        $this->logger->log('Getting productTitle...');
        $title = $driver->findElement(WebDriverBy::id('productTitle'))->getText();
        $this->logger->log('Getting author...');
        $authors = $driver->findElement(WebDriverBy::className('author'))->getText();
        $this->logger->log('Getting offer-price...');
        $price = $driver->findElement(WebDriverBy::className('offer-price'))->getText();
        
        $allSuggestedUrls = [];

        /* Loop through all suggested links */
        while (true) {
            /* Get suggested link source code */
            $this->logger->log('Getting innerHTML for carousel...');
            $alsoBoughtSourceCode = $driver
                ->findElement(WebDriverBy::id('anonCarousel1'))
                ->getAttribute('innerHTML')
            ;

            /* Extract links */
            preg_match_all("~/dp/[0-9]+/~", $alsoBoughtSourceCode, $matches);
            $suggestedUrls = array_unique($matches[0]);

            if (!$this->hasNewSuggestedUrls($suggestedUrls, $allSuggestedUrls)) {
                break;
            }

            $allSuggestedUrls = $this->mergeUrls($suggestedUrls, $allSuggestedUrls);

            $nextButton = $this->findVisibleElement('.a-carousel-goto-nextpage');
            if (null === $nextButton) {
                $this->logger->log('Breaking loop after next button not found...');
                break;
            }

            /* Close Kindle modal, if exists */
            $kindleModalClose = $this->findVisibleElement('.a-button-close');
            if (null !== $kindleModalClose) {
                $this->logger->log('Closing Kindle modal...');
                $kindleModalClose.click();
            }

            /* Click next button, to fetch more suggested links */
            $this->logger->log('Scrolling into view...');
            $nextButton->getLocationOnScreenOnceScrolledIntoView();
            $this->logger->log('Executing script...');
            $driver->executeScript("arguments[0].scrollIntoView(true);", [$nextButton]);
            $this->logger->log('Clicking on next button...');
            $nextButton->click();
            sleep($this->configuration->get('system:sleep'));
        }
        
        $data = [
            'title' => $title,
            'authors' => $authors,
            'price' => $price,
            'suggested_urls' => $allSuggestedUrls
        ];

        return $data;
    }

    public function hasNewSuggestedUrls($suggestedUrls, $allSuggestedUrls)
    {
        $hasNew = false;

        foreach ($suggestedUrls as $newUrl) {
            $isEqual = false;
            foreach ($allSuggestedUrls as $oldUrl) {
                if ($newUrl == $oldUrl) {
                    $isEqual = true;
                }
            }
            if (!$isEqual) {
                $hasNew = true;
            }
        }
        return $hasNew;
    }

    public function mergeUrls($suggestedUrls, $allSuggestedUrls)
    {
        $allSuggestedUrls = array_merge($allSuggestedUrls, $suggestedUrls);
        $merged = array_unique($allSuggestedUrls);
        sort($merged);
        return $merged;
    }

    private function findVisibleElement($cssSelector)
    {

        $driver = $this->webDriver->getDriver();
        $this->logger->log("Checking if element '$cssSelector' exists...");
        $elements = $driver->findElements(WebDriverBy::cssSelector($cssSelector));
        foreach ($elements as $element) {
            if ($element->isDisplayed()) {
                return $element;
            }
        }
        return null;
    }
}
