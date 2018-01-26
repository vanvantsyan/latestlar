<?php

namespace App\Helpers;

class BladeHelper
{
    public static function case($text, $padeg)
    {
        if (($response_xml_data = @file_get_contents("https://ws3.morpher.ru/russian/declension?s=" . str_replace(' ', '%20', $text) . "&token=658428b5-4d45-4406-8906-cab0a6b28cf0"))===false){
            return $text;
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach(libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                return (string) $data->$padeg;
            }
        }
        return $text;
    }

    public static function numeralCase($text, $num ,$padeg = "И")
    {
        if (($response_xml_data = @file_get_contents("https://ws3.morpher.ru/russian/spell?n=" . $num . "&unit=" . str_replace(' ', '%20', $text) .  "&token=658428b5-4d45-4406-8906-cab0a6b28cf0"))===false){
            return $text;
        } else {
            libxml_use_internal_errors(true);
            $data = simplexml_load_string($response_xml_data);
            if (!$data) {
                echo "Error loading XML\n";
                foreach(libxml_get_errors() as $error) {
                    echo "\t", $error->message;
                }
            } else {
                return (string) $data->unit->$padeg;
            }
        }
        return $text;
    }
}