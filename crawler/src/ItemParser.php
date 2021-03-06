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

        $this->logger->log('Getting product title...');

        /* Title is the only property that is required */
        $title = $driver->findElement(WebDriverBy::id('productTitle'))->getText();

        $this->logger->log('Getting author...');
        try {
            $authors = $driver->findElement(WebDriverBy::className('author'))->getText();
        } catch (\Exception $e) {
            $this->logger->log('Error fetching author...');
            $authors = "<<MISSING_DATA>>";
        }

        $this->logger->log('Getting price...');
        try {
            $price = $driver->findElement(WebDriverBy::className('offer-price'))->getText();
        } catch (\Exception $e) {
            $this->logger->log('Error fetching price...');
            $price = "<<MISSING_DATA>>";
        }

        $this->logger->log('Getting product details...');
        try {
            $details = $driver->findElement(WebDriverBy::cssSelector('#detail_bullets_id .bucket .content'))->getText();
        } catch (\Exception $e) {
            $this->logger->log('Error fetching details...');
            $details = "<<MISSING_DATA>>";
        }

        $this->logger->log('Getting rating...');
        try {
            $rating = $driver->findElement(WebDriverBy::className('arp-rating-out-of-text'))->getText();
        } catch (\Exception $e) {
            $this->logger->log('Error fetching rating...');
            $rating = "<<MISSING_DATA>>";
        }

        $this->logger->log('Getting review count...');
        try {
            $reviewCount = $driver->findElement(WebDriverBy::cssSelector('.a-size-medium.totalReviewCount'))->getText();
        } catch (\Exception $e) {
            $this->logger->log('Error fetching review count...');
            $reviewCount = "<<MISSING_DATA>>";
        }
        
        $allSuggestedUrls = [];

        /* Loop through all suggested links */
        while (true) {
            /* Get suggested link source code */
            $this->logger->log('Getting innerHTML for carousel...');

            /* Frequently Bought Together Bundle */
            /*
            $alsoBoughtSourceCode = $driver
                ->findElement(WebDriverBy::cssSelector('form[name=BuyXGetYhandleBuy]'))
                ->getAttribute('innerHTML')
            ;
             */

            /* Updated on 2019-05-21 */
            $alsoBoughtSourceCode = $driver
                ->findElement(WebDriverBy::cssSelector('#desktop-dp-sims_purchase-similarities-sims-feature'))
                ->getAttribute('innerHTML')
            ;

            /* Extract links */
            preg_match_all("~/dp/[0-9]+/~", $alsoBoughtSourceCode, $matches);
            $suggestedUrls = array_unique($matches[0]);

            if (!$this->hasNewSuggestedUrls($suggestedUrls, $allSuggestedUrls)) {
                $this->logger->log('Finished getting list of suggested URLs.');
                break;
            }

            $allSuggestedUrls = $this->mergeUrls($suggestedUrls, $allSuggestedUrls);

            /* Close Kindle modal, if exists */
            $kindleModalClose = $this->findVisibleElement('.a-button-close');
            if (null !== $kindleModalClose) {
                $this->logger->log('Closing Kindle modal...');
                $this->click($kindleModalClose);
            }

            $nextButton = $this->findVisibleElement('.a-carousel-goto-nextpage');
            if (null === $nextButton) {
                $this->logger->log('Breaking loop after next button not found...');
                break;
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
        
        $this->logger->log('Finished parsing item.');

        $data = [
            'title' => $title,
            'authors' => $authors,
            'price' => $price,
            'suggested_urls' => $allSuggestedUrls,
            'details' => $details,
            'rating' => $rating,
            'reviewCount' => $reviewCount
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

    /* Javascript alternative for clicking an element,
     * when Selenium driver native method does not work
     */
    private function click($element)
    {
        $driver = $this->webDriver->getDriver();
        $driver->executeScript("arguments[0].click()", [$element]);
    }
}
