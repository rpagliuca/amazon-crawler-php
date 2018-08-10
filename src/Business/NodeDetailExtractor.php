<?php

namespace RPagliuca\AmazonCrawler\Business;

class NodeDetailExtractor
{
    const MISSING_DATA = "<<MISSING_DATA>>";

    public function extract($details)
    {
        $features = [
            'coverType' => $this->coverType($details),
            'pages' => $this->pages($details),
            'publisher' => $this->publisher($details),
            'publicationDate' => $this->publicationDate($details),
            'language' => $this->language($details),
            'isbn10' => $this->isbn10($details),
            'isbn13' => $this->isbn13($details),
            'width' => $this->width($details),
            'height' => $this->height($details),
            'depth' => $this->depth($details),
            'weight' => $this->weight($details),
            'rankingCategory' => $this->rankingCategory($details),
            'ranking' => $this->ranking($details),
            'category1' => $this->category($details, 0),
            'category2' => $this->category($details, 1),
            'category3' => $this->category($details, 2),
            'category4' => $this->category($details, 3),
            'category5' => $this->category($details, 4),
            'category6' => $this->category($details, 5),
            'category7' => $this->category($details, 6),
            'category8' => $this->category($details, 7),
            'category9' => $this->category($details, 8),
            'category10' => $this->category($details, 9),
        ];
        return $features;
    }

    private function coverType($details)
    {
        preg_match('/(.*):.* páginas/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function pages($details)
    {
        preg_match('/.*:(.*) páginas/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function publisher($details)
    {
        preg_match('/Editora:([^;(]*)/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function publicationDate($details)
    {
        preg_match('/Editora:[^;(]*\((.*)\)/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function language($details)
    {
        preg_match('/Idioma:(.*)/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function isbn10($details)
    {
        preg_match('/ISBN-10:(.*)/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function isbn13($details)
    {
        preg_match('/ISBN-13:(.*)/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function height($details)
    {
        return $this->measures($details)[2];
    }

    private function width($details)
    {
        return $this->measures($details)[1];
    }

    private function depth($details)
    {
        return $this->measures($details)[0];
    }

    private function measures($details)
    {
        $measures = [
            $this->measure1($details),
            $this->measure2($details),
            $this->measure3($details),
        ];
        $measures = array_map(function ($element) {
            return str_replace(",", ".", $element);
        }, $measures);
        sort($measures);
        return $measures;
    }

    private function measure1($details)
    {
        preg_match(
            '/Dimensões do produto:[^[0-9]]*([0-9,]+)[^[0-9]]*x[^[0-9]]*[0-9,]+[^[0-9]]*x[^[0-9]]*[0-9,]+/',
            $details,
            $matches
        );
        return $this->returnMatch($matches);
    }

    private function measure2($details)
    {
        preg_match(
            '/Dimensões do produto:[^[0-9]]*[0-9,]+[^[0-9]]*x[^[0-9]]*([0-9,]+)[^[0-9]]*x[^[0-9]]*[0-9,]+/',
            $details,
            $matches
        );
        return $this->returnMatch($matches);
    }

    private function measure3($details)
    {
        preg_match(
            '/Dimensões do produto:[^[0-9]]*[0-9,]+[^[0-9]]*x[^[0-9]]*[0-9,]+[^[0-9]]*x[^[0-9]]*([0-9,]+)/',
            $details,
            $matches
        );
        return $this->returnMatch($matches);
    }

    private function weight($details)
    {
        preg_match('/Peso de envio:(.*) g/', $details, $matches);
        return $this->returnMatch($matches);
    }

    private function ranking($details)
    {
        $regex = '/Lista de mais vendidos da Amazon: no. ([0-9,]+) em .*/';
        preg_match($regex, $details, $matches);
        return str_replace(",", "", $this->returnMatch($matches));
    }

    private function rankingCategory($details)
    {
        $regex = '/Lista de mais vendidos da Amazon: no. [0-9,]+ em (.*) \(Conheça/';
        preg_match($regex, $details, $matches);
        return $this->returnMatch($matches);
    }

    private function category($details, $num)
    {
        $categories = $this->categories($details);
        if (!empty($categories[$num])) {
            return $categories[$num];
        } else {
            return null;
        }
    }

    private function categories($details)
    {
        $regex = '/#[0-9]+ em (.* > .*)/';
        preg_match($regex, $details, $matches);
        $categories = $this->returnMatch($matches);
        return explode(" > ", $categories);
    }


    private function returnMatch($matches)
    {
        if (empty($matches[1])) {
            return self::MISSING_DATA;
        } else {
            return trim($matches[1]);
        }
    }
}
