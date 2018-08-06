<?php

namespace RPagliuca\AmazonCrawler\System;

class ArrayToCsvConverter
{
    public function convert($array, $delimiter = ",", $enclosure = '"', $escape_char = "\\")
    {
        /* Open buffer */
        $buffer = fopen('php://temp', 'r+');

        /* Format CSV into buffer */
        $first = true;
        foreach ($array as $line) {
            if ($first) {
                fputcsv($buffer, array_keys($line), $delimiter, $enclosure, $escape_char);
            }
            $first = false;
            fputcsv($buffer, $line, $delimiter, $enclosure, $escape_char);
        }

        /* Read contents */
        rewind($buffer);
        $csv = stream_get_contents($buffer);
        fclose($buffer);
        return $csv;
    }
}
