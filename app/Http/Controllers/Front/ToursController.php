<?php

namespace App\Http\Controllers\Front;

use App\Helpers\BladeHelper;
use App\Http\Controllers\Controller;
use App\Models\GeneratedSeo;
use App\Models\Geo;
use App\Models\Points;
use App\Models\SlCountries;
use App\Models\SlDepartCities;
use App\Models\SlGeoRelation;
use App\Models\SlHotels;
use App\Models\SlHotelStars;
use App\Models\SlMeals;
use App\Models\SlOperators;
use App\Models\SlResorts;
use App\Models\Tours;
use App\Models\ToursTagsValues;
use App\Models\Ways;
use App\SletatParser;
use Illuminate\Http\Request;
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

    public function getModals()
    {
        $modals = "";

        $modals .= view('front.tours.modal.types');
        $modals .= view('front.tours.modal.cities');
        $modals .= view('front.tours.modal.countries');
        $modals .= view('front.tours.modal.goldens');

        return $modals;
    }

    public function getSeo($params)
    {

        function durationCase($duration)
        {
            if ("8-10" == $duration) {
                return "дней";
            } elseif ("11-13" == $duration) {
                return "дней";
            } elseif ("15-more" == $duration) {
                return "дней";
            } else {
                return BladeHelper::numeralCase('день', $duration);
            }
        }

        function durationNum($duration)
        {
            if ("15-more" == $duration) {
                return "15 и более";
            }

            return $duration;
        }

        $seo = [];

        $seo['pTitle'] = "";
        $seo['bTitle'] = "";
        $seo['metaKey'] = "";
        $seo['metaDesc'] = "";
        $seo['subText'] = "";

        // Есть страна

        if ($country = array_get($params, 'country', null)) {

            $countrySeo = ($country == "Россия") ? "по " . BladeHelper::case($country, "П") : BladeHelper::case($country, "куда");

            $seo['pTitle'] = "Туры " . $countrySeo;
            $seo['bTitle'] = "Туры из Москвы " . $countrySeo;
            $seo['metaKey'] = "туры " . $countrySeo . ", " . date("Y") . " год, из Москвы, купить, поиск";
            $seo['metaDesc'] = "Купить тур из Москвы " . $countrySeo . " в " . date("Y") . " году по низкой цене от компании STARTOUR. Профессиональный подбор туров " . $countrySeo;
            $seo['subText'] = "Поиск и подбор туров " . $countrySeo . " в " . date("Y") . " году на сайте турагенства STARTOUR. Все туры по направлению $country в одном месте.";

            // Курорт
            if ($resort = array_get($params, 'resort', null)) {

                if (!$resort->url == 'moskva') {
                    $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                } else {
                    $resortSeo = BladeHelper::case($resort->title, "куда");;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {

                    if ($tour_type == "Экскурсии") {
                        if ($resort->url == 'moskva') {
                            $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                        } else {
                            $resortSeo = BladeHelper::case($resort->title, "где");;
                        }
                    }

                    $seo['pTitle'] = "$tour_type " . date("Y") . " " . $resortSeo . "";
                    $seo['bTitle'] = "$tour_type " . date("Y") . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . date("Y") . "  в " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . date("Y") . " в " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$tour_type " . date("Y") . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";

                    return $seo;
                }

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $duration " . durationCase($duration) . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " на " . $holiday . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " на " . $holiday . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы на " . $holiday . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . date("Y") . " " . $resortSeo . "";
                    $seo['bTitle'] = "$status " . date("Y") . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $status " . date("Y") . "  " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . date("Y") . " " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$status " . date("Y") . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($month = mb_strtolower(array_get($params, 'month', null))) {
                    $seo['pTitle'] = "Туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $resortSeo;
                $seo['bTitle'] = "Туры " . $resortSeo . " ($country) из Москвы в " . date("Y") . " году по низкой цене";
                $seo['metaKey'] = "Туры " . $resortSeo . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур " . $resortSeo . " " . date("Y") . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
                $seo['subText'] = "Подбор туров " . $resortSeo . " ($country) в турагентстве STARTOUR. Мы поможем Вам найти тур по оптимальной цене.";

                return $seo;

            }

            // Месяц
            if ($month = mb_strtolower(array_get($params, 'month', null))) {

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "Туры " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " года из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $month на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "$tour_type " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . $countrySeo . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . $countrySeo . " с вылетом из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года от турагентства STARTOUR.";
                    $seo['subText'] = "$tour_type " . $countrySeo . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проводите $month на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "$status " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить $status " . $countrySeo . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . $countrySeo . " с вылетом из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года от турагентства STARTOUR.";
                    $seo['subText'] = "$status " . $countrySeo . " из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " дешево от компании STARTOUR. Профессиональный подбор туров. Проводите $month на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                $seo['bTitle'] = "Туры " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                $seo['metaKey'] = "купить тур " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые туры " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                $seo['subText'] = "Туры из Москвы " . $countrySeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров.";
                return $seo;
            }

            // Длительность
            if ($duration = array_get($params, 'duration', null)) {

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "$tour_type " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . date("Y") . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . date("Y") . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "$tour_type на " . date("Y") . " год " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите $duration " . durationCase($duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры на " . $holiday . " " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры на " . $holiday . " " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры на " . $holiday . " " . date("Y") . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры на " . $holiday . " " . date("Y") . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "Туры на " . $holiday . " " . date("Y") . " год " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $duration праздничных " . durationCase($duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "$status " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить $status " . date("Y") . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . date("Y") . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "$status на " . date("Y") . " год " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите$duration " . durationCase($duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                $seo['bTitle'] = "Туры " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                $seo['metaKey'] = "купить тур " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые туры " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR.";
                $seo['subText'] = "Туры из Москвы " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите лучший отдых длинной $duration " . durationCase($duration) . " " . $countrySeo . ".";
                return $seo;
            }

            // Перебор тегов
            if ($tag = array_get($params, 'tag', null)) {


                /* Праздники */
                if ($tag->tag->title == "holiday") {

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status на " . $tag->alias . " " . date("Y") . " " . $countrySeo . "";
                        $seo['bTitle'] = "$status на " . $tag->alias . " " . date("Y") . " " . $countrySeo . " из Москвы";
                        $seo['metaKey'] = "купить $status на " . $tag->alias . " " . date("Y") . "  " . $countrySeo . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые $status на " . $tag->alias . " " . date("Y") . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                        $seo['subText'] = "$status на " . $tag->alias . " " . date("Y") . " " . $countrySeo . " из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите " . $tag->alias . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    $seo['pTitle'] = "Туры на " . $tag->alias . " " . date("Y") . " " . $countrySeo . "";
                    $seo['bTitle'] = "Туры на " . $tag->alias . " " . $countrySeo . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры на " . $tag->alias . " " . $countrySeo . " " . date("Y") . " из Москвы, цена";
                    $seo['metaDesc'] = "Цены на туры " . $countrySeo . " на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                    $seo['subText'] = "Путёвки на " . $tag->alias . " " . date("Y") . " из Москвы " . $countrySeo . " дешево от компании STARTOUR. Проведите незабываемых отдых на " . $tag->alias . " " . $countrySeo . ".";
                    return $seo;

                    /* Статус */
                } elseif ($tag->tag->title == "status") {

                    $seo['pTitle'] = "" . $tag->alias . " " . date("Y") . " " . $countrySeo . "";
                    $seo['bTitle'] = "" . $tag->alias . " " . date("Y") . " " . $countrySeo . " из Москвы";
                    $seo['metaKey'] = "" . $tag->alias . " " . date("Y") . " " . $countrySeo . " из Москвы";
                    $seo['metaDesc'] = "Купить " . $tag->alias . " " . $countrySeo . " с вылетом из Москвы по низкой цене в турагентстве STARTOUR. Профессиональный подбор туров.";
                    $seo['subText'] = "Получите персональное предложение от наших менеджеров. Мы подберем для Вас лучшие " . $tag->alias . " " . $countrySeo . ".";
                    return $seo;

                    /* Тип тура */
                } elseif ($tag->tag->title == "tour_type") {

                    if ($holiday = array_get($params, 'holiday', null)) {

                        $seo['pTitle'] = "" . $tag->alias . " на " . $holiday . " " . date("Y") . " " . $countrySeo . "";
                        $seo['bTitle'] = "" . $tag->alias . " на " . $holiday . " " . date("Y") . " " . $countrySeo . " из Москвы";
                        $seo['metaKey'] = "купить " . $tag->alias . " на " . $holiday . " " . date("Y") . "  " . $countrySeo . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые " . $tag->alias . " на " . $holiday . " " . date("Y") . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "" . $tag->alias . " на " . $holiday . " " . date("Y") . " " . $countrySeo . " из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Встречайте праздники на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status $tag->alias " . date("Y") . " " . $countrySeo . "";
                        $seo['bTitle'] = "$status $tag->alias " . date("Y") . " " . $countrySeo . " из Москвы";
                        $seo['metaKey'] = "купить $status $tag->alias " . date("Y") . " " . $countrySeo . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые $status $tag->alias " . date("Y") . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$status $tag->alias " . date("Y") . " " . $countrySeo . " из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите отдых на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    $seo['pTitle'] = "" . $tag->alias . " " . $countrySeo . "";
                    $seo['bTitle'] = "" . $tag->alias . " " . date("Y") . " " . $countrySeo . " из Москвы";
                    $seo['metaKey'] = "купить " . $tag->alias . " " . $countrySeo . " из Москвы, цена";
                    $seo['metaDesc'] = "Цены на " . $tag->alias . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR.";
                    $seo['subText'] = "" . $tag->alias . " " . date("Y") . " из Москвы " . $countrySeo . " дешево от компании STARTOUR.";
                    return $seo;
                }
            }

            /* — — — — — — — — — — — — — — — — — — —  tours — — — — — — — — — — — — — — — — — — — — */

        } else {

            // Если без страны
            $country = "Россия";
            $countrySeo = ($country == "Россия") ? "по " . BladeHelper::case($country, "П") : BladeHelper::case($country, "куда");

            // Курорт
            if ($resort = array_get($params, 'resort', null)) {

                if (!$resort->url == 'moskva') {
                    $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                } else {
                    $resortSeo = BladeHelper::case($resort->title, "куда");;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . date("Y") . " " . $resortSeo . "";
                    $seo['bTitle'] = "$tour_type " . date("Y") . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . date("Y") . "  " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . date("Y") . " " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$tour_type " . date("Y") . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $duration " . durationCase($duration) . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " на " . $holiday . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " на " . $holiday . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы на " . $holiday . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . date("Y") . " " . $resortSeo . "";
                    $seo['bTitle'] = "$status " . date("Y") . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $status " . date("Y") . "  " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . date("Y") . " " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$status " . date("Y") . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($month = mb_strtolower(array_get($params, 'month', null))) {

                    $seo['pTitle'] = "Туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";

                    $seo['metaKey'] = "купить туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена, $country";

                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " в " . BladeHelper::case($month, "П") . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";

                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . $resort->title;
                $seo['bTitle'] = "Туры " . $resortSeo . " ($country) из Москвы в " . date("Y") . " году по низкой цене";
                $seo['metaKey'] = "Туры " . $resortSeo . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур в " . $resort->title . " " . date("Y") . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
                $seo['subText'] = "Подбор туров  " . $resortSeo . " ($country) в турагентстве STARTOUR. Мы поможем Вам найти тур по оптимальной цене.";
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
                        $seo['metaDesc'] = "Дешевые $status на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$status  из Москвы на " . $tag->alias . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "Туры на " . $tag->alias . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration);
                        $seo['bTitle'] = "Праздничные туры на " . $tag->alias . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, туры на " . $tag->alias . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые туры на " . $tag->alias . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "Туры из Москвы на " . $tag->alias . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники длинной $duration " . durationCase($duration) . " на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = "Туры на " . $tag->alias . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры на " . $tag->alias . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "Туры на " . $tag->alias . " " . date("Y") . " из Москвы, куда поехать на " . $tag->alias . ", отдохнуть, купить тур";
                    $seo['metaDesc'] = "Купить тур на " . $tag->alias . " в турагенстве STARTOUR (Москва). Профессиональный подбор туров на " . $tag->alias . " " . date("Y") . " года по доступным ценам.";
                    $seo['subText'] = "Большой выбор туров на " . $tag->alias . " " . date("Y") . " года. Удобный поиск и профессиональная команда. Всё это позволит Вам провести приятный и незабываемый отдых на " . $tag->alias . ".";
                    return $seo;

                    /* Статус */
                } elseif ($tag->tag->title == "status") {

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "$tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                        $seo['bTitle'] = "$tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, $tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "$tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                        $seo['subText'] = "$tag->alias " . date("Y") . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите отдых длинной $duration " . durationCase($duration) . " на лучших курортах по выгодным ценам.";
                        return $seo;
                    }

                    if ($month = mb_strtolower(array_get($params, 'month', null))) {

                        $seo['pTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias  из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = $tag->alias;
                    $seo['bTitle'] = "" . $tag->alias . " из Москвы в " . date("Y") . " году";
                    $seo['metaKey'] = "$tag->alias " . date("Y") . "  из Москвы, купить, от всех туроператоров";
                    $seo['metaDesc'] = "Купить $tag->alias " . date("Y") . " из Москвы в турагентстве STARTOUR. Широкий выбор туроператоров и низкие цены.";
                    $seo['subText'] = "Заказать $tag->alias с вылетом из Москвы просто - достаточно обратиться в наше турагентство. Наша профессиональная команда подберет для Вас лучший тур по приемлемой цене и Вашим потребностям.";
                    return $seo;

                    /* Тип тура */
                } elseif ($tag->tag->title == "tour_type") {

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "$tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                        $seo['bTitle'] = "$tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, $tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "$tag->alias " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                        $seo['subText'] = "$tag->alias " . date("Y") . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите отдых длинной $duration " . durationCase($duration) . " на лучших курортах по выгодным ценам.";
                        return $seo;
                    }

                    if ($month = mb_strtolower(array_get($params, 'month', null))) {
                        $seo['pTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $month, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status $tag->alias";
                        $seo['bTitle'] = "$status $tag->alias " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $status $tag->alias " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $status $tag->alias  с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$status $tag->alias  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах.";
                        return $seo;
                    }

                    if ($holiday = array_get($params, 'holiday', null)) {
                        $seo['pTitle'] = "$tag->alias на $holiday " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias на $holiday " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias на $holiday " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на $holiday " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias  из Москвы на $holiday " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = "$tag->alias " . date("Y") . "";
                    $seo['bTitle'] = "Цены на $tag->alias " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "Цены на $tag->alias " . date("Y") . " из Москвы, купить путёвку";
                    $seo['metaDesc'] = "Купить путёвку на $tag->alias по доступной цене из Москвы в " . date("Y") . " году. Гарантия лучшего выбор для Вашего отдыха.";
                    $seo['subText'] = "Выгодно купить путёвку на $tag->alias " . date("Y") . " с вылетом из Москвы от всех туроператоров. Профессиональные менеджеру STARTOUR подберут для Вас оптимальное предложение по доступным ценам.";
                    return $seo;

                }
            }

            if ($month = mb_strtolower(array_get($params, 'month', null))) {

                if ($duration = array_get($params, 'duration', null)) {

                    $seo['pTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить тур, Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                    $seo['metaDesc'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                    $seo['subText'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $month на лучших курортах по выгодным ценам.";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                $seo['bTitle'] = "Туры из Москвы в " . BladeHelper::case($month, "П") . " " . date("Y") . "";
                $seo['metaKey'] = "Туры в " . BladeHelper::case($month, "П") . " " . date("Y") . ", Москва, вылет, купить, цены";
                $seo['metaDesc'] = "Купить туры с вылетом из Москвы на $month " . date("Y") . " год в турагенстве STARTOUR. Цены на туры в " . BladeHelper::case($month, "П") . " " . date("Y") . ".";
                $seo['subText'] = "Недорогие туры в " . BladeHelper::case($month, "П") . " " . date("Y") . " года позволят Вам провести незабываемый отдых в разных городах и странах. Специалисты нашего турагентства помогут Вам с выбором путёвки.";
                return $seo;
            }

            $seo['pTitle'] = "Поиск туров";
            $seo['bTitle'] = "Купить туры онлайн из Москвы | Поиск и подбор туров";
            $seo['metaKey'] = "купить тур онлайн, поиск тура, вылет из Москвы, профессиональный подбор";
            $seo['metaDesc'] = "Купить тур онлайн на сайте компании STARTOUR очень просто. Удобный поиск и подбор туров по Вашим предпочтениям.";
            $seo['subText'] = "Компания STARTOUR предлагает удобный поиск туров онлайн. У нас Вы сможете быстро подобрать и купить тур. Профессиональная поддержка специалистов нашего турагенства с момента покупки путевки и на протяжении всего путешествия.";

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

        if ($data['tourPoint']) {
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

        preg_match('/[\d]{2,8}$/', $url, $extractId);

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

        $country = Geo::where('slug', $country)->first();

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
                'metaDesc' => "Забронировать тур " . $tour->title . " в компании STARTOUR.",
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

    /**
     * @param string $country
     * @param string $action
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unit($country = 'russia', $action = '', $url)
    {
        preg_match('/[\d]{2,8}/', $url, $extractId);

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
        })->where('tours.id', '!=', $id)->take(3)->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->get();

        return view('front.tours.tour', [
            'seo' => [
                'bTitle' => $tour->title . " - бронирование тура",
                'metaKey' => $tour->title . ", бронирование тура, купить, цена",
                'metaDesc' => "Забронировать тур " . $tour->title . " в компании STARTOUR.",
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

        // If isset country parametr in uri row
        if ($countryUrl) {
            $country = Geo::where('slug', $countryUrl)->first();
        } else {

            //else try get country parament from POST data form filters
            $filterCountry = $request->input('tourCountry');
            if ($filterCountry) {
                $country = Geo::where('slug', $filterCountry)->first();
            } else {
                $country = null;
            }
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


        /*  Set seo elements */

        // If isset exact seo get it
        $currentLink = preg_replace('~[\S]+.ru\/~i', "", url()->current());
        $seo = GeneratedSeo::where('url', $currentLink)->first();

        // Else create seo by algorithm
        if (!$seo) {
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
        }

        // Get base query by tours
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);

        // Exceptions in duration
        if ($duration == "8-10") {
            $duration = null;

            $durationFrom = 8;
            $durationTo = 10;
        } elseif ($duration == "11-13") {

            $duration = null;

            $durationFrom = 11;
            $durationTo = 13;

        } elseif ($duration == "15-more") {

            $duration = null;
            $durationFrom = 15;
        }

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

        // Join with dates by sorting
        $toursIds = $tours->pluck('tours.id')->toArray();

        if (count($toursIds)) {
            $tours->withDates($toursIds);
        }

        // Select count for counter
        $countTours = $tours->count(DB::raw('DISTINCT tours.id'));

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration');

        if (count($toursIds)) {

            $tours->addSelect(DB::raw("MIN(dv.nearestDate) as nearestDate"));
            $tours->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END");
        }

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
        $countries = Ways::with('country')->where('status', 'country')->take(10)->get();

        return view('front.tours.tours', [
            'tours' => $tours->toArray(),

            'tourDate' => $tourDate,

            'tourTypes' => $tourTypes,
            'countTours' => $countTours,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries,

            'country' => is_object($country) ? $country : null,
            substr(strtolower(class_basename($resort)), 0, -1) => $resort,
            'tag' => $tag,
            'resort' => $resort,

            'month' => $month ?? '',

            'duration' => $durationUrl ?? '',
            'durationFrom' => $durationFrom ?? '',
            'durationTo' => $durationTo ?? '',

            'seo' => $seo,

            'layer' => $layer,

            'postData' => $postParams
        ]);
    }

    public function countryMain(Request $request, $country = 'russia')
    {
        $countryUrl = $request->route('country') ?? $country;

        $country = Geo::where('slug', $countryUrl)->firstOrFail() ?? Geo::where('slug', 'russia')->first();
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
        $countries = Ways::where('status', 'country')->get();

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


        /* Get hot tours */

        $hotToursAny = Tours::take(8)
            ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])
            ->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')
            ->join('geo_relation as geo_r', function ($join) use ($country) {
                $join->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'country')
                    ->where('geo_r.par_id', $country->id);
            })
            ->take(8);

        // Join with dates for order
        $toursIds = $hotToursAny->pluck('tours.id')->toArray();

        if ($toursIds) {

            $hotToursAny = $hotToursAny->withDates($toursIds)
                ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                ->get();
        } else {

            $hotToursAny = [];
        }


        /* Get hot tours with 1 day duration */

        $hotToursOne = Tours::where('duration', 1)
            ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])
            ->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')
            ->join('geo_relation as geo_r', function ($join) use ($country) {
                $join->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'country')
                    ->where('geo_r.par_id', $country->id);
            })
            ->take(8);

        // Join with dates for order
        $toursIds = $hotToursOne->pluck('tours.id')->toArray();

        if ($toursIds) {
            $hotToursOne = $hotToursOne->withDates($toursIds)
                ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                ->get();
        } else {
            $hotToursOne = [];
        }


        /* Get hot tours with many day duration */

        $hotToursMany = Tours::where('duration', '>', 1)
            ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])
            ->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')
            ->join('geo_relation as geo_r', function ($join) use ($country) {
                $join->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'country')
                    ->where('geo_r.par_id', $country->id);
            });


        // Join with dates for order
        $toursIds = $hotToursMany->pluck('tours.id')->toArray();

        if ($toursIds) {
            $hotToursMany = $hotToursMany->withDates($toursIds)
                ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                ->take(8)
                ->get();
        } else {
            $hotToursMany = [];
        }


        /* Get hot tours with active rest */

        $hotToursActive = Tours::join('tour_tags_relations AS ttr', 'ttr.tour_id', '=', 'tours.id')
            ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])
            ->where('ttr.tag_id', 4)
            ->where('ttr.value', 13)
            ->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')
            ->join('geo_relation as geo_r', function ($join) use ($country) {
                $join->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'country')
                    ->where('geo_r.par_id', $country->id);
            });

        // Join with dates for order
        $toursIds = $hotToursActive->pluck('tours.id')->toArray();

        if ($toursIds) {

            $hotToursActive = $hotToursActive->withDates($toursIds)
                ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                ->take(8)
                ->get();
        } else {
            $hotToursActive = [];
        }


        return view('front.tours.russia', [
            'tours' => $tours->toArray(),

            'hotToursAny' => is_object($hotToursAny) ? $hotToursAny->toArray() : [],
            'hotToursOne' => is_object($hotToursOne) ? $hotToursOne->toArray() : [],
            'hotToursMany' => is_object($hotToursMany) ? $hotToursMany->toArray() : [],
            'hotToursActive' => is_object($hotToursActive) ? $hotToursActive->toArray() : [],

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
        $tours = $this->applyFilters($tours, $request->input('params'));


        // Join with dates by sorting
        $toursIds = $tours->pluck('tours.id')->toArray();

        $tours->leftJoin(
            DB::raw("
            (
            SELECT tour_id, MIN(value) as nearestDate 
                FROM tour_tags_relations 
                
                WHERE tag_id = 2 
                AND value > " . time() . " 
                AND tour_id IN(" . implode(',', $toursIds) . ")
            GROUP BY tour_id
            ) as dv
            ")
            ,
            'tours.id', '=', 'dv.tour_id'
        );

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration', DB::raw("MIN(dv.nearestDate) as nearestDate"));

        $tours->groupBy('tours.id', 'dv.nearestDate');
        $tours->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '99999999999999999999999' ELSE dv.nearestDate END");


        // SET limits
        $limit = $request->input('limit');
        $offset = $request->input('offset');

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
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);
        $tours = $this->applyFilters($tours, $request->all());

        // Join with dates by sorting
        $toursIds = $tours->pluck('tours.id')->toArray();

        $tours->leftJoin(
            DB::raw("
            (
            SELECT tour_id, MIN(value) as nearestDate 
                FROM tour_tags_relations 
                
                WHERE tag_id = 2 
                AND value > " . time() . " 
                AND tour_id IN(" . implode(',', $toursIds) . ")
            GROUP BY tour_id
            ) as dv
            ")
            ,
            'tours.id', '=', 'dv.tour_id'
        );

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration', DB::raw("MIN(dv.nearestDate) as nearestDate"));

        $tours->groupBy('tours.id');
        $tours->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '99999999999999999999999' ELSE dv.nearestDate END");

        // Apply limits
        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 0);
        $tours->skip($offset)->take($limit);

        $list = $tours->get();

        if ($list->count()) {
            return view('front.tours.more', ['tours' => $list->toArray()]);
        } else {
            return view('front.tours.empty');
        };
    }

    public function sletat(SletatParser $sletatParser)
    {

//        $cities = $sletatApi->GetTours([
//            "cityFromId" => 832,
//            "countryId" => 35,
//            "cities" => 724,
//            "meals" => 114,
//            "stars" => 401,
//            "s_adults" => 2,
//            'requestId' => 1204004600,
//            'updateResult' => 1
//        ]);
//        dd($cities);

        $hotelsIds = slGeoRelation::where([
            'sub_ess' => 'hotel',
            'par_ess' => 'country',
            'par_id' => 119
        ])->pluck('id');

        return view('front.sletat.form'
            ,
            [
                'slDepartCities' => SlDepartCities::all(),
                'slCountries' => SlCountries::all(),
                'slHotels' => SlHotels::whereIn('id', $hotelsIds)->get(),
                'slHotelStars' => SlHotelStars::all(),
                'slMeals' => SlMeals::all(),
                'slOperators' => SlOperators::all(),
                'slResorts' => SlResorts::all(),
            ]
        );
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

            list($d, $m, $y) = explode('.', head($dateArr));
            $dateFrom = trim("$d.$m.20$y");
            list($d, $m, $y) = explode('.', last($dateArr));
            $dateTo = trim("$d.$m.20$y");
        }

        // Применяем фильтр дат
        if ($dateFrom or $dateTo) {
            $tours->forDate($dateFrom, $dateTo);
        }

        $tours->fromResort(array_get($filters, 'resort', null));
        $tours->fromWay($tourWay = array_get($filters, 'tourWay', null));
        $tours->fromPoint($tourPoint = array_get($filters, 'tourPoint', null));

        if ($sort = array_get($filters, 'sort', null)) {
            if ($sort != 'date-asc') {
                $sortArr = explode('-', $sort);
                $tours->orderBy('tours.' . head($sortArr), last($sortArr));
            }
        }

        $durationFrom = array_get($filters, 'durationFrom', null);
        $durationTo = array_get($filters, 'durationTo', null);
        $duration = array_get($filters, 'duration', null);

        if ($durationFrom) $tours->where('duration', '>=', $durationFrom);
        if ($durationTo && $durationTo != "more") $tours->where('duration', '<=', $durationTo);


        if ($duration) {
            if (preg_match('/^na-(.*)-d/', $duration, $dayCoin)) {
                $tours->where('duration', '=', $dayCoin[1]);
            } else {
                $tours->where('duration', '=', $duration);
            }

        }

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

        $images = json_decode($tour->images, true);

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
