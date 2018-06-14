<?php

namespace RPagliuca\AmazonCrawler;

use \Facebook\WebDriver\WebDriverBy;

class ItemParser
{
    public function __construct(
        WebDriver $webDriver,
        Configuration $configuration
    ) {
        $this->webDriver = $webDriver;
        $this->configuration = $configuration;
    }

    public function parse(Entity\Queue $item)
    {
        $driver = $this->webDriver->getDriver();

        $title = $driver->findElement(WebDriverBy::id('productTitle'))->getText();
        $authors = $driver->findElement(WebDriverBy::className('author'))->getText();
        $price = $driver->findElement(WebDriverBy::className('offer-price'))->getText();
        
        $allSuggestedUrls = [];

        /* Loop through all suggested links */
        while (true) {
            /* Get suggested link source code */
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

            /* Click next button, to fetch more suggested links */
            $button = $driver
                ->findElement(WebDriverBy::className('a-carousel-goto-nextpage'))
            ;
            $button->getLocationOnScreenOnceScrolledIntoView();
            $driver->executeScript("arguments[0].scrollIntoView(true);", [$button]);
            $button->click();
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
}
