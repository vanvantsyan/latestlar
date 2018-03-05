<?php

namespace App\Helpers;

use Sunra\PhpSimple\HtmlDomParser;

class BladeHelper
{
    public static function case($text, $padeg)
    {
        return $text;
        if (($response_xml_data = file_get_contents("https://ws3.morpher.ru/russian/declension?s=" . str_replace(' ', '%20', $text) . "&token=658428b5-4d45-4406-8906-cab0a6b28cf0")) === false) {
            return $text;
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach (libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                return (string)$data->$padeg;
            }
        }
        return $text;
    }

    public static function numeralCase($text, $num, $padeg = "И")
    {
        return $text;
        if (($response_xml_data = file_get_contents("https://ws3.morpher.ru/russian/spell?n=" . $num . "&unit=" . str_replace(' ', '%20', $text) . "&token=658428b5-4d45-4406-8906-cab0a6b28cf0")) === false) {
            return $text;
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach (libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                return (string)$data->unit->$padeg;
            }
        }
        return $text;
    }

    public static function getTourCountry($ways)
    {
        foreach ($ways as $way) {
            if (array_get($way, 'ways_par.status') == 'country') return array_get($way, 'ways_par.url');
        }
        return 'russia';
    }

    public static function tourImg($img, $id)
    {
        return asset(config('main.imgPath.tour') . 'full/' . substr($id, 0, 2) . '/' . $img);
    }

    public static function tourThumb($img, $id)
    {
        return asset(config('main.imgPath.tour') . 'thumbs/' . substr($id, 0, 2) . '/' . $img);
    }

    public static function tourLink($tour)
    {
        $firstWay = '';

        if (count($tour['par_ways'])) {
            foreach ($tour['par_ways'] as $way) {
                if (array_get($way, 'ways_par.status') != 'country') {
                    $firstWay = 'tury-' . array_get($way, 'ways_par.url', 'error_way') . '/';
                }
            }
        }

        return '/' . self::getTourCountry($tour['par_ways']) . '/' . $firstWay . $tour['url'];
    }

    public static function parsTourDescription($text)
    {
        function getLastParent($block)
        {
            if ($block->parent && $block->parent->tag != 'root') {
                return getLastParent($block->parent);
            } else {
                return $block;
            }
        }

        $data = [];


        $html = HtmlDomParser::str_get_html($text);
//        $mainDiv = $html->find('div', 0);
//
//        if ($mainDiv) $descBlock = $mainDiv; else
        $descBlock = $html;

        $data['tourDays'] = [];

        foreach ($descBlock->find('table') as $table) {

            foreach ($table->find('text') as $textBlock) {
                preg_match('/1 ?.* ?день/ui', $table->innertext(), $matches);

                if (count($matches)) {

                    $daysCount = 1;

                    foreach ($table->find('tr') as $tr) {
                        if ($tr->find('td', 1)) {
                            $data['tourDays'][$daysCount] = $tr->find('td', 1)->innertext();
                            $daysCount++;
                        }

                    }

                    $table->outertext = "";
                }
            }

        }

        $descBlock->load($descBlock->save());

        $data['includedInPrice'] = '';

        foreach ($descBlock->find('text') as $textBlock) {
            preg_match('/в стоимость/ui', $textBlock->outertext(), $matches);
            if (count($matches)) {

                $includeInPrice = getLastParent($textBlock);
                if ($includeInPrice) {
                    $data['includedInPrice'] = $includeInPrice->innertext;
                }

                $includeInPrice->outertext = "";
                break;
            }
        }

        if ($descBlock)
            $data['rest'] = self::removeTags(['span', 'span', 'br'], $descBlock->innertext);


        return $data;
    }

    public static function removeTags(array $tags, $text)
    {
        foreach ($tags as $tag) {
            $text = preg_replace('/<' . $tag . '(.*)>(.*)<\/' . $tag . '>/Uui', "$2", $text);
            $text = preg_replace('/<' . $tag . '(.*)>/Uui', "", $text);
        }

        // Remove empty tags
        $text = preg_replace('~&nbsp;~i', '', $text);
        $text = preg_replace('~(<(.*)[^<>]*>\s*<\/\\2>)~i', '', $text);

        return $text;
    }

    public static function wordsCount($text){
        return count(explode(' ', $text));
    }
}