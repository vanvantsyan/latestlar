<?php

namespace App\Helpers;

use App\Http\Controllers\Front\ToursController;
use App\Models\Geo;
use App\Models\Points;
use App\Models\Tours;
use App\Models\ToursTagsValues;
use App\Models\Ways;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Jenssegers\Date\Date;
use Sunra\PhpSimple\HtmlDomParser;

class BladeHelper
{

    public static function readData($text, $data)
    {
        $tmp = self::xml2array($data);

        $file = public_path("/uploads/morpher.json");

        if (!file_exists($file)) {
            $current = file_get_contents($file);
            $current = json_decode($current, true);
            file_put_contents($file, $current);
        } else {
            $current = file_get_contents($file);
            $current = is_array($current) && count($current) > 0 ? json_decode($current, true) : [];
            if (!array_key_exists($text, $current)) {
                $current[$text] = $tmp;
            }
            file_put_contents($file, json_encode($current));
        }

        return true;
    }
    
    /**
     * Склоняет слова и словосочетания в нужные падежи.
     * Для работы необходим php модуль morpher.
     * 
     * @param string $text словосочетание
     * @param string $case падеж, в который склонять словосочетание
     * @return string словосочетание в правильном падеже или оригинальное словосочетание, если просклонять не удалось
     * 
     */
    public static function case($text, $case)
    {
        // Проверяем, установлен ли модуль, если нет, то возвращаем оригинальную строку
        if (!function_exists('morpher_inflect'))
            return $text;

        $processed = morpher_inflect($text, $case);
        
        // Если морферу не удается обработать строку, то он возвращает ошибку в виде строки,
        // начинающейся на '#ERROR'. В этом случае возвращаем оригинальную строку.
        if (mb_substr($processed, 0, 6) == '#ERROR')
            return $text;
        
        return $processed;
        
    }

    /**
     * Формирует пропись числа и ставит ее в нужный падеж в зависимости 
     * от переданного текста.
     * Для работы необходим php модуль morpher.
     *
     * @param int|string $num число
     * @param string $text словосочетание с числом
     * @param string $case переопределить возвращаемый падеж
     * @return mixed сформированное словосочетание
     */
    public static function numeralCase($text, $num, $case = null)
    {
        // Проверяем, установлен ли модуль, если нет, то возвращаем оригинальную строку
        if (!function_exists('morpher_spell'))
            return $text;
 
        if ($case)
            $processed = morpher_spell($num, $text, $case);
        else
            $processed = morpher_spell($num, $text);
        
        // Если морферу не удается обработать строку, то он возвращает ошибку в виде строки,
        // начинающейся на '#ERROR'. В этом случае возвращаем оригинальную строку.
        if (mb_substr($processed, 0, 6) == '#ERROR')
            return $text;
        
        // Отчищаем результирующие данные от цифр
        $processed = preg_replace('/\d/', '', $processed);
        // Заглавные буквы так же убираем
        $processed = mb_strtolower($processed);
        
        return $processed;

    }

    public static function countTours($link, $debug = 0)
    {
        $linkId = base64_encode($link);

        if (Cache::has('countTours.' . $linkId)) {

            return Cache::get('countTours.' . $linkId);

        } else {

            $monthsRus = config('main.month');
            $months = array_flip($monthsRus);
            $month = $resort = $tag = $duration = $tourType = null;

            $params = array_diff(explode('/', $link), array(''));
            $firstParam = array_shift($params);

            // Если это страна
            $country = Geo::where('slug', $firstParam)->first();

            if (count($params)) {
                if ($debug)
                    dd('test');

                if (count($params) > 1) {

                    foreach ($params as $param) {

                        if (preg_match('/tury-(.*)/', $param, $match)) {

                            $resort = Ways::where('url', last($match))->first() ?? Points::where('url', last($match))->first();

                        } elseif (ToursTagsValues::with('tag')->where('value', $param)->exists()) {

                            // Set var tag type
                            $tag = ToursTagsValues::with('tag')->where('value', $param)->first();
                            $tagName = $tag->tag->title;
                            $$tagName = $tag->alias;

                        } elseif (preg_match('/^na-(.*)-d/', $param, $dayCoin)) {
                            $duration = $dayCoin[1];
                            $durationUrl = $param;

                        } elseif (in_array($param, $months)) {
                            $month = $param;
                        }
                    }

                } else {

                    $param = head($params);

                    if (preg_match('/tury-(.*)/', $param, $match)) {

                        $resort = Ways::where('url', last($match))->first() ?? Points::where('url', last($match))->first();

                    } elseif (ToursTagsValues::with('tag')->where('value', $param)->exists()) {

                        // Set var tag type
                        $tag = ToursTagsValues::with('tag')->where('value', $param)->first();
                        $tagName = $tag->tag->title;
                        $$tagName = $tag->alias;

                    } elseif (preg_match('/^na-(.*)-d/', $param, $dayCoin)) {
                        $duration = $dayCoin[1];
                        $durationUrl = $param;

                    } elseif (in_array($param, $months)) {
                        $month = $param;
                    }

                }

            }

            $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates']);

            $toursController = new ToursController();
            $tours = $toursController->applyFilters($tours, [
                'tourDate' => $tourDate ?? '',
                'country' => is_object($country) ? $country->slug : null,
                'resort' => is_object($resort) ? $resort : null,
                'tourType' => is_object($tag) ? $tag->id : $tourType,
                'duration' => $duration,
                'month' => $month ?? ''
            ]);

            $countTours = $tours->count(DB::raw('DISTINCT tours.id'));

            $time = Carbon::now()->addDay(1);
            Cache::put('countTours.' . $linkId, $countTours, $time);

            return $countTours;
        }
    }

    public static function generatedCityLink($base, $tag, $month, $duration)
    {
        return $base . (($tag) ? "/" . $tag->value : "") . ($month ? "/" . $month : "") . ($duration ? "/" . $duration : "");
    }

    public static function generatedMonthLink($level, $way, $point, $tag, $month, $duration)
    {
        return "/$level/" . ($way ? "tury-" . $way->url . "/" : "") . (($point) ? "tury-" . $point->url . "/" : "") . (($tag) ? $tag->value . "/" : "") . ($month) . ($duration ? "/" . $duration : "");
    }

    public static function generatedDurationLink($level, $month, $way, $point, $tag, $key)
    {
        return "/$level/" . ($month ? $month . "/" : "") . ($way ? "tury-" . $way->url . "/" : "") . (($point) ? "tury-" . $point->url . "/" : "") . ($tag ? $tag->value . "/" : "") . "na-$key";
    }

    public static function generatedTypeLink($level, $way, $point, $tag, $type)
    {
        return "/$level/" . ($way ? "tury-" . $way->url . "/" : "") . (($point) ? "tury-" . $point->url . "/" : "") . (($tag && in_array($tag->tag->title, ['holiday', 'status'])) ? $tag->value . "/" : "") . ($type->value);
    }

    public static function getTourCountry($ways)
    {
        if (is_array($ways) || is_object($ways)) {
            foreach ($ways as $way) {
                if (array_get($way, 'ways_par.status') == 'country') return array_get($way, 'ways_par.url');
            }
        }
        return 'russia';
    }

    public static function tourImg($img, $id)
    {
        if(File::exists(public_path((config('main.imgPath.tour') . 'full/' . substr($id, 0, 2) . '/' . $img)))) {
            return asset(config('main.imgPath.tour') . 'full/' . substr($id, 0, 2) . '/' . $img);
        }
        return asset('img/noimagefound.jpg');
    }

    public static function tourThumb($img, $id)
    {
        if(File::exists(public_path((config('main.imgPath.tour') . 'thumbs/' . substr($id, 0, 2) . '/' . $img)))) {
            return asset(config('main.imgPath.tour') . 'thumbs/' . substr($id, 0, 2) . '/' . $img);
        }
        return asset('img/noimagefound.jpg');
    }

    public static function tourLink($tour)
    {
        $firstWay = '';

        if ((is_array($tour['par_points']) || is_object($tour['par_points'])) && count($tour['par_ways'])) {
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

        if ($descBlock) {

            $data['tourDays'] = [];
            $desctables = $descBlock->find('table');

            if ($desctables) {
                foreach ($desctables as $table) {

                    foreach ($table->find('text') as $textBlock) {
                        preg_match('/1 ?.* ?день/ui', $table->innertext(), $matches);

                        if (count($matches)) {

                            $daysCount = 1;

                            foreach ($table->find('tr') as $tr) {
                                if ($tr->find('td', 1)) {

                                    $data['tourDays'][$daysCount] = preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>!is", "", $tr->find('td', 1)->innertext());
                                    $daysCount++;
                                }

                            }

                            $table->outertext = "";
                        }
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
                        $data['includedInPrice'] .= $includeInPrice->innertext;
                    }

                    $includeInPrice->outertext = "";
                    break;
                }
            }
            $data['includedInPrice'] = preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>!is", "", $data['includedInPrice']);

        }

        if ($descBlock)
            $data['rest'] = self::removeTags(['span', 'span', 'br', 'strong'], preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>!is", "", $descBlock->innertext));

        return $data;
    }

    public static function templateVars($text)
    {
        return preg_replace("!(\|year\|)!is", date('Y'), $text);
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

    public static function wordsCount($text)
    {
        return count(explode(' ', $text));
    }


    public static function xml2array($xml)
    {
        $arr = array();
        foreach ($xml->getNamespaces() + array(null) as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $key => $value) {
                // Add prefixes to prefixed attributes
                if (is_string($prefix)) {
                    $key = $prefix . '.' . $key;
                }
                $arr['@attributes'][$key] = (string)$value;
            }
        }
        foreach ($xml as $name => $element) {
            $value = $element->children() ? self::xml2array($element) : trim($element);
            if ($value) {
                if (!isset($arr[$name])) {
                    $arr[$name] = $value;
                } else {
                    foreach ((array)$value as $k => $v) {
                        if (is_numeric($k)) {
                            $arr[$name][] = $v;
                        } else {
                            $arr[$name][$k] = array_merge(
                                (array)$arr[$name][$k],
                                (array)$v
                            );
                        }
                    }
                }
            }
        }
        if ($content = trim((string)$xml)) {
            $arr[] = $content;
        }
        return $arr;
    }

    /**
     * Расширяет границы диапазона дат на задданное количество времени.
     * 
     * @param $range строка промежутка дат формата 'dd.mm.yy - dd.mm.yy'
     * @param mixed $interval расширяет диапазон на заданный интервал
     * @param int $breakpoint предел диапазоно, после которого он сбросится
     * @return string
     */
    public static function expandDatesRange($range, $interval = '14 days', $breakpoint = 12)
    {
        $dates = explode('-', $range);
        try {
            $dateFrom = Date::createFromFormat('d.m.y', trim($dates[0]));
            $dateTo = Date::createFromFormat('d.m.y', trim($dates[1]));
        }
        catch (\Exception $exception) {
            $dateFrom = $dateTo = null;
        }
        
        if ($dateFrom && $dateTo)
        {
            $dateFrom->modify("-{$interval}");
            $dateTo->modify("+{$interval}");
            
            $newRange = $dateFrom->diff($dateTo);
            // Если диапазон превышает пороговое значение, сбрасываем его.
            if ($newRange->m + ($newRange->y * 12) >= $breakpoint)
                return '';
            
            return $dateFrom->format('d.m.y') . ' - ' . $dateTo->format('d.m.y');
        }
        
        return '';
    }
}
