<?php

namespace App\Http\Controllers\Front;

use App\Models\Articles;
use App\Models\ArticlesCategories;
use App\Models\Geo;
use App\Models\News;
use App\Models\Points;
use App\Models\Ways;
use App\Models\Tours;
use App\Http\Controllers\Controller;
use App\Helpers\BladeHelper;

use App\Models\ToursTagsRelation;
use App\Models\ToursTagsValues;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function getSeo($params)
    {
        $seo = [];

        $seo['pTitle'] = "";
        $seo['bTitle'] = "";
        $seo['metaKey'] = "";
        $seo['metaDesc'] = "";
        $seo['subText'] = "";

        // Есть страна

        if ($country = array_get($params, 'country', null)) {

            $seo['pTitle'] = "Туры в " . BladeHelper::case($country, "П");
            $seo['bTitle'] = "Туры из Москвы в " . BladeHelper::case($country, "П");
            $seo['metaKey'] = "туры в " . BladeHelper::case($country, "П") . ", " . date("Y") . " год, из Москвы, купить, поиск";
            $seo['metaDesc'] = "Купить тур из Москвы в " . BladeHelper::case($country, "П") . " в " . date("Y") . " году по низкой цене от компании СтарТур. Профессиональный подбор туров в " . BladeHelper::case($country, "П");
            $seo['subText'] = "Поиск и подбор туров в " . BladeHelper::case($country, "П") . " в " . date("Y") . " году на сайте турагенства СтарТур. Все туры по направлению $country в одном месте.";

            // Курорт
            if ($resort = array_get($params, 'resort', null)) {

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . "";
                    $seo['bTitle'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . date("Y") . "  в " . BladeHelper::case($resort->title, "П") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите $duration " . BladeHelper::numeralCase('день', $duration) . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы на " . $holiday . " " . date("Y") . " год дешево от компании СтарТур. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . "";
                    $seo['bTitle'] = "$status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " из Москвы";
                    $seo['metaKey'] = "купить $status " . date("Y") . "  в " . BladeHelper::case($resort->title, "П") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "$status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($month = array_get($params, 'month', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании СтарТур. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . $resort->title;
                $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы в " . date("Y") . " году по низкой цене";
                $seo['metaKey'] = "Туры в " . BladeHelper::case($resort->title, "П") . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур в " . $resort->title . " " . date("Y") . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
                $seo['subText'] = "Подбор туров  в " . BladeHelper::case($resort->title, "П") . " ($country) в турагентстве СтарТур. Мы поможем Вам найти тур по оптимальной цене.";
                return $seo;
            }

            // Месяц
            if ($month = array_get($params, 'month', null)) {

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "  из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " от турагентства СтарТур.";
                    $seo['subText'] = "Туры в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " года из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Проведите $month на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "$tour_type в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type в " . BladeHelper::case($country, "П") . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type в " . BladeHelper::case($country, "П") . " с вылетом из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года от турагентства СтарТур.";
                    $seo['subText'] = "$tour_type в " . BladeHelper::case($country, "П") . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании СтарТур. Профессиональный подбор туров. Проводите $month на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "$status в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить $status в " . BladeHelper::case($country, "П") . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status в " . BladeHelper::case($country, "П") . " с вылетом из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года от турагентства СтарТур.";
                    $seo['subText'] = "$status в " . BladeHelper::case($country, "П") . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " дешево от компании СтарТур. Профессиональный подбор туров. Проводите $month на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                $seo['bTitle'] = "Туры в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                $seo['metaKey'] = "купить тур в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые тур в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур.";
                $seo['subText'] = "Туры из Москвы в " . BladeHelper::case($country, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании СтарТур. Профессиональный подбор туров.";
                return $seo;
            }

            // Длительность
            if ($duration = array_get($params, 'duration', null)) {

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                    $seo['bTitle'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "  из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " от турагентства СтарТур.";
                    $seo['subText'] = "$tour_type на " . date("Y") . " год в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "  из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Проводите $duration " . BladeHelper::numeralCase('день', $duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                    $seo['bTitle'] = "Туры на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " от турагентства СтарТур.";
                    $seo['subText'] = "Туры на " . $holiday . " " . date("Y") . " год в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "  из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Проведите $duration праздничных " . BladeHelper::numeralCase('день', $duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                    $seo['bTitle'] = "$status " . date("Y") . " в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "  из Москвы";
                    $seo['metaKey'] = "купить $status " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " от турагентства СтарТур.";
                    $seo['subText'] = "$status на " . date("Y") . " год в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "  из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Проводите$duration " . BladeHelper::numeralCase('день', $duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                $seo['bTitle'] = "Туры в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                $seo['metaKey'] = "купить тур в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые тур в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур.";
                $seo['subText'] = "Туры из Москвы в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите лучший отдых длинной $duration " . BladeHelper::numeralCase('день', $duration) . " в " . BladeHelper::case($country, "П") . ".";
                return $seo;
            }

            // Перебор тегов
            if ($tag = array_get($params, 'tag', null)) {



                /* Праздники */
                if ($tag->tag->title == "holiday") {

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status на " . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . "";
                        $seo['bTitle'] = "$status на " . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы";
                        $seo['metaKey'] = "купить $status на " . $tag->alias . " " . date("Y") . "  в " . BladeHelper::case($country, "П") . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые $status на " . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                        $seo['subText'] = "$status на " . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Проводите " . $tag->alias . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    $seo['pTitle'] = "Туры на " . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . "";
                    $seo['bTitle'] = "Туры на " . $tag->alias . " в " . BladeHelper::case($country, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры на " . $tag->alias . " в " . BladeHelper::case($country, "П") . " " . date("Y") . " из Москвы, цена";
                    $seo['metaDesc'] = "Цены на туры в " . BladeHelper::case($country, "П") . " на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур.";
                    $seo['subText'] = "Путёвки на " . $tag->alias . " " . date("Y") . " из Москвы в " . BladeHelper::case($country, "П") . " дешево от компании СтарТур. Проведите незабываемых отдых на " . $tag->alias . " в " . BladeHelper::case($country, "П") . ".";
                    return $seo;

                    /* Статус */
                } elseif ($tag->tag->title == "status") {

                    $seo['pTitle'] = "" . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . "";
                    $seo['bTitle'] = "" . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы";
                    $seo['metaKey'] = "" . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы";
                    $seo['metaDesc'] = "Купить " . $tag->alias . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы по низкой цене в турагентстве СтарТур. Профессиональный подбор туров.";
                    $seo['subText'] = "Получите персональное предложение от наших менеджеров. Мы подберем для Вас лучшие " . $tag->alias . " в " . BladeHelper::case($country, "П") . ".";
                    return $seo;

                    /* Тип тура */
                } elseif ($tag->tag->title == "tour_type") {

                    if ($holiday = array_get($params, 'holiday', null)) {

                        $seo['pTitle'] = "" . $tag->alias . " на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . "";
                        $seo['bTitle'] = "" . $tag->alias . " на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы";
                        $seo['metaKey'] = "купить " . $tag->alias . " на " . $holiday . " " . date("Y") . "  в " . BladeHelper::case($country, "П") . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые " . $tag->alias . " на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "" . $tag->alias . " на " . $holiday . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Встречайте праздники на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status $tag->alias " . date("Y") . " в " . BladeHelper::case($country, "П") . "";
                        $seo['bTitle'] = "$status $tag->alias " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы";
                        $seo['metaKey'] = "купить $status $tag->alias " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые $status $tag->alias " . date("Y") . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "$status $tag->alias " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Проводите отдых на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    $seo['pTitle'] = "" . $tag->alias . " в " . BladeHelper::case($country, "П") . "";
                    $seo['bTitle'] = "" . $tag->alias . " " . date("Y") . " в " . BladeHelper::case($country, "П") . " из Москвы";
                    $seo['metaKey'] = "купить " . $tag->alias . " в " . BladeHelper::case($country, "П") . " из Москвы, цена";
                    $seo['metaDesc'] = "Цены на " . $tag->alias . " в " . BladeHelper::case($country, "П") . " с вылетом из Москвы от турагентства СтарТур.";
                    $seo['subText'] = "" . $tag->alias . " " . date("Y") . " из Москвы в " . BladeHelper::case($country, "П") . " дешево от компании СтарТур.";
                    return $seo;
                }
            }

            if ($duration = array_get($params, 'duration', null)) {

                $seo['pTitle'] = "Туры в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                $seo['bTitle'] = "Туры в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                $seo['metaKey'] = "купить тур в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые тур в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур.";
                $seo['subText'] = "Туры из Москвы в " . BladeHelper::case($country, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите лучший отдых длинной $duration " . BladeHelper::numeralCase('день', $duration) . " в " . BladeHelper::case($country, "П") . ".";
            }

// Если без страны

        } else {

            // Курорт
            if ($resort = array_get($params, 'resort', null)) {

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . "";
                    $seo['bTitle'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . date("Y") . "  в " . BladeHelper::case($resort->title, "П") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "$tour_type " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($resort->title, "П") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите $duration " . BladeHelper::numeralCase('день', $duration) . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($resort->title, "П") . " на " . $holiday . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы на " . $holiday . " " . date("Y") . " год дешево от компании СтарТур. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . "";
                    $seo['bTitle'] = "$status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " из Москвы";
                    $seo['metaKey'] = "купить $status " . date("Y") . "  в " . BladeHelper::case($resort->title, "П") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "$status " . date("Y") . " в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($month = array_get($params, 'month', null)) {
                    $seo['pTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($resort->title, "П") . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур. Отдых в " . BladeHelper::case($country, "П") . ".";
                    $seo['subText'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании СтарТур. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . $resort->title;
                $seo['bTitle'] = "Туры в " . BladeHelper::case($resort->title, "П") . " ($country) из Москвы в " . date("Y") . " году по низкой цене";
                $seo['metaKey'] = "Туры в " . BladeHelper::case($resort->title, "П") . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур в " . $resort->title . " " . date("Y") . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
                $seo['subText'] = "Подбор туров  в " . BladeHelper::case($resort->title, "П") . " ($country) в турагентстве СтарТур. Мы поможем Вам найти тур по оптимальной цене.";
                return $seo;
            }

            // Перебор тегов
            if ($tag = array_get($params, 'tag', null)) {

                /* Праздники */
                if ($tag->tag->title == "holiday") {

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status на " . $tag->alias . " " . date("Y") . "";
                        $seo['bTitle'] = "$status на " . $tag->alias . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $status на " . $tag->alias . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $status на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "$status  из Москвы на " . $tag->alias . " " . date("Y") . " год дешево от компании СтарТур. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "Туры на " . $tag->alias . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration);
                        $seo['bTitle'] = "Праздничные туры на " . $tag->alias . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, туры на " . $tag->alias . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые туры на " . $tag->alias . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "Туры из Москвы на " . $tag->alias . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите праздники длинной $duration " . BladeHelper::numeralCase('день', $duration) . " на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = "Туры на " . $tag->alias . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры на " . $tag->alias . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "Туры на " . $tag->alias . " " . date("Y") . " из Москвы, куда поехать на " . $tag->alias . ", отдохнуть, купить тур";
                    $seo['metaDesc'] = "Купить тур на " . $tag->alias . " в турагенстве СтарТур (Москва). Профессиональный подбор туров на " . $tag->alias . " " . date("Y") . " года по доступным ценам.";
                    $seo['subText'] = "Большой выбор туров на " . $tag->alias . " " . date("Y") . " года. Удобный поиск и профессиональная команда. Всё это позволит Вам провести приятный и незабываемый отдых на " . $tag->alias . ".";
                    return $seo;

                    /* Статус */
                } elseif ($tag->tag->title == "status") {

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "$tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                        $seo['bTitle'] = "$tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, $tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "$tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур. Выгодные цены на путевки.";
                        $seo['subText'] = "$tag->alias " . date("Y") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите отдых длинной $duration " . BladeHelper::numeralCase('день', $duration) . " на лучших курортах по выгодным ценам.";
                        return $seo;
                    }

                    if ($month = array_get($params, 'month', null)) {

                        $seo['pTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "$tag->alias  из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " год дешево от компании СтарТур. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = $tag->alias;
                    $seo['bTitle'] = "" . $tag->alias . " из Москвы в " . date("Y") . " году";
                    $seo['metaKey'] = "$tag->alias " . date("Y") . "  из Москвы, купить, от всех туроператоров";
                    $seo['metaDesc'] = "Купить $tag->alias " . date("Y") . " из Москвы в турагентстве СтарТур. Широкий выбор туроператоров и низкие цены.";
                    $seo['subText'] = "Заказать $tag->alias с вылетом из Москвы просто - достаточно обратиться в наше турагентство. Наша профессиональная команда подберет для Вас лучший тур по приемлемой цене и Вашим потребностям.";
                    return $seo;

                    /* Тип тура */
                } elseif ($tag->tag->title == "tour_type") {

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "$tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                        $seo['bTitle'] = "$tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, $tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "$tag->alias " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур. Выгодные цены на путевки.";
                        $seo['subText'] = "$tag->alias " . date("Y") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите отдых длинной $duration " . BladeHelper::numeralCase('день', $duration) . " на лучших курортах по выгодным ценам.";
                        return $seo;
                    }

                    if ($month = array_get($params, 'month', null)) {
                        $seo['pTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "$tag->alias из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " год дешево от компании СтарТур. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status $tag->alias";
                        $seo['bTitle'] = "$status $tag->alias " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $status $tag->alias " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $status $tag->alias  с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "$status $tag->alias  из Москвы дешево от компании СтарТур. Профессиональный подбор туров. Отдыхайте на лучших курортах.";
                        return $seo;
                    }

                    if ($holiday = array_get($params, 'holiday', null)) {
                        $seo['pTitle'] = "$tag->alias на $holiday " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias на $holiday " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias на $holiday " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на $holiday " . date("Y") . " с вылетом из Москвы от турагентства СтарТур.";
                        $seo['subText'] = "$tag->alias  из Москвы на $holiday " . date("Y") . " год дешево от компании СтарТур. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = "$tag->alias " . date("Y") . "";
                    $seo['bTitle'] = "Цены на $tag->alias " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "Цены на $tag->alias " . date("Y") . " из Москвы, купить путёвку";
                    $seo['metaDesc'] = "Купить путёвку на $tag->alias по доступной цене из Москвы в " . date("Y") . " году. Гарантия лучшего выбор для Вашего отдыха.";
                    $seo['subText'] = "Выгодно купить путёвку на $tag->alias " . date("Y") . " с вылетом из Москвы от всех туроператоров. Профессиональные менеджеру СтарТур подберут для Вас оптимальное предложение по доступным ценам.";
                    return $seo;

                }
            }

            if ($month = array_get($params, 'month', null)) {

                if ($duration = array_get($params, 'duration', null)) {

                    $seo['pTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы";
                    $seo['metaKey'] = "купить тур, Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " из Москвы, цена";
                    $seo['metaDesc'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на $duration " . BladeHelper::numeralCase('день', $duration) . " с вылетом из Москвы от турагентства СтарТур. Выгодные цены на путевки.";
                    $seo['subText'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы на $duration " . BladeHelper::numeralCase('день', $duration) . " дешево от компании СтарТур. Профессиональный подбор туров. Проведите $month на лучших курортах по выгодным ценам.";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                $seo['bTitle'] = "Туры из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                $seo['metaKey'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . ", Москва, вылет, купить, цены";
                $seo['metaDesc'] = "Купить туры с вылетом из Москвы на $month " . date("Y") . " год в турагенстве СтарТур. Цены на туры в " . BladeHelper::case($month, "П") . " " . date("Y") . ".";
                $seo['subText'] = "Недорогие туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " года позволят Вам провести незабываемый отдых в разных городах и странах. Специалисты нашего турагентства помогут Вам с выбором путёвки.";
                return $seo;
            }

            $seo['pTitle'] = "Поиск туров";
            $seo['bTitle'] = "Купить туры онлайн из Москвы | Поиск и подбор туров";
            $seo['metaKey'] = "купить тур онлайн, поиск тура, вылет из Москвы, профессиональный подбор";
            $seo['metaDesc'] = "Купить тур онлайн на сайте компании СтарТур очень просто. Удобный поиск и подбор туров по Вашим предпочтениям.";
            $seo['subText'] = "Компания СтарТур предлагает удобный поиск туров онлайн. У нас Вы сможете быстро подобрать и купить тур. Профессиональная поддержка специалистов нашего турагенства с момента покупки путевки и на протяжении всего путешествия.";

        }

        return $seo;
    }

    public function getSeoTours(Request $request)
    {
        $data = $request->all();
        $resort = $tag = null;

        if ($data['tourType']) {
            $tag = ToursTagsValues::with('tag')->find($data['tourType']);
        }

        if($data['tourPoint']){
            $resort = Points::where('title', $data['tourPoint'])->first();
        }

        // Set seo elements
        $seo = $this->getSeo([
            'resort' => is_object($resort) ? $resort : null,
            'tag' => is_object($tag) ? $tag : null,
            'tour_type' => $tour_type ?? '',
        ]);

        return $seo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */

    public function unitCountry($country = 'russia', $url)
    {
        preg_match('/[\d]{3,8}/', $url, $extractId);

        if (count($extractId)) {
            $id = $extractId[0];
        } else {
            $id = '2070';
        }

        /* — — Get values for sidebar — — */

        // Get tours type
        $tourTypes = ToursTagsValues::where('tag_id', 4)->get();

        // Get cities list
        $cities = Points::where('status', 'city')->where('off', 0)->take(10)->get();

        // Get cities for "Золотое кольцо"
        $citiesGolden = Points::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)->take(10)->get();

        // Get countries list
        $countries = Ways::where('status', 'country')->take(10)->get();

        $tour = Tours::findOrFail($id);

        $country = Geo::where('slug', $country)->get();

        // Similar tours
        $similars = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->join('geo_relation AS gr', function ($query) use ($country) {
            $query->on('gr.sub_id', 'tours.id')
                ->where('sub_ess', 'tour')
                ->where('par_ess', 'country')
                ->where('par_id', array_get($country, '0.id'));
        })->take(3)->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->get();

        return view('front.tours.tour', [
            'seo' => [
                'bTitle' => $tour->title . " - бронирование тура",
                'metaKey' => $tour->title . ", бронирование тура, купить, цена",
                'metaDesc' => "Забронировать тур " . $tour->title . " в компании СтарТур.",
                'subText' => "",
            ],

            'tourTypes' => $tourTypes,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries,

            'country' => $country,
            'similars' => $similars,
            'tour' => $tour
        ]);
    }

    public function unit($country = 'russia', $action = '', $url)
    {
        preg_match('/[\d]{3,8}/', $url, $extractId);

        if (count($extractId)) {
            $id = $extractId[0];
        } else {
            $id = '2070';
        }

        /* — — Get values for sidebar — — */

        // Get tours type
        $tourTypes = ToursTagsValues::where('tag_id', 4)->get();

        // Get cities list
        $cities = Points::where('status', 'city')->where('off', 0)->take(10)->get();

        // Get cities for "Золотое кольцо"
        $citiesGolden = Points::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)->take(10)->get();

        // Get countries list
        $countries = Ways::where('status', 'country')->take(10)->get();

        // Get tour Data
        $tour = Tours::with('parWays.waysPar')->findOrFail($id);

        // Similar tours
        $similars = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->join('geo_relation AS gr', function ($query) use ($tour) {
            $query->on('gr.sub_id', 'tours.id')
                ->where('sub_ess', 'tour')
                ->where('par_ess', 'way')
                ->where('par_id', array_get($tour, 'parWays.0.waysPar.id', 0));
        })->take(3)->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->get();

        return view('front.tours.tour', [
            'seo' => [
                'bTitle' => $tour->title . " - бронирование тура",
                'metaKey' => $tour->title . ", бронирование тура, купить, цена",
                'metaDesc' => "Забронировать тур " . $tour->title . " в компании СтарТур.",
                'subText' => "",
            ],

            'tourTypes' => $tourTypes,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries,

            'similars' => $similars,

            'tour' => $tour
        ]);
    }

    /**
     * Display tours list with parameters
     */
    public function list($country = '', $slug2 = '', $slug3 = '', Request $request)
    {

        $countryUrl = $request->route('country');
        if($countryUrl) {
            $country = Geo::where('slug', $countryUrl)->first();
        } else {
            $country = null;
        }


        $slug2 = $request->route('slug2');
        $slug3 = $request->route('slug3');

        // Variable for sidebar displaying
        if ($slug3) {
            $layer = 3;
        } else {
            $layer = ($slug2) ? 2 : 1;
        }

        $monthsRus = config('main.month');
        $months = array_flip($monthsRus);

        $month = $resort = $tag = $duration = $tourDate = null;

        // Get form params
        $postParams = $request->all();

        if ($point = array_get($postParams, 'tourPoint', null)) {
            $resort = Points::where('title', $point)->first();
        }

        $tourDate = array_get($postParams, 'tourDate', null);
        $durationFrom = array_get($postParams, 'durationFrom', null);
        $durationTo = array_get($postParams, 'durationTo', null);
        $tourType = array_get($postParams, 'tourType', null);
        $priceFrom = array_get($postParams, 'priceFrom', null);
        $priceTo = array_get($postParams, 'priceTo', null);

        // Set filter elements
        foreach ([$slug2, $slug3] as $slug) {

            if (preg_match('/tury-(.*)/', $slug, $match)) {

                $resort = Ways::where('url', last($match))->first() ?? Points::where('url', last($match))->first();

            } elseif (ToursTagsValues::with('tag')->where('value', $slug)->exists()) {

                // Set var tag type
                $tag = ToursTagsValues::with('tag')->where('value', $slug)->first();
                $tagName = $tag->tag->title;
                $$tagName = $tag->alias;

            } elseif (preg_match('/^na-(.*)-d/', $slug, $dayCoin)) {
                $duration = $dayCoin[1];
                $durationUrl = $slug;

            } elseif (in_array($slug, $months)) {
                $month = $slug;
            }
        }

        // Set seo elements
        $seo = $this->getSeo([
            'country' => is_object($country) ? $country->country : null,
            'resort' => is_object($resort) ? $resort : null,
            'tag' => is_object($tag) ? $tag : null,
            'month' => $month ? $monthsRus[$month] : '',
            'duration' => $duration ?? '',
            'holiday' => $holiday ?? '',
            'status' => $status ?? '',
            'tour_type' => $tour_type ?? '',
        ]);

        // Get base query by tours
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);

        // Apply filters by tours
        $tours = $this->applyFilters($tours, [
            'tourDate' => $tourDate ?? '',
            'country' => is_object($country) ? $country->slug : null,
            'resort' => is_object($resort) ? $resort : null,

            'tourType' => is_object($tag) ? $tag->id : $tourType,

            'durationFrom' => $durationFrom,
            'durationTo' => $durationTo,

            'priceFrom' => $priceFrom,
            'priceTo' => $priceTo,

            'duration' => $duration,
            'month' => $month ?? ''
        ]);

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration');

        // Select count for counter
        $countTours = $tours->count(DB::raw('DISTINCT tours.id'));

        $tours->groupBy('tours.id');

        // Get tours object list
        $tours = $tours->take(15)->get();


        /* — — Get values for sidebar — — */

        // Get tours type
        $tourTypes = ToursTagsValues::where('tag_id', 4)->get();

        // Get cities list
        $cities = Points::where('status', 'city')->where('off', 0)->take(10)->get();

        // Get cities for "Золотое кольцо"
        $citiesGolden = Points::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)->take(10)->get();

        // Get countries list
        $countries = Ways::where('status', 'country')->take(10)->get();

        return view('front.tours.tours', [
            'tours' => $tours->toArray(),

            'tourDate' => $tourDate,

            'tourTypes' => $tourTypes,
            'countTours' => $countTours,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries,

            'country' => is_object($country) ? $country->slug : null,
            substr(strtolower(class_basename($resort)), 0, -1) => $resort,
            'tag' => $tag,

            'month' => $month ?? '',
            'duration' => $durationUrl ?? '',
            'seo' => $seo,

            'layer' => $layer,

            'postData' => $postParams
        ]);
    }

    public function countryMain(Request $request, $country = 'russia')
    {
        $countryUrl = $request->route('country') ?? $country;
        $country = Geo::where('slug', $countryUrl)->first();

        $slug2 = $request->route('slug2');
        $slug3 = $request->route('slug3');

        // Variable for sidebar displaying
        if ($slug3) {
            $layer = 3;
        } else {
            $layer = ($slug2) ? 2 : 1;
        }

        $monthsRus = config('main.month');
        $months = array_flip($monthsRus);

        $month = $resort = $tag = $duration = null;

        // Set filter elements
        foreach ([$slug2, $slug3] as $slug) {

            if (preg_match('/tury-(.*)/', $slug, $match)) {

                $resort = Ways::where('url', last($match))->first() ?? Points::where('url', last($match))->first();

            } elseif (ToursTagsValues::with('tag')->where('value', $slug)->exists()) {

                // Set var tag type
                $tag = ToursTagsValues::with('tag')->where('value', $slug)->first();
                $tagName = $tag->tag->title;
                $$tagName = $tag->alias;

            } elseif (preg_match('/^na-(.*)-d/', $slug, $dayCoin)) {
                $duration = $dayCoin[1];
                $durationUrl = $slug;

            } elseif (in_array($slug, $months)) {
                $month = $slug;
            }
        }

        // Set seo elements
        $seo = $this->getSeo([
            'country' => is_object($country) ? $country->country : null,
            'resort' => is_object($resort) ? $resort : null,
            'tag' => is_object($tag) ? $tag : null,
            'month' => $month ? $monthsRus[$month] : '',
            'duration' => $duration ?? '',
            'holiday' => $holiday ?? '',
            'status' => $status ?? '',
            'tour_type' => $tour_type ?? '',
        ]);

        // Get base query by tours
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);

        // Apply filters by tours
        $tours = $this->applyFilters($tours, [
            'country' => is_object($country) ? $country->slug : null,
            'resort' => is_object($resort) ? $resort : null,
            'tourType' => is_object($tag) ? $tag->id : null,
            'duration' => $duration ?? '',
            'month' => $month ?? ''
        ]);

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration');

        // Select count for counter
        $countTours = $tours->count();

        // Get tours object list
        $tours = $tours->take(15)->get();


        /* — — Get values for sidebar — — */

        // Get tours type
        $tourTypes = ToursTagsValues::where('tag_id', 4)->get();

        // Get cities list
        $cities = Points::where('status', 'city')->where('off', 0)->take(10)->get();

        // Get cities for "Золотое кольцо"
        $citiesGolden = Points::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)->take(10)->get();

        // Get countries list
        $countries = Ways::where('status', 'country')->take(10)->get();

        // Get countries for grid
        $countriesGrid = Ways::whereIn('ways.id', [319, 419, 387, 405, 323])->join('geo_relation AS gr', function ($join) {
            $join->on('gr.par_id', '=', 'ways.id')
                ->where('gr.par_ess', '=', 'way')
                ->where('gr.sub_ess', '=', 'tour');
        })->join('tours', 'gr.sub_id', '=', 'tours.id')->where('tours.price', '>', 0)->select('ways.*', DB::raw('min(tours.price) as minPrice'))->groupBy('ways.id')->get()->keyBy('id');

        $typesGrid = ToursTagsValues::whereIn('tours_tags_values.id', [39, 25])->join('tour_tags_relations AS tr', function ($join) {
            $join->on('tr.value', '=', 'tours_tags_values.id')
                ->where('tr.tag_id', '=', 4);
        })->join('tours', 'tr.tour_id', '=', 'tours.id')->where('tours.price', '>', 0)->select('tours_tags_values.*', DB::raw('min(tours.price) as minPrice'))->groupBy('tours_tags_values.id')->get()->keyBy('id');

        // Горячие туры
        $hotToursAny = Tours::take(8)->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->get();
        $hotToursOne = Tours::where('duration', 1)->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->take(8)->get();
        $hotToursMany = Tours::where('duration', '>', 1)->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->take(8)->get();
        $hotToursActive = Tours::join('tour_tags_relations AS ttr', 'ttr.tour_id', '=', 'tours.id')->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->where('ttr.tag_id', 4)->where('ttr.value', 13)->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->take(8)->get();

        return view('front.tours.russia', [
            'tours' => $tours->toArray(),

            'hotToursAny' => $hotToursAny->toArray(),
            'hotToursOne' => $hotToursOne->toArray(),
            'hotToursMany' => $hotToursMany->toArray(),
            'hotToursActive' => $hotToursActive->toArray(),

            'tourTypes' => $tourTypes,
            'countTours' => $countTours,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries,

            'countriesGrid' => $countriesGrid,
            'typesGrid' => $typesGrid,

            'country' => is_object($country) ? $country : null,
            substr(strtolower(class_basename($resort)), 0, -1) => $resort,
            'tag' => $tag,

            'month' => $month ?? '',
            'duration' => $durationUrl ?? '',
            'seo' => $seo,

            'layer' => $layer
        ]);
    }

    public function getMore(Request $request)
    {
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration', DB::raw('COUNT(tours.id) as countDate'), 'ttrDate.tour_id');

        $limit = $request->input('limit');
        $offset = $request->input('offset');

        $tours = $this->applyFilters($tours, $request->input('params'));

        $tours->groupBy('tours.id');

        $tours->skip($offset)->take($limit);

        $list = $tours->get();

        return view('front.tours.more', ['tours' => $list->toArray()]);
    }

    public function getCount(Request $request)
    {
        $tours = Tours::select('tours.id');
        $tours = $this->applyFilters($tours, $request->all());
        $tours->groupBy('tours.id');

        return count($tours->get()->toArray());
    }

    public function filters(Request $request)
    {
        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 0);

        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);
        $tours->skip($offset)->take($limit);
        $tours = $this->applyFilters($tours, $request->all());

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration', 'ttrDate.tour_id');

        $tours->groupBy('tours.id');

        $list = $tours->get();

        if ($list->count()) {
            return view('front.tours.more', ['tours' => $list->toArray()]);
        } else {
            return view('front.tours.empty');
        };
    }

    public function applyFilters($tours, $filters)
    {
        $tours->FromCountry(array_get($filters, 'country', null));
        $tours->withType(array_get($filters, 'tourType', null));
        $tours->priceFrom(array_get($filters, 'priceFrom', null));
        $tours->priceTo(array_get($filters, 'priceTo', null));

        $dateFrom = $dateTo = null;

        // Месяцы
        if ($month = array_get($filters, 'month', null)) {
            $dateFrom = strtotime("1 " . $month);
            $dateTo = strtotime("last day of " . $month);
        }

        // Заданные даты
        if ($tourDate = array_get($filters, 'tourDate', null)) {

            $dateArr = explode('-', $tourDate);
            $dateFrom = trim(head($dateArr));
            $dateTo = trim(last($dateArr));
        }

        // Применяем фильтр дат
        if ($dateFrom or $dateTo) {
            $tours->forDate($dateFrom, $dateTo);
        }

        $tours->fromResort(array_get($filters, 'resort', null));
        $tours->fromWay($tourWay = array_get($filters, 'tourWay', null));
        $tours->fromPoint($tourPoint = array_get($filters, 'tourPoint', null));

        if ($sort = array_get($filters, 'sort', null)) {
            $sortArr = explode('-', $sort);
            $tours->orderBy('tours.' . head($sortArr), last($sortArr));
        }

        $durationFrom = array_get($filters, 'durationFrom', null);
        $durationTo = array_get($filters, 'durationTo', null);
        $duration = array_get($filters, 'duration', null);

        if ($durationFrom) $tours->where('duration', '>', $durationFrom);
        if ($durationTo) $tours->where('duration', '<', $durationTo);
        if ($duration) $tours->where('duration', '=', $duration);

        return $tours;
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $results = array();

        $queries = DB::table('points')
            ->where('title', 'LIKE', '%' . $term . '%')
            ->take(5)->get();

        foreach ($queries as $query) {
            $results[] = ['id' => $query->id, 'value' => $query->title];
        }
        return Response::json($results);
    }

    public function getImages(Request $request)
    {
        $tour = Tours::find($request->id);
        $dropzone = [];

        foreach (json_decode($tour->images) as $image) {

            $filePath = public_path(config('main.imgPath.tour') . 'full/' . substr($tour->id, 0, 2) . '/' . $image);

            if (File::exists($filePath)) {

                $obj = [];

                $obj['name'] = $image;
                $obj['size'] = File::size($filePath);
                $obj['thumb'] = BladeHelper::tourThumb($image, $tour->id);

                $dropzone[] = $obj;
            }

        }
        return json_encode($dropzone);
    }

    public function uploadImage(Request $request)
    {

        $image = $request->file('file');
        $imgObj = Image::make($image);
        $imageName = time() . '.jpg';
        $tour = Tours::find($request->tourId);

        $folderFullPath = public_path('img\tours\full/' . substr($tour->id, 0, 2));

        if (!File::exists($folderFullPath)) {
            File::makeDirectory($folderFullPath, $mode = 0777, true, true);
        }

        if ($imgObj->width() > 600) {

            $imgObj->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderFullPath . '/' . $imageName, 100);

        $folderThumbPath = public_path('img\tours\thumbs/' . substr($tour->id, 0, 2));

        if (!File::exists($folderThumbPath)) {
            File::makeDirectory($folderThumbPath, $mode = 0777, true, true);
        }

        if ($imgObj->height() > 235) {

            $imgObj->resize(null, 235, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderThumbPath . '/' . $imageName, 75);

        $imagesList = get_object_vars(json_decode($tour->images));
        $imagesList[] = $imageName;

        $tour->images = json_encode($imagesList);

        if ($tour->save()) {
            return response()->json(['success' => $imageName]);
        } else {
            return response()->json(['error' => 'images not saved', 'success' => 0]);
        }

    }

    public function removeImage(Request $request)
    {
        $tour = Tours::find($request->id);
        $images = get_object_vars(json_decode($tour->images));

        foreach ($images as $key => $value) {
            if ($value == $request->name) unset($images[$key]);
        }

        $tour->images = json_encode($images);

        if ($tour->save()) {
            File::delete(public_path(config('main.imgPath.tour') . 'full/' . substr($tour->id, 0, 2) . '/' . $request->name));
            File::delete(public_path(config('main.imgPath.tour') . 'thumbs/' . substr($tour->id, 0, 2) . '/' . $request->name));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function edit(Tours $tours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tours $tours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tours $tours)
    {
        //
    }
}
