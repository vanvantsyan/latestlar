<?php

namespace App\Helpers;

class TourHelper
{
    public static function rus2translit($str)
    {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
            'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        );
        return strtr($str, $converter);
    }

    public static function str2url($str)
    {

        $str = mb_strtolower($str);

        $str = self::rus2translit($str);

        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

    public static function tour2url($tourTitle, $tourId)
    {
        if (strlen($tourTitle) < 50) {
            $url = $tourTitle . "-" . $tourId;
        } else {
            if (preg_match('/^(.+?)\(/iu', $tourTitle, $match)) {
                $url = $match[1] . "-" . $tourId;
            } else {
                $url = $tourTitle . $tourId;
            }
        }
        return self::str2url($url);
    }

    public static function cutTourName($name){
        if (strlen($name) < 50) {
            $cutName = $name;
        } else {
            if (preg_match('/^(.+?)\(/iu', $name, $match)) {
                $cutName = $match[1];
            } else {
                $cutName = substr($name, 0 , 200) . "...";
            }
        }
        return $cutName;
    }
}