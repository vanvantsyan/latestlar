<?php

namespace App\Http\Controllers\Front;

use App\Helpers\BladeHelper;
use App\Helpers\TemplateTransformer;
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
     * Трансформер для шаблонных строк.
     * 
     * @var TemplateTransformer 
     */
    private $transformer;

    /**
     * ToursController constructor.
     * @param TemplateTransformer $transformer
     */
    public function __construct(TemplateTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    
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

        // Устанавливаем дефолтные параметры трансформера
        $seo['temp_params'] = [];
        
        // Если есть дата, то устанаилваем параметр трансформации года
        $filters = $params;
        $filters['month'] = array_search($params['month'] ?? '', config('main.month'));
        $dates = $this->extractDatesFromFilters($filters, $datetime = true);
        if ($dates['dateTo'] && $dates['dateTo']->format('Y') > now()->format('Y'))
            $seo['temp_params']['breakpoint-date'] = now()->subDay(1)->format('Y-m-d');
        
        // Ставим год в виде шаблона
        $year = '|year|';

        /**
         * Алгоритм построение SEO в случае присутствия страны.
         */
        if ($country = array_get($params, 'country', null)) {

            $countrySeo = ($country == "Россия") ? "по " . BladeHelper::case($country, "П") : "в " . BladeHelper::case($country, "В");

            $seo['pTitle'] = "Туры " . $countrySeo;
            $seo['bTitle'] = "Туры из Москвы " . $countrySeo;
            $seo['metaKey'] = "туры " . $countrySeo . ", " . $year . " год, из Москвы, купить, поиск";
            $seo['metaDesc'] = "Купить тур из Москвы " . $countrySeo . " в " . $year . " году по низкой цене от компании STARTOUR. Профессиональный подбор туров " . $countrySeo;
            $seo['subText'] = "Поиск и подбор туров " . $countrySeo . " в " . $year . " году на сайте турагенства STARTOUR. Все туры по направлению $country в одном месте.";

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

                    $seo['pTitle'] = "$tour_type " . $year . " " . $resortSeo . "";
                    $seo['bTitle'] = "$tour_type " . $year . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . $year . "  в " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . $year . " в " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$tour_type " . $year . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";

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
                    $seo['pTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . $year . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . $year . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " на " . $holiday . " " . $year . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " на " . $holiday . " " . $year . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы на " . $holiday . " " . $year . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . $year . " " . $resortSeo . "";
                    $seo['bTitle'] = "$status " . $year . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $status " . $year . "  " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . $year . " " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$status " . $year . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if (array_get($params, 'month', null) || array_get($params, 'period', null)) {
                    
                    $month = mb_strtolower(array_get($params, 'month', null));
                    $period = array_get($params, 'period', null);
                        
                    if ($month)
                        $intervalSeo = "в " . BladeHelper::case($month, "П");
                    elseif ($period) {
                        $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($period->title, "П"));
                        $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                    }
                    else 
                        $intervalSeo = '';
                    
                    $seo['pTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . $year . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . $year . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " " . $intervalSeo . " " . $year . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " " . $intervalSeo . " " . $year . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы" . " " . $intervalSeo . " " . $year . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " .  $month ?? $period_v ?? '' . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $resortSeo;
                $seo['bTitle'] = "Туры " . $resortSeo . " ($country) из Москвы в " . $year . " году по низкой цене";
                $seo['metaKey'] = "Туры " . $resortSeo . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур " . $resortSeo . " " . $year . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
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
                    $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($period->title, "П"));
                    $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                }
                else
                    $intervalSeo = '';

                if ($duration = array_get($params, 'duration', null)) {
                    $seo['pTitle'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . $year . "";
                    $seo['bTitle'] = "Туры " . " " . $intervalSeo . " " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить туры " . " " . $intervalSeo . " " . $year . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . " " . $intervalSeo . " " . $year . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . $year . " года из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . $countrySeo . " " . $intervalSeo . " " . $year . "";
                    $seo['bTitle'] = "$tour_type " . $countrySeo . " " . $intervalSeo . " " . $year . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . $year . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . $countrySeo . " с вылетом из Москвы" . " " . $intervalSeo . " " . $year . " года от турагентства STARTOUR.";
                    $seo['subText'] = "$tour_type " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . $year . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проводите " . $month ?? $period_v ?? '' . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . $countrySeo . " " . $intervalSeo . " " . $year . "";
                    $seo['bTitle'] = "$status " . $countrySeo . " " . $intervalSeo . " " . $year . " из Москвы";
                    $seo['metaKey'] = "купить $status " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . $year . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . $countrySeo . " с вылетом из Москвы" . " " . $intervalSeo . " " . $year . " года от турагентства STARTOUR.";
                    $seo['subText'] = "$status " . $countrySeo . " из Москвы" . " " . $intervalSeo . " " . $year . " дешево от компании STARTOUR. Профессиональный подбор туров. Проводите " . $month ?? $period_v ?? '' . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . $year . "";
                $seo['bTitle'] = "Туры " . $countrySeo . " " . $intervalSeo . " " . $year . " из Москвы";
                $seo['metaKey'] = "купить тур " . $countrySeo . " " . $intervalSeo . " " . $year . " из Москвы, цена";
                $seo['metaDesc'] = "Дешевые туры " . $countrySeo . " " . $intervalSeo . " " . $year . " с вылетом из Москвы от турагентства STARTOUR.";
                $seo['subText'] = "Туры из Москвы " . $countrySeo . " " . $intervalSeo . " " . $year . " года дешево от компании STARTOUR. Профессиональный подбор туров.";
                return $seo;
            }

            /**
             * Если нет и месяца, тогда проверка построения SEO идет по продолжительности тура.
             * Внутри проверка на тип тура, статус и праздники.
             */
            if ($duration = array_get($params, 'duration', null)) {

                if ($tour_type = array_get($params, 'tour_type', null)) {
                    $seo['pTitle'] = "$tour_type " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "$tour_type " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . $year . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . $year . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "$tour_type на " . $year . " год " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите $duration " . durationCase($duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($holiday = array_get($params, 'holiday', null)) {
                    $seo['pTitle'] = "Туры на " . $holiday . " " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры на " . $holiday . " " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить туры на " . $holiday . " " . $year . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые туры на " . $holiday . " " . $year . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "Туры на " . $holiday . " " . $year . " год " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проведите $duration праздничных " . durationCase($duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "$status " . $year . " " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы";
                    $seo['metaKey'] = "купить $status " . $year . " " . $countrySeo . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . ", цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . $year . " " . $countrySeo . " с вылетом из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " от турагентства STARTOUR.";
                    $seo['subText'] = "$status на " . $year . " год " . $countrySeo . " на " . durationNum($duration) . " " . durationCase($duration) . "  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите$duration " . durationCase($duration) . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
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
                        $seo['pTitle'] = "$status на " . $tag->alias . " " . $year . " " . $countrySeo . "";
                        $seo['bTitle'] = "$status на " . $tag->alias . " " . $year . " " . $countrySeo . " из Москвы";
                        $seo['metaKey'] = "купить $status на " . $tag->alias . " " . $year . "  " . $countrySeo . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые $status на " . $tag->alias . " " . $year . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                        $seo['subText'] = "$status на " . $tag->alias . " " . $year . " " . $countrySeo . " из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите " . $tag->alias . " на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    $seo['pTitle'] = "Туры на " . $tag->alias . " " . $year . " " . $countrySeo . "";
                    $seo['bTitle'] = "Туры на " . $tag->alias . " " . $countrySeo . " " . $year . " из Москвы";
                    $seo['metaKey'] = "купить туры на " . $tag->alias . " " . $countrySeo . " " . $year . " из Москвы, цена";
                    $seo['metaDesc'] = "Цены на туры " . $countrySeo . " на " . $tag->alias . " " . $year . " с вылетом из Москвы от турагентства STARTOUR.";
                    $seo['subText'] = "Путёвки на " . $tag->alias . " " . $year . " из Москвы " . $countrySeo . " дешево от компании STARTOUR. Проведите незабываемых отдых на " . $tag->alias . " " . $countrySeo . ".";
                    return $seo;

                    /* Статус */
                } elseif ($tag->tag->title == "status") {

                    $seo['pTitle'] = "" . $tag->alias . " " . $year . " " . $countrySeo . "";
                    $seo['bTitle'] = "" . $tag->alias . " " . $year . " " . $countrySeo . " из Москвы";
                    $seo['metaKey'] = "" . $tag->alias . " " . $year . " " . $countrySeo . " из Москвы";
                    $seo['metaDesc'] = "Купить " . $tag->alias . " " . $countrySeo . " с вылетом из Москвы по низкой цене в турагентстве STARTOUR. Профессиональный подбор туров.";
                    $seo['subText'] = "Получите персональное предложение от наших менеджеров. Мы подберем для Вас лучшие " . $tag->alias . " " . $countrySeo . ".";
                    return $seo;

                    /* Тип тура */
                } elseif ($tag->tag->title == "tour_type") {

                    if ($holiday = array_get($params, 'holiday', null)) {

                        $seo['pTitle'] = "" . $tag->alias . " на " . $holiday . " " . $year . " " . $countrySeo . "";
                        $seo['bTitle'] = "" . $tag->alias . " на " . $holiday . " " . $year . " " . $countrySeo . " из Москвы";
                        $seo['metaKey'] = "купить " . $tag->alias . " на " . $holiday . " " . $year . "  " . $countrySeo . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые " . $tag->alias . " на " . $holiday . " " . $year . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "" . $tag->alias . " на " . $holiday . " " . $year . " " . $countrySeo . " из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Встречайте праздники на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status $tag->alias " . $year . " " . $countrySeo . "";
                        $seo['bTitle'] = "$status $tag->alias " . $year . " " . $countrySeo . " из Москвы";
                        $seo['metaKey'] = "купить $status $tag->alias " . $year . " " . $countrySeo . " из Москвы, цена, $country";
                        $seo['metaDesc'] = "Дешевые $status $tag->alias " . $year . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$status $tag->alias " . $year . " " . $countrySeo . " из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Проводите отдых на лучших курортах " . BladeHelper::case($country, "Р") . ".";
                        return $seo;
                    }

                    $seo['pTitle'] = "" . $tag->alias . " " . $countrySeo . "";
                    $seo['bTitle'] = "" . $tag->alias . " " . $year . " " . $countrySeo . " из Москвы";
                    $seo['metaKey'] = "купить " . $tag->alias . " " . $countrySeo . " из Москвы, цена";
                    $seo['metaDesc'] = "Цены на " . $tag->alias . " " . $countrySeo . " с вылетом из Москвы от турагентства STARTOUR.";
                    $seo['subText'] = "" . $tag->alias . " " . $year . " из Москвы " . $countrySeo . " дешево от компании STARTOUR.";
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
                    
                    $seo['pTitle'] = "$tour_type " . $year . " " . $resortSeo . "";
                    $seo['bTitle'] = "$tour_type " . $year . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $tour_type " . $year . "  " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $tour_type " . $year . " " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$tour_type " . $year . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
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
                    $seo['pTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . $year . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " на " . $holiday . " " . $year . " из Москвы";
                    $seo['metaKey'] = "купить туры " . $resortSeo . " на " . $holiday . " " . $year . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " на " . $holiday . " " . $year . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы на " . $holiday . " " . $year . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if ($status = array_get($params, 'status', null)) {
                    $seo['pTitle'] = "$status " . $year . " " . $resortSeo . "";
                    $seo['bTitle'] = "$status " . $year . " " . $resortSeo . " из Москвы";
                    $seo['metaKey'] = "купить $status " . $year . "  " . $resortSeo . " из Москвы, цена, $country";
                    $seo['metaDesc'] = "Дешевые $status " . $year . " " . $resortSeo . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";
                    $seo['subText'] = "$status " . $year . " " . $resortSeo . " ($country) из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                    $month = mb_strtolower(array_get($params, 'month', null));
                    $period = array_get($params, 'period', null);

                    if ($month)
                        $intervalSeo = "в " . BladeHelper::case($month, "П");
                    elseif ($period) {
                        $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($period->title, "П"));
                        $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                    }
                    else
                        $intervalSeo = '';

                    $seo['pTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . $year . "";
                    $seo['bTitle'] = "Туры " . $resortSeo . " " . $intervalSeo . " " . $year . " из Москвы";

                    $seo['metaKey'] = "купить туры " . $resortSeo . " " . $intervalSeo . " " . $year . " из Москвы, цена, $country";

                    $seo['metaDesc'] = "Дешевые туры " . $resortSeo . " " . $intervalSeo . " " . $year . " с вылетом из Москвы от турагентства STARTOUR. Отдых " . $countrySeo . ".";

                    $seo['subText'] = "Туры " . $resortSeo . " ($country) из Москвы" . " " . $intervalSeo . " " . $year . " года дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . ", отдыхая на лучших курортах " . BladeHelper::case($resort->title, "Р") . ".";
                    return $seo;
                }

                $seo['pTitle'] = "Туры в " . $resort->title;
                $seo['bTitle'] = "Туры " . $resortSeo . " ($country) из Москвы в " . $year . " году по низкой цене";
                $seo['metaKey'] = "Туры " . $resortSeo . ", ($country), вылет из Москвы, от всех туроператоров, цена, купить";
                $seo['metaDesc'] = "Купить тур в " . $resort->title . " " . $year . " от наиболее известных туроператоров. Удобный поиск туров в " . $resort->title . " из Москвы.";
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
                        $seo['pTitle'] = "$status на " . $tag->alias . " " . $year . "";
                        $seo['bTitle'] = "$status на " . $tag->alias . " " . $year . " из Москвы";
                        $seo['metaKey'] = "купить $status на " . $tag->alias . " " . $year . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $status на " . $tag->alias . " " . $year . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$status  из Москвы на " . $tag->alias . " " . $year . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "Туры на " . $tag->alias . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration);
                        $seo['bTitle'] = "Праздничные туры на " . $tag->alias . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, туры на " . $tag->alias . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые туры на " . $tag->alias . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "Туры из Москвы на " . $tag->alias . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники длинной $duration " . durationCase($duration) . " на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = "Туры на " . $tag->alias . " " . $year . "";
                    $seo['bTitle'] = "Туры на " . $tag->alias . " " . $year . " из Москвы";
                    $seo['metaKey'] = "Туры на " . $tag->alias . " " . $year . " из Москвы, куда поехать на " . $tag->alias . ", отдохнуть, купить тур";
                    $seo['metaDesc'] = "Купить тур на " . $tag->alias . " в турагенстве STARTOUR (Москва). Профессиональный подбор туров на " . $tag->alias . " " . $year . " года по доступным ценам.";
                    $seo['subText'] = "Большой выбор туров на " . $tag->alias . " " . $year . " года. Удобный поиск и профессиональная команда. Всё это позволит Вам провести приятный и незабываемый отдых на " . $tag->alias . ".";
                    return $seo;

                    /* Статус */
                } elseif ($tag->tag->title == "status") {

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "$tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                        $seo['bTitle'] = "$tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, $tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "$tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                        $seo['subText'] = "$tag->alias " . $year . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите отдых длинной $duration " . durationCase($duration) . " на лучших курортах по выгодным ценам.";
                        return $seo;
                    }

                    if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                        $month = mb_strtolower(array_get($params, 'month', null));
                        $period = array_get($params, 'period', null);

                        if ($month)
                            $intervalSeo = "в " . BladeHelper::case($month, "П");
                        elseif ($period) {
                            $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($period->title, "П"));
                            $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                        }
                        else
                            $intervalSeo = '';

                        $seo['pTitle'] = "$tag->alias " . " " . $intervalSeo . " " . $year . "";
                        $seo['bTitle'] = "$tag->alias " . " " . $intervalSeo . " " . $year . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias " . " " . $intervalSeo . " " . $year . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . $year . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias  из Москвы " . " " . $intervalSeo . " " . $year . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . ", отдыхая на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = $tag->alias;
                    $seo['bTitle'] = "" . $tag->alias . " из Москвы в " . $year . " году";
                    $seo['metaKey'] = "$tag->alias " . $year . "  из Москвы, купить, от всех туроператоров";
                    $seo['metaDesc'] = "Купить $tag->alias " . $year . " из Москвы в турагентстве STARTOUR. Широкий выбор туроператоров и низкие цены.";
                    $seo['subText'] = "Заказать $tag->alias с вылетом из Москвы просто - достаточно обратиться в наше турагентство. Наша профессиональная команда подберет для Вас лучший тур по приемлемой цене и Вашим потребностям.";
                    return $seo;

                    /* Тип тура */
                } elseif ($tag->tag->title == "tour_type") {

                    if ($duration = array_get($params, 'duration', null)) {

                        $seo['pTitle'] = "$tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                        $seo['bTitle'] = "$tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                        $seo['metaKey'] = "купить тур, $tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                        $seo['metaDesc'] = "$tag->alias " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                        $seo['subText'] = "$tag->alias " . $year . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите отдых длинной $duration " . durationCase($duration) . " на лучших курортах по выгодным ценам.";
                        return $seo;
                    }

                    if (array_get($params, 'month', null) || array_get($params, 'period', null)) {

                        $month = mb_strtolower(array_get($params, 'month', null));
                        $period = array_get($params, 'period', null);

                        if ($month)
                            $intervalSeo = "в " . BladeHelper::case($month, "П");
                        elseif ($period) {
                            $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($period->title, "П"));
                            $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                        }
                        else
                            $intervalSeo = '';
                        
                        $seo['pTitle'] = "$tag->alias " . " " . $intervalSeo . " " . $year . "";
                        $seo['bTitle'] = "$tag->alias " . " " . $intervalSeo . " " . $year . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias " . " " . $intervalSeo . " " . $year . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на " . $tag->alias . " " . $year . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias из Москвы " . " " . $intervalSeo . " " . $year . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . ", отдыхая на лучших курортах.";
                        return $seo;
                    }

                    if ($status = array_get($params, 'status', null)) {
                        $seo['pTitle'] = "$status $tag->alias";
                        $seo['bTitle'] = "$status $tag->alias " . $year . " из Москвы";
                        $seo['metaKey'] = "купить $status $tag->alias " . $year . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $status $tag->alias  с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$status $tag->alias  из Москвы дешево от компании STARTOUR. Профессиональный подбор туров. Отдыхайте на лучших курортах.";
                        return $seo;
                    }

                    if ($holiday = array_get($params, 'holiday', null)) {
                        $seo['pTitle'] = "$tag->alias на $holiday " . $year . "";
                        $seo['bTitle'] = "$tag->alias на $holiday " . $year . " из Москвы";
                        $seo['metaKey'] = "купить $tag->alias на $holiday " . $year . " из Москвы, цена";
                        $seo['metaDesc'] = "Дешевые $tag->alias на $holiday " . $year . " с вылетом из Москвы от турагентства STARTOUR.";
                        $seo['subText'] = "$tag->alias  из Москвы на $holiday " . $year . " год дешево от компании STARTOUR. Профессиональный подбор туров. Проведите праздники, отдыхая на лучших курортах.";
                        return $seo;
                    }

                    $seo['pTitle'] = "$tag->alias " . $year . "";
                    $seo['bTitle'] = "Цены на $tag->alias " . $year . " из Москвы";
                    $seo['metaKey'] = "Цены на $tag->alias " . $year . " из Москвы, купить путёвку";
                    $seo['metaDesc'] = "Купить путёвку на $tag->alias по доступной цене из Москвы в " . $year . " году. Гарантия лучшего выбор для Вашего отдыха.";
                    $seo['subText'] = "Выгодно купить путёвку на $tag->alias " . $year . " с вылетом из Москвы от всех туроператоров. Профессиональные менеджеру STARTOUR подберут для Вас оптимальное предложение по доступным ценам.";
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
                    $intervalSeo = $period->title_cases['p'] ?? ("в " . BladeHelper::case($period->title, "П"));
                    $period_v = $period->title_cases['v'] ?? BladeHelper::case($period, "В");
                }
                else
                    $intervalSeo = '';
                
                if ($duration = array_get($params, 'duration', null)) {

                    $seo['pTitle'] = "Туры " . $intervalSeo . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . "";
                    $seo['bTitle'] = "Туры " . $intervalSeo . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы";
                    $seo['metaKey'] = "купить тур, Туры " . $intervalSeo . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " из Москвы, цена";
                    $seo['metaDesc'] = "Туры " . $intervalSeo . " " . $year . " на " . durationNum($duration) . " " . durationCase($duration) . " с вылетом из Москвы от турагентства STARTOUR. Выгодные цены на путевки.";
                    $seo['subText'] = "Туры " . $intervalSeo . " " . $year . " из Москвы на " . durationNum($duration) . " " . durationCase($duration) . " дешево от компании STARTOUR. Профессиональный подбор туров. Проведите " . $month ?? $period_v ?? '' . " на лучших курортах по выгодным ценам.";
                    return $seo;
                }

                $seo['pTitle'] = "Туры " . $intervalSeo . " " . $year . "";
                $seo['bTitle'] = "Туры из Москвы " . $intervalSeo . " " . $year . "";
                $seo['metaKey'] = "Туры " . $intervalSeo . " " . $year . ", Москва, вылет, купить, цены";
                $seo['metaDesc'] = "Купить туры с вылетом из Москвы на " . $month ?? $period_v ?? '' . $year . " год в турагенстве STARTOUR. Цены на туры " . $intervalSeo . " " . $year . ".";
                $seo['subText'] = "Недорогие туры " . $intervalSeo . " " . $year . " года позволят Вам провести незабываемый отдых в разных городах и странах. Специалисты нашего турагентства помогут Вам с выбором путёвки.";
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
        $tag = null;

        if ($data['tourType']) {
            $tag = ToursTagsValues::with('tag')->find($data['tourType']);
        }

        $resort = isset($data['place']) ? Points::make(['title' => $data['place']]) : null;

        if ($point = $this->extractTourPointFromFilters($data)) {
            $resort = Points::where('title', $point)->first();
        }

        if ($way = $this->extractTourWayFromFilters($data)) {
            $resort = Ways::where('title', $way)->first();
        }

        // Set seo elements
        $seo = $this->getSeo([
            'resort' => is_object($resort) ? $resort : null,
            'tag' => is_object($tag) ? $tag : null,
            'tour_type' => $tour_type ?? '',
            'tourDate' => $data['tourDate'] ?? '',
        ]);
        
        // Ставим параметры трансформера и трансформируем seo
        $this->transformer->setParameters($seo['temp_params']);
        foreach ($seo as $key => $value)
            $seo[$key] = $this->transformer->transform($value);
        
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
        
        $resort = isset($postParams['place']) ? Points::make(['title' => $postParams['place']]) : null;

        if ($point = $this->extractTourPointFromFilters($postParams)) {
            $resort = Points::where('title', $point)->first();
        }
        
        if ($way = $this->extractTourWayFromFilters($postParams)) {
            $resort = Ways::where('title', $way)->first();
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

                $resort = Ways::where('url', last($match))->first() ?? Points::where('url', last($match))->firstOrFail();

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
            } elseif ($slug) {
                abort(404);
            } else {
                
            }
        }


        /*  Set seo elements */

        // If isset exact seo get it
        $currentLink = preg_replace('~[\S]+.ru\/~i', "", url()->current());
        
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
        $seoOverrides = GeneratedSeo::where('url', $currentLink)->first();
        $seo = $this->applySeoOverrides($seo, $seoOverrides);
        
        // Ставим параметры трансформера и трансформируем seo
        $this->transformer->setParameters($seo['temp_params']);
        foreach ($seo as $key => $value)
            $seo[$key] = $this->transformer->transform($value);
        
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
            'tourDate' => $tourDate ?? null,
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

        // Извлекаем даты для сайдбара
        list('dateFrom' => $dateFrom, 'dateTo' => $dateTo) 
            = $this->extractDatesFromFilters(compact('tourDate', 'month', 'period'), $datetime = true);

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

            'postData' => $postParams,
            
            'transformer' => $this->transformer,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
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
        $seoOverrides = GeneratedSeo::where('url', $currentLink)->first();
        $seo = $this->applySeoOverrides($seo, $seoOverrides);

        // Ставим параметры трансформера и трансформируем seo
        $this->transformer->setParameters($seo['temp_params']);
        foreach ($seo as $key => $value)
            $seo[$key] = $this->transformer->transform($value);
      
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

            'layer' => $layer,
            
            'transformer' => $this->transformer,
        ]);
    }

    public function getMore(Request $request)
    {
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);
        
        // Проверяем, ведется ли поиск по расширенному диапазону дат.
        $filters = $request->input('params');
        $filters['tourDate'] = $filters['expandedTourDate'] ? $filters['expandedTourDate'] : $filters['tourDate'];

        // Учитываем поиск по направлению или достопримечательности в одном поле фильтра (место).
        $filters['tourWay'] = $this->extractTourWayFromFilters($filters);
        if (!$filters['tourWay'])
            $filters['tourPoint'] = $this->extractTourPointFromFilters($filters) ?? $filters['place'] ?? null;
        
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
        $filters = $request->all();
        
        // Флаг, для определения был ли использован расширенный диапазон дат.
        $expanded = null;

        // Учитываем поиск по направлению или достопримечательности в одном поле фильтра (место).
        $filters['tourWay'] = $this->extractTourWayFromFilters($filters);
        if (!$filters['tourWay'])
            $filters['tourPoint'] = $this->extractTourPointFromFilters($filters) ?? $filters['place'] ?? null;
        
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
        $tours->forDate(strtotime($dates['dateFrom']), strtotime($dates['dateTo']));

        $tours->fromResort(array_get($filters, 'resort', null));
        $tours->fromWay(array_get($filters, 'tourWay', null));
        $tours->fromPoint(array_get($filters, 'tourPoint', null));

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
     * @param array $filters
     * @param bool $datetime возвращать ли объект Date
     * @return array
     */
    protected function extractDatesFromFilters($filters, $datetime = false)
    {
        $dateFrom = $dateTo = null;

        // Месяцы
        if ($month = array_get($filters, 'month', null)) {
            $dateFrom = date('d.m.Y', strtotime("1 " . $month));
            // Если фильтр идет по текущему месяцу, то выводим его с текущего дня, а не с первого
            if (now()->getTimestamp() > strtotime("1 " . $month)) {
                $dateFrom = date(now()->format('d.m.Y'));
            }
            $dateTo = date('d.m.Y', strtotime("last day of " . $month));
            
            // Проверяем, возможно имеется ввиду месяц на следующий год
            if (now()->getTimestamp() > strtotime("last day of " . $month)) {
                $dateFrom = date('d.m.Y', strtotime("1 " . $month . " 2019"));
                $dateTo = date('d.m.Y', strtotime("last day of " . $month . " 2019"));
            }
            
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
        
        if ($datetime) {
            if ($dateFrom)
                $dateFrom = Date::createFromFormat('d.m.Y', $dateFrom);
            if ($dateTo)
                $dateTo = Date::createFromFormat('d.m.Y', $dateTo);
        }
        
        return compact('dateFrom', 'dateTo');
    }

    /**
     * Возвращает направление из заданных параметров поиска.
     * 
     * @param $filters
     * @return null
     */
    protected function extractTourWayFromFilters($filters)
    {
        $place = $filters['place'] ?? null;
        
        if (!$place)
            return null;
        
        if (DB::table('ways')->where('title', $place)->count()) {
            return $place;
        }
        
        return null;
    }

    /**
     * Возвращает достопримечательность из заданных параметров поиска.
     * 
     * @param $filters
     * @return null
     */
    protected function extractTourPointFromFilters($filters)
    {
        $place = $filters['place'] ?? null;

        if (!$place)
            return null;

        if (DB::table('points')->where('title', $place)->count()) {
            return $place;
        }

        return null;
    }

    /**
     * Возвращает результаты автокомплита для поиска по 
     * достопримечательностям и направлениям.
     * 
     * @param Request $request
     * @return mixed
     */
    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        
        $ways = DB::table('ways')->select('title as value')
            ->where('title', 'LIKE', "%{$term}%")
            ->take(5)->get();

        $points = DB::table('points')->select('title as value')
            ->where('title', 'LIKE', "%{$term}%")
            ->take(5)->get();
        
        $total = $ways->merge($points)->unique();
        
        return Response::json($total->toArray());
    }

    /**
     * Применяет переопределения seo и возвращает итоговый результат.
     * 
     * @param $seo
     * @param $overrides
     * @return mixed
     */
    protected function applySeoOverrides($seo, $overrides)
    {
        // Если переопределений нет, тогда просто возвращаем что есть
        if (!$overrides)
            return $seo;
        
        // Переопределяем, только если значение поля не пустое
        foreach ($seo as $property => $value)
            $seo[$property] = !empty($overrides[$property]) ? $overrides[$property] : $seo[$property];
        
        return $seo;
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
