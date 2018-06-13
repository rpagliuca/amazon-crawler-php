<?php

namespace RPagliuca\AmazonCrawler;

class Configuration
{
    public function __construct()
    {
        /* Read configuration from config.json */
        $contents = file_get_contents(__DIR__ . '/../config.json');
        $this->cfg = json_decode($contents, true);
    }

    /* Configuration key, example: db:host */
    public function get($fullKey)
    {
        $keys = explode(":", $fullKey);
        $value = $this->cfg;
        foreach ($keys as $key) {
            $value = $value[$key];
        }
        return $value;
    }
}
