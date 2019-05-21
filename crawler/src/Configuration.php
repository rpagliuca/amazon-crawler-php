<?php

namespace RPagliuca\AmazonCrawler;

class Configuration
{
    public function __construct()
    {
        /* Read configuration from config.json */
        $contents = @file_get_contents(__DIR__ . '/../config.json');
        if ($contents === false) {
            die("Error: Configuration file config.json does not exist\n");
        }
        $this->cfg = json_decode($contents, true);
    }

    /* Configuration key, example: db:host */
    public function get($fullKey, $defaultValue = null, $required = false)
    {
        $keys = explode(":", $fullKey);
        $value = $this->cfg;
        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                if ($required) {
                    die("Error: Parameter $fullKey is not configured in config.json\n");
                }
                return $defaultValue;
            }
        }
        return $value;
    }

    public function setSocksPort($port)
    {
        $this->cfg['proxy']['socks-port'] = $port;
    }
}
