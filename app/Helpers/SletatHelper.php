<?php

namespace App\Helpers;

use Sunra\PhpSimple\HtmlDomParser;

class SletatHelper
{
    public static function tourLink($tour)
    {
        return '/sletat/' . $tour[0];
    }
}