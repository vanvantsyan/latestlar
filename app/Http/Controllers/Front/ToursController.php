<?php

namespace App\Http\Controllers\Front;

use App\Helpers\BladeHelper;
use App\Http\Controllers\Controller;
use App\Models\GeneratedSeo;
use App\Models\Geo;
use App\Models\Period;
use App\Models\Points;
use App\Models\Tours;
use App\Models\ToursTagsValues;
use App\Models\Ways;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Jenssegers\Date\Date;

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


        /**
         * Алгоритм построение SEO в случае присутствия страны.
         */
        if ($country = array_get($params, 'country', null)) {

            $countrySeo = ($country == "Россия") ? "по " . BladeHelper::case($country, "П") : "в " . BladeHelper::case($country, "В");

            $seo['pTitle'] = "Туры " . $countrySeo;
            $seo['bTitle'] = "Туры из Москвы " . $countrySeo;
            $seo['metaKey'] = "туры " . $countrySeo . ", " . date("Y") . " год, из Москвы, купить, поиск";
            $seo['metaDesc'] = "Купить тур из Москвы " . $countrySeo . " в " . date("Y") . " году по низкой цене от компании STARTOUR. Профессиональный подбор туров " . $countrySeo;
            $seo['subText'] = "Поиск и подбор туров " . $countrySeo . " в " . date("Y") . " году на сайте турагенства STARTOUR. Все туры по направлению $country в одном месте.";

            /**
             * Построение SEO, когда в параметрах присутствует курорт.
             * Внутри проверка на тип тура, продолжительность, праздники, статус, месяц и период.
             */
            if ($resort = array_get($params, 'resort', null)) {

                if (!$resort->url == 'moskva') {
                    $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                } else {
                    $resortSeo = "в " . BladeHelper::case($resort->title, "В");;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    
                    if ($resort->url == 'moskva') {
                        $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                    } else {
                        $resortSeo = "в " . BladeHelper::case($resort->title, "П");;
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

                if (array_get($params, 'month', null) || array_get($params, 'period', null)) {
                    
                    $month = mb_strtolower(array_get($params, 'month', null));
                    $period = array_get($params, 'period', null);
                        
                    if ($month)
                        $intervalSeo = "в " . BladeHelper::case($month, "П");
                    elseif ($period) {
                        $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($month, "П"));
                        $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                    }
                    else 
                        $intervalSeo = '';
                    
                    $seo['pTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы" . " " . $intervalSeo . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " .  $month ?? $period_v ?? '' . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $resortSeo;
                $seo['bTitle'] = "Туры " . $resortSeo . " ($country) из Москвы в " . date("Y") . " году по низкой цене";
                $seo['metaKey'] = "Туры " . $resortSeo . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур " . $resortSeo . " " . date("Y") . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
                $seo['subText'] = "Подбор туров " . $resortSeo . " ($country) в турагентстве STARTOUR. Мы поможем Вам найти тур по оптимальной цене.";

                return $seo;

            }

            /**
             * Если курорта нет, тогда проверка для построения SEO идет по месяцу.
             * Внутри проверка на продолжительность, типа тура и статус.
             */
            if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                $month = mb_strtolower(array_get($params, 'month', null));
                $period = array_get($params, 'period', null);

                if ($month)
                    $intervalSeo = "в " . BladeHelper::case($month, "П");
                elseif ($period) {
                    $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($month, "П"));
                    $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                }
                else
                    $intervalSeo = '';

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . " " . $intervalSeo . " " . date("Y") . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить туры " . " " . $intervalSeo . " " . date("Y") . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . " " . $intervalSeo . " " . date("Y") . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " года из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . $countrySeo . " " . $intervalSeo . " " . date("Y") . "";
                    $seo['bTitle'] = "$tour_type " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . date("Y") . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . $countrySeo . " с вылетом из Москвы" . " " . $intervalSeo . " " . date("Y") . " года от турагентства STARTOUR.";
                    $seo['subText'] = "$tour_type " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проводите " . $month ?? $period_v ?? '' . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . $countrySeo . " " . $intervalSeo . " " . date("Y") . "";
                    $seo['bTitle'] = "$status " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " из Москвы";
                    $seo['metaKey'] = "купить $status " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . date("Y") . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . $countrySeo . " с вылетом из Москвы" . " " . $intervalSeo . " " . date("Y") . " года от турагентства STARTOUR.";
                    $seo['subText'] = "$status " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . date("Y") . " дешево от компании STARTOUR. Профессиональный подбор туров. Проводите " . $month ?? $period_v ?? '' . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . date("Y") . "";
                $seo['bTitle'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " из Москвы";
                $seo['metaKey'] = "купить тур " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые туры " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                $seo['subText'] = "Туры из Москвы " . $countrySeo . " " . $intervalSeo . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров.";
                return $seo;
            }

            /**
             * Если нет и месяца, тогда проверка построения SEO идет по продолжительности тура.
             * Внутри проверка на тип тура, статус и праздники.
             */
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

            /**
             * Если нет продолжительности, тогда идет проверка типа тура.
             * Внутри проверка на статус и праздники.
             */
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

        } 
        /**
         * Алгорит построения SEO при отсутствии страны.
         */
        else {

            // При отсутствии страны в параметрах, подразумевается Россия по умолчанию.
            $country = "Россия";
            $countrySeo = ($country == "Россия") ? "по " . BladeHelper::case($country, "П") : "в " . BladeHelper::case($country, "В");

            /**
             * Построение SEO, когда в параметрах присутствует курорт.
             * Внутри проверка на тип тура, продолжительность, праздники, статус, месяц и период.
             */
            if ($resort = array_get($params, 'resort', null)) {

                if (!$resort->url == 'moskva') {
                    $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                } else {
                    $resortSeo = "в " . BladeHelper::case($resort->title, "В");;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {

                    if ($resort->url == 'moskva') {
                        $resortSeo = "по " . BladeHelper::case($resort->title, "П");
                    } else {
                        $resortSeo = "в " . BladeHelper::case($resort->title, "П");;
                    }
                    
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

                if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                    $month = mb_strtolower(array_get($params, 'month', null));
                    $period = array_get($params, 'period', null);

                    if ($month)
                        $intervalSeo = "в " . BladeHelper::case($month, "П");
                    elseif ($period) {
                        $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($month, "П"));
                        $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                    }
                    else
                        $intervalSeo = '';

                    $seo['pTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . " из Москвы";

                    $seo['metaKey'] = "купить туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . " из Москвы, цена, $country";

                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " " . $intervalSeo . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";

                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы" . " " . $intervalSeo . " " . date("Y") . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . $resort->title;
                $seo['bTitle'] = "Туры " . $resortSeo . " ($country) из Москвы в " . date("Y") . " году по низкой цене";
                $seo['metaKey'] = "Туры " . $resortSeo . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур в " . $resort->title . " " . date("Y") . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
                $seo['subText'] = "Подбор туров  " . $resortSeo . " ($country) в турагентстве STARTOUR. Мы поможем Вам найти тур по оптимальной цене.";
                return $seo;
            }

            /**
             * Если курорта нет, тогда проверка для построения SEO идет по типу тура.
             * Внутри проверка на праздники, статус, продолжительность, месяц и тип тура.
             */
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

                    if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                        $month = mb_strtolower(array_get($params, 'month', null));
                        $period = array_get($params, 'period', null);

                        if ($month)
                            $intervalSeo = "в " . BladeHelper::case($month, "П");
                        elseif ($period) {
                            $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($month, "П"));
                            $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                        }
                        else
                            $intervalSeo = '';

                        $seo['pTitle'] = "$tag->alias " . " " . $intervalSeo . " " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias " . " " . $intervalSeo . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias " . " " . $intervalSeo . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias  из Москвы " . " " . $intervalSeo . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . ", отдыхая на лучших курортах.";
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

                    if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                        $month = mb_strtolower(array_get($params, 'month', null));
                        $period = array_get($params, 'period', null);

                        if ($month)
                            $intervalSeo = "в " . BladeHelper::case($month, "П");
                        elseif ($period) {
                            $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($month, "П"));
                            $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                        }
                        else
                            $intervalSeo = '';
                        
                        $seo['pTitle'] = "$tag->alias " . " " . $intervalSeo . " " . date("Y") . "";
                        $seo['bTitle'] = "$tag->alias " . " " . $intervalSeo . " " . date("Y") . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias " . " " . $intervalSeo . " " . date("Y") . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . date("Y") . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias из Москвы " . " " . $intervalSeo . " " . date("Y") . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . ", отдыхая на лучших курортах.";
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

            /**
             * Если типа тура нет, тогда проверка для построения SEO идет по месяцам.
             * Внутри проверка только на продолжительность.
             */
            if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                $month = mb_strtolower(array_get($params, 'month', null));
                $period = array_get($params, 'period', null);

                if ($month)
                    $intervalSeo = "в " . BladeHelper::case($month, "П");
                elseif ($period) {
                    $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($month, "П"));
                    $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                }
                else
                    $intervalSeo = '';
                
                if ($duration = array_get($params, 'duration', null)) {

                    $seo['pTitle'] = "Туры " . $intervalSeo . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры " . $intervalSeo . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить тур, Туры " . $intervalSeo . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                    $seo['metaDesc'] = "Туры " . $intervalSeo . " " . date("Y") . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                    $seo['subText'] = "Туры " . $intervalSeo . " " . date("Y") . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . " на лучших курортах по выгодным ценам.";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $intervalSeo . " " . date("Y") . "";
                $seo['bTitle'] = "Туры из Москвы " . $intervalSeo . " " . date("Y") . "";
                $seo['metaKey'] = "Туры " . $intervalSeo . " " . date("Y") . ", Москва, вылет, купить, цены";
                $seo['metaDesc'] = "Купить туры с вылетом из Москвы на " . $month ?? $period_v ?? '' . date("Y") . " год в турагенстве STARTOUR. Цены на туры " . $intervalSeo . " " . date("Y") . ".";
                $seo['subText'] = "Недорогие туры " . $intervalSeo . " " . date("Y") . " года позволят Вам провести незабываемый отдых в разных городах и странах. Специалисты нашего турагентства помогут Вам с выбором путёвки.";
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
        $similars = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])->join('geo_relation AS gr', function ($query) use ($country) {
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
        $start = microtime(true);
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
        $similars = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])->join('geo_relation AS gr', function ($query) use ($tour) {
            $query->on('gr.sub_id', 'tours.id')
                ->where('sub_ess', 'tour')
                ->where('par_ess', 'way')
                ->where('par_id', array_get($tour, 'parWays.0.waysPar.id', 0));
        })->where('tours.id', '!=', $id)->take(3)->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->get();
//dd(round(microtime(true) - $start, 4));
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

            'tour' => $tour,
            'start' => $start
        ]);
    }

    /**
     * Метод для обработки агрегаций по разным направлениям:
     * tury/{slug2?}/{slug3?}
     * {country}/{slug2?}/{slug3?}
     *
     * @param string $country
     * @param string $slug2
     * @param string $slug3
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, $country = '', $slug2 = '', $slug3 = '')
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

        $month = $resort = $tag = $duration = $tourDate = $period = null;

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
            } elseif (Period::where('slug', $slug)->exists()) {
                $period = Period::where('slug', $slug)->first();
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
                'period' => $period,
            ]);
        }
       
        // Get base query by tours
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);

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
            'month' => $month ?? '',
            'period' => $period ?? '',
        ]);
        
        // Join with dates by sorting
        $toursIds = $tours->pluck('tours.id')->toArray();

        if (count($toursIds)) {
            $tours->withDates(array_unique($toursIds));
        }

        // Select count for counter
        $countTours = $tours->count(DB::raw('DISTINCT tours.id'));

        // Выбираем нужные даты для туров
        $dates = $this->extractDatesFromFilters(compact('tourDate', 'month', 'period'));
        $tours->withDatesInRange(strtotime($dates['dateFrom']), strtotime($dates['dateTo']));

        // Сортируем по дате
        $tours->orderByRaw('-minDate DESC');
     
        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->groupBy('tours.id');
        
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
            
            'period' => $period ?? '',

            'duration' => $durationUrl ?? '',
            'durationFrom' => $durationFrom ?? '',
            'durationTo' => $durationTo ?? '',

            'seo' => $seo,

            'layer' => $layer,

            'postData' => $postParams
        ]);
    }

    /**
     * Метод для обработки агрегаций по странам:
     * {country}
     * Несмотря на то, что в методе пытаются получить $slug2, $slug3 -- 
     * по факту они не используются, потому что запросы со slug2 и slug3 
     * идут по другому маршруту.
     *
     * @param Request $request
     * @param string $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        // If isset exact seo get it
        $currentLink = preg_replace('~[\S]+.ru\/~i', "", url()->current());
        $seo = GeneratedSeo::where('url', $currentLink)->first();
        
        if (!$seo) {
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
        }

      
        // Get base query by tours
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);

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
        // TODO рефакторинг сделать один запрос к которому прибавлять условия

        $hotToursAny = Cache::remember('hotToursAny-'. $country->slug, 1440, function() use($country){
            $hotToursAny = Tours::take(8)
                ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])
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

                return $hotToursAny = $hotToursAny->withDates($toursIds)
                    ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                    ->get();
            } else {
                return $hotToursAny = [];
            }
        });


        /* Get hot tours with 1 day duration */

        $hotToursOne = Cache::remember('hotToursOne-'.$country->slug, 1440, function() use($country) {
            $hotToursOne = Tours::where('duration', 1)
                ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])
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
                return $hotToursOne = $hotToursOne->withDates($toursIds)
                    ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                    ->get();
            } else {
                return $hotToursOne = [];
            }
        });



        /* Get hot tours with many day duration */

        $hotToursMany = Cache::remember('hotToursMany-'.$country->slug, 1440, function() use($country) {
            $hotToursMany = Tours::where('duration', '>', 1)
                ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])
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
                return $hotToursMany = $hotToursMany->withDates($toursIds)
                    ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                    ->take(8)
                    ->get();
            } else {
                return $hotToursMany = [];
            }
        });

        /* Get hot tours with active rest */

        $hotToursActive = Cache::remember('hotToursActive-' . $country->slug, 1440, function () use($country){
            $hotToursActive = Tours::join('tour_tags_relations AS ttr', 'ttr.tour_id', '=', 'tours.id')
                ->with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])
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

                return $hotToursActive = $hotToursActive->withDates($toursIds)
                    ->orderByRaw("CASE WHEN dv.nearestDate is NULL THEN '9999999999' ELSE dv.nearestDate END")
                    ->take(8)
                    ->get();
            } else {
                return $hotToursActive = [];
            }
        });



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
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);
        
        // Проверяем, ведется ли поиск по расширенному диапазону дат.
        $filters = $request->input('params');
        $filters['tourDate'] = $filters['expandedTourDate'] ? $filters['expandedTourDate'] : $filters['tourDate'];
        
        $tours = $this->applyFilters($tours, $filters);

        // Выбираем нужные даты для туров
        $dates = $this->extractDatesFromFilters($filters);
        $tours->withDatesInRange(strtotime($dates['dateFrom']), strtotime($dates['dateTo']));
    
        // Сортируем по дате
        $tours->orderByRaw('-minDate DESC');
        
        // Apply limits
        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->groupBy('tours.id');
        
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
        // Флаг, для определения был ли использован расширенный диапазон дат.
        $expanded = null;
        $filters = $request->all();
        
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);
        $tours = $this->applyFilters($tours, $filters);

        // Если туры по заданным фильтрам не найдены, пробуем расширить диапазон дат.
        if (!$tours->count()) {
            
            while ($filters['tourDate']) {
                $filters['tourDate'] = BladeHelper::expandDatesRange($filters['tourDate']);
                $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);
                $tours = $this->applyFilters($tours, $filters);
                if ($tours->count()) {
                    $expanded = $filters['tourDate'];
                    break;
                }
            }
        }

        // Выбираем нужные даты для туров
        $dates = $this->extractDatesFromFilters($filters);
        $tours->withDatesInRange(strtotime($dates['dateFrom']), strtotime($dates['dateTo']));

        // Сортируем по датам
        $tours->orderByRaw('-minDate DESC');
        
        // Apply limits
        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration')->groupBy('tours.id');
        
        $count = $tours->get()->count();
        
        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 0);
        $tours->skip($offset)->take($limit);

        $list = $tours->get();

        
        if ($list->count()) {
            return view('front.tours.filtered', ['tours' => $list->toArray(), 'expanded' => $expanded, 'count' => $count]);
        } else {
            return view('front.tours.empty');
        }
    }

    public function applyFilters($tours, $filters)
    {
        $tours->FromCountry(array_get($filters, 'country', null));
        $tours->withType(array_get($filters, 'tourType', null));
        $tours->priceFrom(array_get($filters, 'priceFrom', null));
        $tours->priceTo(array_get($filters, 'priceTo', null));

        // Извлекаем даты из фильтров
        $dates = $this->extractDatesFromFilters($filters);

        // Применяем фильтр дат
        $tours->forDate($dates['dateFrom'], $dates['dateTo']);

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

        if ($duration) {
            if (preg_match('/^na-(.*)-d/', $duration, $dayCoin)) {
                $tours->where('duration', '=', $dayCoin[1]);
            } else {
                $tours->where('duration', '=', $duration);
            }
        } else {
            if ($durationFrom) $tours->where('duration', '>=', $durationFrom);
            if ($durationTo && $durationTo != "more") $tours->where('duration', '<=', $durationTo);
        }

        return $tours;
    }

    /**
     * @param $filters
     * @return array
     */
    protected function extractDatesFromFilters($filters)
    {
        $dateFrom = $dateTo = null;

        // Месяцы
        if ($month = array_get($filters, 'month', null)) {
            $dateFrom = date('Y-m-d', strtotime("1 " . $month));
            $dateTo = date('Y-m-d', strtotime("last day of " . $month));
        }

        // Заданные даты
        elseif ($tourDate = array_get($filters, 'tourDate', null)) {

            $dateArr = explode('-', $tourDate);

            list($d, $m, $y) = explode('.', head($dateArr));
            $dateFrom = trim("$d.$m.20$y");
            list($d, $m, $y) = explode('.', last($dateArr));
            $dateTo = trim("$d.$m.20$y");
        }
        
        // Период
        elseif ($period = array_get($filters, 'period', null)) {
            $dateFrom = $period->date_from->format('d.m.Y');
            $dateTo = $period->date_to->format('d.m.Y');
        }
        
        return compact('dateFrom', 'dateTo');
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

        $imagesList = $tour->images ? get_object_vars(json_decode($tour->images)) : [];
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
