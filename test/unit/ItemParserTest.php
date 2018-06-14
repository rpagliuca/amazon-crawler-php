<?php

namespace RPagliuca\AmazonCrawler\Test;

class ItemParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider providerForHasNew
     */
    public function testHasNewSuggestedUrls($newUrls, $allUrls, $expectedResult)
    {
        $result = $this->getInstance()->hasNewSuggestedUrls($newUrls, $allUrls);
        $this->assertEquals($expectedResult, $result);
    }
  
    /**
     * @dataProvider providerForMerge
     */
    public function testMergeUrls($urls1, $urls2, $merged)
    {
        $result = $this->getInstance()->mergeUrls($urls1, $urls2);
        $this->assertEquals($merged, $result);
    }

    private function getInstance()
    {
        $instance = new \RPagliuca\AmazonCrawler\ItemParser(
            $this->createMock(\RPagliuca\AmazonCrawler\WebDriver::class),
            $this->createMock(\RPagliuca\AmazonCrawler\Configuration::class)
        );
        return $instance;
    }

    public function providerForHasNew()
    {
        return [
            [[], [], false],
            [[1, 2], [], true],
            [[1, 2], [1], true],
            [[1, 2], [1, 2], false]
        ];
    }

    public function providerForMerge()
    {
        return [
            [[], [], []],
            [[1], [], [1]],
            [[1, 2], [1], [1, 2]],
            [[1, 2], [1, 3], [1, 2, 3]]
        ];
    }
}
