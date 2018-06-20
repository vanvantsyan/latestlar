<?php

namespace App;

use App\Helpers\TourHelper;
use App\Http\CBRAgent;
use App\Models\GeoRelation;
use App\Models\Points;
use App\Models\Tours;
use App\Models\ToursTags;
use App\Models\ToursTagsRelation;
use App\Models\ToursTagsValues;
use App\Models\Ways;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Sunra\PhpSimple\HtmlDomParser;

class ToursParser
{
    public function setDefaultTags()
    {

        // Set default tag data_viezda

        if (!ToursTags::where('title', 'data_viezda')->exists()) {
            $newTag = new ToursTags();
            $newTag->title = 'data_viezda';
            $newTag->alias = 'Дата выезда';
            $newTag->save();

            $tagDataId = $newTag->id;
        } else {
            $tag = ToursTags::where('title', 'data_viezda')->select('id')->first();
            $tagDataId = $tag->id;
        }

        // Set default tag travel_type

        if (!ToursTags::where('title', 'travel_type')->exists()) {
            $newTag = new ToursTags();
            $newTag->title = 'travel_type';
            $newTag->alias = 'Способ путешествия';
            $newTag->save();

            $tagTravelId = $newTag->id;
        } else {
            $tag = ToursTags::where('title', 'travel_type')->select('id')->first();
            $tagTravelId = $tag->id;
        }

        return [0 => $tagTravelId, 1 => $tagDataId];

    }

    public function getMany()
    {
        list($tagTravelId, $tagDataId) = $this->setDefaultTags();

        // Get all way for foreach

        $ways = Ways::where(function ($query) {
            $query->where('off', 0)->orWhereNull('off');
        })->where('id', '>', 3)->get();

        // Start parsing

        foreach ($ways as $way) {
            echo " — — — — — — Parce way - " . $way['title'] . " — — — — — — \n";
            $parsingPage = file_get_contents('https://magturyview.ru/mday.php?id=' . $way['id']);

            /* dom parsing many tours list*/
            $html = HtmlDomParser::str_get_html(iconv('windows-1251', 'UTF-8//IGNORE', $parsingPage));

            /* enumeration tours list*/
            foreach ($html->find('table') as $table) {

                /* get tour link*/
                try {
                    $a = $table->find('h3.pr_name a');
                    $href = $a[0]->href;
                } catch (Exception $e) {
                    die(var_dump($e));
                }

                /* get tour id */
                preg_match('/viewprog=(\d{1,10})/', $href, $matches);
                $id = $matches[1];


                /* — — — — — — PARS DATA — — — — — — */

                // Paps NAME
                $name = $a[0]->plaintext;

                // DURATION
                preg_match('/(\d{1,2})[ ](дня|дней)/', $name, $matches);

                if ($matches) {
                    $duration = $matches[1];
                } else {
                    $duration = 1;
                }

                // TRAVEL TYPE
                preg_match_all('/(ж\/д)|(авиа)|(автобус)/', $name, $matches);

                if (count($matches[0])) {

                    ToursTagsRelation::join('tours_tags AS tt', 'tt.id', '=', 'tag_id')
                        ->where('tour_id', $id)
                        ->where('tt.title', 'travel_type')
                        ->delete();
                }

                foreach ($matches[0] as $travel_type) {

                    if ($travel_type) {
                        $newTagRel = new ToursTagsRelation();
                        $newTagRel->tour_id = $id;
                        $newTagRel->tag_id = $tagTravelId;
                        $newTagRel->value = $travel_type;
                        $newTagRel->save();
                    }
                }

                // WAY POINTS

                $routeBlock = $table->find('.smalldef', 1);

                unset($matches);

                if ($routeBlock) preg_match('/Маршрут: (.*)/u', $routeBlock->plaintext, $matches);

                if (isset($matches[1]) && !empty($matches[1]) && (is_array($matches[1]) || is_object($matches[1])) && count($matches[1])) {

                    $route = $matches[1];

                    try {
                        $routePoints = explode('-->', $matches[1]);
                    } catch (Exception $e) {
                        echo $e . " on ";
                        var_dump($matches);
                    }

                } else {
                    preg_match_all('/((?:([А-ЯЁ][а-яё«»]+[ ]?){1,2}([А-ЯЁа-яё«».]+[ ]?)?[-|–|—|+][ ]?)+[ ]?([.А-ЯЁа-яё«»]+[ ]?)+)/u', $name, $matches);

                    if (isset($matches[0][0]) && $matches[0][0]) {

                        $route = $matches[0][0];

                        $routePoints = preg_split('/[ ]?[-|–|—|+]{1}[ ]?/u', $matches[0][0]);

                    } else {
                        $routePoints = array();
                    }

                }

                if (count($routePoints)) {

                    GeoRelation::where('sub_ess', 'tour')
                        ->where('sub_id', $id)
                        ->where('par_ess', 'point')
                        ->delete();
                }

                $pointOrder = 0;

                foreach ($routePoints as $point) {
                    $point = trim($point);

                    $existPoint = Points::where('title', $point)->select('id')->first();
                    if ($existPoint) {
                        $pointId = $existPoint->id;
                    } else {

                        $newPoint = new Points();
                        $newPoint->title = $point;
                        $newPoint->url = \Slug::make($point);
                        $newPoint->save();
                        $pointId = $newPoint->id;

                    }

                    if (!GeoRelation::where('sub_ess', 'point')
                        ->where('par_ess', 'way')
                        ->where('sub_id', $pointId)
                        ->where('par_id', $way->id)
                        ->exists()
                    ) {
                        // Add geo relation way->point
                        $geoRel = new GeoRelation();

                        $geoRel->sub_ess = 'point';
                        $geoRel->par_ess = 'way';
                        $geoRel->sub_id = $pointId;
                        $geoRel->par_id = $way->id;

                        $geoRel->save();
                    }
                    // Add geo relation point->tour
                    // Можно не удалять все точки перед парсингом а проверять перед вставкой на существование
                    $geoRel = new GeoRelation();

                    $geoRel->sub_ess = 'tour';
                    $geoRel->par_ess = 'point';
                    $geoRel->sub_id = $id;
                    $geoRel->par_id = $pointId;
                    $geoRel->order = $pointOrder;
                    $geoRel->save();

                    $pointOrder++;
                }

                // Small description
                $smalldef = $table->find('.smalldef');
                $desc = $smalldef[0]->plaintext;

                // data_viezda
                $data_viezda_html = $table->find('tr', 3);
                preg_match_all('/[\d]{1,2}.[\d]{1,2}.[\d]{2,4}/', $data_viezda_html, $matchesDate);

                // Delete data_viezda
                ToursTagsRelation::join('tours_tags AS tt', 'tt.id', '=', 'tag_id')
                    ->where('tour_id', $id)
                    ->where('tt.title', 'data_viezda')
                    ->delete();

                if (count($matchesDate[0])) {

                    foreach ($matchesDate[0] as $dateIn) {
                        $data_viezda = strtotime($dateIn);

                        if($data_viezda > time()) {
                            $newTagRel = new ToursTagsRelation();

                            $newTagRel->tour_id = $id;
                            $newTagRel->tag_id = $tagDataId;
                            $newTagRel->value = $data_viezda;

                            $newTagRel->save();
                        }
                    }

                }

                // Min price
                preg_match('/(\d{3,6}) ?(руб|usd|eur)/ui', $desc, $matchesPrice);

                if (isset($matchesPrice[1]) && $matchesPrice[1]) {

                    $cbr = new CBRAgent();

                    if ($matchesPrice[2] == 'usd') {
                        if ($cbr->load()) {
                            $minPrice = $cbr->get('USD') * $matchesPrice[1];
                        } else {
                            $minPrice = 58 * $matchesPrice[1];
                        }

                    } elseif ($matchesPrice[2] == 'eur') {
                        if ($cbr->load()) {
                            $minPrice = $cbr->get('EUR') * $matchesPrice[1];
                        } else {
                            $minPrice = 68 * $matchesPrice[1];
                        }
                    } else {
                        $minPrice = $matchesPrice[1];
                    }

                } else {
                    $minPrice = 0;
                }

                /* add geo relation tour -> country */
                if ($way->status != 'country') {
                    $countryId = 1;
                } else {
                    $country = DB::table('geo_countries')->where('magput', '=', $way->id)->first();
                    $countryId = $country->id;
                }

                if (!GeoRelation::where('sub_ess', 'tour')
                    ->where('par_ess', 'country')
                    ->where('sub_id', $id)
                    ->where('par_id', $countryId)
                    ->exists()
                ) {
                    // Add geo relation tour -> way
                    $geoRel = new GeoRelation();

                    $geoRel->sub_ess = 'tour';
                    $geoRel->par_ess = 'country';
                    $geoRel->sub_id = $id;
                    $geoRel->par_id = $countryId;

                    $geoRel->save();
                }

                /* add geo relation tour -> way */
                if (!GeoRelation::where('sub_ess', 'tour')
                    ->where('par_ess', 'way')
                    ->where('sub_id', $id)
                    ->where('par_id', $way->id)
                    ->exists()
                ) {
                    // Add geo relation tour -> way
                    $geoRel = new GeoRelation();

                    $geoRel->sub_ess = 'tour';
                    $geoRel->par_ess = 'way';
                    $geoRel->sub_id = $id;
                    $geoRel->par_id = $way->id;

                    $geoRel->save();
                }

                // If tour already exist

                if (Tours::find($id)) {

                    $existTour = Tours::find($id);
                    $existTour->price = $minPrice;
                    $existTour->title = TourHelper::cutTourName(htmlspecialchars($name));
                    $existTour->duration = $duration;
                    $existTour->save();

                    echo "Update " . $id . "\n";
                    continue;
                }

                // Get full tour page
                $parcingSinglePage = file_get_contents('https://magturyview.ru/mday.php' . $href);
                $singlePage = HtmlDomParser::str_get_html(iconv("windows-1251", "utf-8", $parcingSinglePage));


                $head = $singlePage->find('head', 0);
                $head->outertext = '';

                $body = $singlePage->find('body');

                // Cleare for text
                $h = $body[0]->find('h1');
                $h[0]->outertext = '';

                $singlePageTable = $body[0]->find('table');
                $singlePageTable[0]->outertext = '';

                // — — — COPY IMAGE — — — \\

                $imagesArr = [];

                foreach ($singlePageTable[1]->find('a') as $link) {

                    if ($link->href) {

                        $img = $link->href;
                        $img = preg_replace('/http:\/\/89.108.70.76/', 'https://magput.ru', $img);

                        preg_match('/([\da-z]+)\.(png|jpg|jpeg|gif)/ui', $img, $matches);
                        if (!isset($matches[1]) || empty($matches[1])) {
                            echo "could not get image name " . $img . "\n";
                            continue;
                        }

                        $gd = @imagecreatefromstring(file_get_contents($img));
                        if ($gd === false) {
                            echo 'Image is corrupted';
                            continue;
                        }

                        $folder = substr($id, 0, 2);
                        $imageName = $matches[1] . '.' . $matches[2];

                        if (!is_dir(base_path('public/img/tours/full/' . $folder))) {
                            mkdir(base_path('public/img/tours/full/' . $folder));
                        }
                        $path = base_path('public/img/tours/full/' . $folder . '/' . $imageName);

                        if (!file_exists(base_path('public/img/tours/full/' . $folder . '/' . $imageName))) {

                            $workingImage = Image::make($img);
                            $workingImage->flip();
                            $workingImage->save($path, 75);

                            if (!File::exists(base_path('public/img/tours/thumbs/' . $folder . '/' . $imageName))) {

                                if (!is_dir(base_path('public/img/tours/thumbs/' . $folder))) {
                                    mkdir(base_path('public/img/tours/thumbs/' . $folder));
                                }

                                $workingImage->resize(null, 235, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                                $workingImage->save(base_path('public/img/tours/thumbs/' . $folder . '/' . $imageName), 75);
                            }
                        }

                        $imagesArr[] = $imageName;
                    }
                }

                $images = json_encode($imagesArr);

                // — — — COPY IMAGE END— — — \\

                // Clear further

                $singlePageTable[1]->outertext = '';

                $singlePageHr = $body[0]->find('hr');
                $singlePageHr[0]->outertext = '';
                $singlePageHr[1]->outertext = '';

                $text = $singlePage->save();

                $blockTextParcing = HtmlDomParser::str_get_html($text);

                $bodyBlockNode = $blockTextParcing->find('body', 0);
                $text = $bodyBlockNode->innertext;

                // Min price

                if (!$minPrice) {

                    preg_match('/(\d{0,3}\s?\d{3,6}) ?(руб|usd|eur)/ui', $text, $matchesPrice);
                    if (isset($matchesPrice[1]) && $matchesPrice[1]) {

                        $cbr = new CBRAgent();

                        if ($matchesPrice[2] == 'usd') {
                            if ($cbr->load()) {
                                $minPrice = $cbr->get('USD') * $matchesPrice[1];
                            } else {
                                $minPrice = 58 * $matchesPrice[1];
                            }

                        } elseif ($matchesPrice[2] == 'eur') {
                            if ($cbr->load()) {
                                $minPrice = $cbr->get('EUR') * $matchesPrice[1];
                            } else {
                                $minPrice = 68 * $matchesPrice[1];
                            }
                        } else {
                            $minPrice = $matchesPrice[1];
                        }
                    }


                }

                // VALIDATION

                if (mb_strlen($name) > 250) {
                    $name = mb_strimwidth($name, 0, 250);
                }

                $text = preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>(.*?)<\/a>!is", "\\2", $text);
                $text = preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>!is", "", $text);
                $text = preg_replace('/style=\"[^\"]+\"/ui', "\\", $text);
                $text = preg_replace('/class=\'[^\"]+\'/ui', "\\", $text);

                // Add row tour
                $newTour = new Tours();

                $newTour->id = $id;
                $newTour->title = TourHelper::cutTourName(htmlspecialchars($name));
                $newTour->description = $desc;
                $newTour->text = $text;
                $newTour->url = preg_replace("~-{2,3}~ui", "-", TourHelper::tour2url($name, $id));
                $newTour->price = str_replace(' ', '', $minPrice);;
                $newTour->duration = $duration;
                $newTour->source = 'magput';
                $newTour->images = $images;

                $newTour->save();

                // Logging
                echo "Add " . $id . "\n";

            }
        }

        $this->createThumbs();

    }

    public function getOne()
    {
        list($tagTravelId, $tagDataId) = $this->setDefaultTags();

        $parsingPage = file_get_contents('https://magturyview.ru/1day.php');

        /* dom parsing many tours list*/
        $html = HtmlDomParser::str_get_html(iconv('windows-1251', 'UTF-8//IGNORE', $parsingPage));

        /* enumeration tours list*/
        foreach ($html->find('table') as $table) {

            /* get tour link*/
            try {
                $a = $table->find('h3.pr_name a');
                $href = $a[0]->href;
            } catch (Exception $e) {
                die(var_dump($e));
            }

            /* get tour id */
            preg_match('/viewprog=(\d{1,10})/', $href, $matches);
            $id = $matches[1];


            /* — — — — — — PARS DATA — — — — — — */

            // Paps NAME
            $name = $a[0]->plaintext;

            // DURATION
            preg_match('/(\d{1,2})[ ](дня|дней)/', $name, $matches);

            if ($matches) {
                $duration = $matches[1];
            } else {
                $duration = 1;
            }

            // TRAVEL TYPE
            preg_match_all('/(ж\/д)|(авиа)|(автобус)/', $name, $matches);

            if (count($matches[0])) {

                ToursTagsRelation::join('tours_tags AS tt', 'tt.id', '=', 'tag_id')
                    ->where('tour_id', $id)
                    ->where('tt.title', 'travel_type')
                    ->delete();
            }

            foreach ($matches[0] as $travel_type) {

                if ($travel_type) {
                    $newTagRel = new ToursTagsRelation();
                    $newTagRel->tour_id = $id;
                    $newTagRel->tag_id = $tagTravelId;
                    $newTagRel->value = $travel_type;
                    $newTagRel->save();
                }
            }

            // WAY POINTS

            $routeBlock = $table->find('.smalldef', 1);

            unset($matches);

            if ($routeBlock) preg_match('/Маршрут: (.*)/u', $routeBlock->plaintext, $matches);

            if (isset($matches[1]) && !empty($matches[1]) && (is_array($matches[1]) || is_object($matches[1])) && count($matches[1])) {

                $route = $matches[1];

                try {
                    $routePoints = explode('-->', $matches[1]);
                } catch (Exception $e) {
                    echo $e . " on ";
                    var_dump($matches);
                }

            } else {
                preg_match_all('/((?:([А-ЯЁ][а-яё«»]+[ ]?){1,2}([А-ЯЁа-яё«».]+[ ]?)?[-|–|—|+][ ]?)+[ ]?([.А-ЯЁа-яё«»]+[ ]?)+)/u', $name, $matches);

                if (isset($matches[0][0]) && $matches[0][0]) {

                    $route = $matches[0][0];

                    $routePoints = preg_split('/[ ]?[-|–|—|+]{1}[ ]?/u', $matches[0][0]);

                } else {
                    $routePoints = array();
                }

            }

            if (count($routePoints)) {

                GeoRelation::where('sub_ess', 'tour')
                    ->where('sub_id', $id)
                    ->where('par_ess', 'point')
                    ->delete();
            }

            $pointOrder = 0;

            foreach ($routePoints as $point) {
                $point = trim($point);

                $existPoint = Points::where('title', $point)->select('id')->first();
                if ($existPoint) {
                    $pointId = $existPoint->id;
                } else {

                    $newPoint = new Points();
                    $newPoint->title = $point;
                    $newPoint->url = \Slug::make($point);
                    $newPoint->save();
                    $pointId = $newPoint->id;

                }

                if (!GeoRelation::where('sub_ess', 'point')
                    ->where('par_ess', 'way')
                    ->where('sub_id', $pointId)
                    ->where('par_id', 319)
                    ->exists()
                ) {
                    // Add geo relation way->point
                    $geoRel = new GeoRelation();

                    $geoRel->sub_ess = 'point';
                    $geoRel->par_ess = 'way';
                    $geoRel->sub_id = $pointId;
                    $geoRel->par_id = 319;

                    $geoRel->save();
                }
                // Add geo relation point->tour
                // Можно не удалять все точки перед парсингом а проверять перед вставкой на существование
                $geoRel = new GeoRelation();

                $geoRel->sub_ess = 'tour';
                $geoRel->par_ess = 'point';
                $geoRel->sub_id = $id;
                $geoRel->par_id = $pointId;
                $geoRel->order = $pointOrder;
                $geoRel->save();

                $pointOrder++;
            }

            // Small description
            $smalldef = $table->find('.smalldef');
            $desc = $smalldef[0]->plaintext;

            // data_viezda
            $data_viezda_html = $table->find('tr', 3);
            preg_match_all('/[\d]{1,2}.[\d]{1,2}.[\d]{2,4}/', $data_viezda_html, $matchesDate);

            // Delete data_viezda
            ToursTagsRelation::join('tours_tags AS tt', 'tt.id', '=', 'tag_id')
                ->where('tour_id', $id)
                ->where('tt.title', 'data_viezda')
                ->whereNull('not_update')
                ->orWhere('not_update', 0)
                ->delete();

            if (count($matchesDate[0])) {

                foreach ($matchesDate[0] as $dateIn) {
                    $data_viezda = strtotime($dateIn);

                    $newTagRel = new ToursTagsRelation();

                    $newTagRel->tour_id = $id;
                    $newTagRel->tag_id = $tagDataId;
                    $newTagRel->value = $data_viezda;

                    $newTagRel->save();
                }

            }

            // Min price
            preg_match('/(\d{3,6}) ?(руб|usd|eur)/ui', $desc, $matchesPrice);

            if (isset($matchesPrice[1]) && $matchesPrice[1]) {

                $cbr = new CBRAgent();

                if ($matchesPrice[2] == 'usd') {
                    if ($cbr->load()) {
                        $minPrice = $cbr->get('USD') * $matchesPrice[1];
                    } else {
                        $minPrice = 58 * $matchesPrice[1];
                    }

                } elseif ($matchesPrice[2] == 'eur') {
                    if ($cbr->load()) {
                        $minPrice = $cbr->get('EUR') * $matchesPrice[1];
                    } else {
                        $minPrice = 68 * $matchesPrice[1];
                    }
                } else {
                    $minPrice = $matchesPrice[1];
                }

            } else {
                $minPrice = 0;
            }

            /* add geo relation tour -> country */
            $countryId = 1;


            if (!GeoRelation::where('sub_ess', 'tour')
                ->where('par_ess', 'country')
                ->where('sub_id', $id)
                ->where('par_id', $countryId)
                ->exists()
            ) {
                // Add geo relation tour -> way
                $geoRel = new GeoRelation();

                $geoRel->sub_ess = 'tour';
                $geoRel->par_ess = 'country';
                $geoRel->sub_id = $id;
                $geoRel->par_id = $countryId;

                $geoRel->save();
            }

            /* add geo relation tour -> way */
            if (!GeoRelation::where('sub_ess', 'tour')
                ->where('par_ess', 'way')
                ->where('sub_id', $id)
                ->where('par_id', 319)
                ->exists()
            ) {
                // Add geo relation tour -> way
                $geoRel = new GeoRelation();

                $geoRel->sub_ess = 'tour';
                $geoRel->par_ess = 'way';
                $geoRel->sub_id = $id;
                $geoRel->par_id = 319;

                $geoRel->save();
            }

            // Get full tour page
            $parcingSinglePage = file_get_contents('https://magturyview.ru/1day.php' . $href);
            $singlePage = HtmlDomParser::str_get_html(iconv("windows-1251", "utf-8", $parcingSinglePage));

            $head = $singlePage->find('head', 0);
            $head->outertext = '';

            $body = $singlePage->find('body');

            // Cleare for text
            $h = $body[0]->find('h1');
            $h[0]->outertext = '';

            $singlePageTable = $body[0]->find('table');
            $singlePageTable[0]->outertext = '';

            // — — — COPY IMAGE — — — \\

            $imagesArr = [];

            foreach ($singlePageTable[1]->find('a') as $link) {

                if ($link->href) {

                    $img = $link->href;
                    $img = preg_replace('/http:\/\/89.108.70.76/', 'https://magput.ru', $img);

                    preg_match('/([\da-z]+)\.(png|jpg|jpeg|gif)/ui', $img, $matches);
                    if (!isset($matches[1]) || empty($matches[1])) {
                        echo "could not get image name " . $img . "\n";
                        continue;
                    }

                    $gd = @imagecreatefromstring(file_get_contents($img));
                    if ($gd === false) {
                        echo 'Image is corrupted';
                        continue;
                    }

                    $folder = substr($id, 0, 2);
                    $imageName = $matches[1] . '.' . $matches[2];

                    if (!is_dir(base_path('public/img/tours/full/' . $folder))) {
                        mkdir(base_path('public/img/tours/full/' . $folder));
                    }
                    $path = base_path('public/img/tours/full/' . $folder . '/' . $imageName);

                    if (!file_exists(base_path('public/img/tours/full/' . $folder . '/' . $imageName))) {

                        $workingImage = Image::make($img);
                        $workingImage->flip();
                        $workingImage->save($path, 75);

                        if (!File::exists(base_path('public/img/tours/thumbs/' . $folder . '/' . $imageName))) {
                            $workingImage->resize(null, 235, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                            if (!is_dir(base_path('public/img/tours/thumbs/' . $folder))) {
                                mkdir(base_path('public/img/tours/thumbs/' . $folder));
                            }

                            $workingImage->save(base_path('public/img/tours/thumbs/' . $folder . '/' . $imageName), 75);
                        }
                    }

                    $imagesArr[] = $imageName;
                }
            }

            $images = json_encode($imagesArr);

            // — — — COPY IMAGE END— — — \\

            // If tour already exist

            if (Tours::find($id)) {

                $existTour = Tours::find($id);
                $existTour->price = $minPrice;
                $existTour->title = TourHelper::cutTourName(htmlspecialchars($name));
                $existTour->duration = $duration;
                $existTour->images = $images;
                $existTour->save();

                echo "Update " . $id . "\n";
                continue;
            }



            // Clear further

            $singlePageTable[1]->outertext = '';

            $singlePageHr = $body[0]->find('hr');
            $singlePageHr[0]->outertext = '';
            $singlePageHr[1]->outertext = '';

            $text = $singlePage->save();

            $blockTextParcing = HtmlDomParser::str_get_html($text);

            $bodyBlockNode = $blockTextParcing->find('body', 0);
            $text = $bodyBlockNode->innertext;

            // Min price

            if (!$minPrice) {

                preg_match('/(\d{0,3}\s?\d{3,6}) ?(руб|usd|eur)/ui', $text, $matchesPrice);
                if (isset($matchesPrice[1]) && $matchesPrice[1]) {

                    $cbr = new CBRAgent();

                    if ($matchesPrice[2] == 'usd') {
                        if ($cbr->load()) {
                            $minPrice = $cbr->get('USD') * $matchesPrice[1];
                        } else {
                            $minPrice = 58 * $matchesPrice[1];
                        }

                    } elseif ($matchesPrice[2] == 'eur') {
                        if ($cbr->load()) {
                            $minPrice = $cbr->get('EUR') * $matchesPrice[1];
                        } else {
                            $minPrice = 68 * $matchesPrice[1];
                        }
                    } else {
                        $minPrice = $matchesPrice[1];
                    }
                }


            }

            // VALIDATION

            if (mb_strlen($name) > 250) {
                $name = mb_strimwidth($name, 0, 250);
            }

            $text = preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>(.*?)<\/a>!is", "\\2", $text);
            $text = preg_replace('/style=\"[^\"]+\"/ui', "\\", $text);
            $text = preg_replace('/class=\'[^\"]+\'/ui', "\\", $text);

            // Add row tour
            $newTour = new Tours();

            $newTour->id = $id;
            $newTour->title = TourHelper::cutTourName(htmlspecialchars($name));
            $newTour->description = $desc;
            $newTour->text = $text;
            $newTour->url = TourHelper::tour2url($name, $id);
            $newTour->price = str_replace(' ', '', $minPrice);;
            $newTour->duration = $duration;
            $newTour->source = 'magput';
            $newTour->images = $images;

            $newTour->save();

            // Logging
            echo "Add " . $id . "\n";

        }
    }

    /**
     *  Проставляет один конкретный тип у тура
     *
     * @param int $id
     * @return bool $status
     */

    public function relateWithTypes()
    {

        $types = ToursTagsValues::where('off', 0)->where('tag_id', 4)->where('id', '!=', 39)->get();

        foreach ($types as $type) {

            // Удаляю все связи подобного типа где нет not_update
            ToursTagsRelation::where('tag_id', 4)->where('value', $type->id)->whereNull('not_update')->orWhere('not_update', 0)->delete();

            if ($type->keys) {

                echo "--- Тег " . $type->alias . " ---\n";

                /* Получаем ключи для запроса */

                $toursQuery = Tours::select('id');

                $keys = explode(',', $type->keys);

                foreach ($keys as $key) {
                    if ($key) {
                        $toursQuery->orWhere('title', 'like', '%' . $key . '%');
                        $toursQuery->orWhere('description', 'like', '%' . $key . '%');
                    }
                }

                $toursIds = $toursQuery->pluck('id');


                /* Собираем данные для вставки связей */

                $arr = [];

                foreach ($toursIds as $id) {
                    $arr[] = [
                        'tour_id' => $id,
                        'value' => $type->id,
                        'tag_id' => 4
                    ];
                }

                // Вставляем связи
                ToursTagsRelation::insert($arr);

            }
        }

    }

    /**
     *  Проставляет тип соответствующего праздника у тура
     *
     * @return bool $status
     */
    public function relateWithHolidays()
    {
        $holidayArray = [
            1 => [
                'title' => 'november',
                'oneDay' => '706',
                'mDay' => '707',
                'dateRange1' => '1541203200',
                'dateRange2' => '1541548800',
            ],
            2 => [
                'title' =>  'febr23',
                'oneDay' => '294',
                'mDay' => '295',
                'dateRange1' => '1550793600',
                'dateRange2' => '1550966400',
            ],
            3 => [
                'title' =>  'newyear',
                'oneDay' => '774',
                'mDay' => '741',
                'dateRange1' => '1546128000',
                'dateRange2' => '1546905600',
            ],
            4 => [
                'title' =>  'mart',
                'oneDay' => '219',
                'mDay' => '220',
                'dateRange1' => '1551916800',
                'dateRange2' => '1552089600',
            ],
            5 => [
                'title' =>  'maslen',
                'oneDay' => '217',
                'mDay' => '218',
                'dateRange1' => '1549929600',
                'dateRange2' => '1550534400',
            ],
            6 => [
                'title' =>  'pasha',
                'oneDay' => '542',
                'mDay' => '543',
                'dateRange1' => '1523059200',
                'dateRange2' => '1523232000',
            ],
            7 => [
                'title' =>  'may',
                'oneDay' => '180',
                'mDay' => '179',
                'dateRange1' => '1524873600',
                'dateRange2' => '1525910400',
            ],
            8 => [
                'title' =>  'june12',
                'oneDay' => '558',
                'mDay' => '251',
                'dateRange1' => '1528675200',
                'dateRange2' => '1528848000',
            ],
        ];

        foreach ($holidayArray as $tag_id => $holiday) {

            echo " — — — " . $holiday['title']  . " — — — " ."\n";

            // Удаляю все связи подобного типа где нет not_update
            ToursTagsRelation::where('tag_id', 3)->where('value', $tag_id)->where(function($query){
                $query->whereNull('not_update');
                $query->orWhere('not_update',0);
            })->delete();

            foreach(['mDay'] as $duration) {

                $base = 'https://magturyview.ru/' . $holiday['title'] . '.php?id=' . $holiday[$duration];
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_URL, $base);
                curl_setopt($curl, CURLOPT_REFERER, $base);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                $parsingPage = curl_exec($curl);
                curl_close($curl);
                $html = HtmlDomParser::str_get_html($parsingPage);


                /* Собираем данные для вставки связей */

                $arr = [];

                foreach($html->find('h3.pr_name a') as $a){
                    $href = $a->href;
                    preg_match('/viewprog=(\d{1,10})/', $href, $matches);
                    $id = $matches[1];

                    // Если получен идентификатор тура, ищем таковой в базе
                    if(Tours::find($id)) { // Организовать добавление туров, однодневные не все

                        $arr[] = [
                            'tour_id' => $id,
                            'value' => $tag_id,
                            'tag_id' => 3
                        ];

                        echo "тур " . $id . " cвязь " . $holiday['title'] ."\n";

                        // Проставляем даты праздника с атрибутом hide
                        for($i = $holiday['dateRange1'], $j = $holiday['dateRange2']; $i < $j; $i = $i + 86400){
                            if(!ToursTagsRelation::where('tour_id', $id)->where('tag_id',2)->where('value',$i)->exists()) {
                                ToursTagsRelation::insert(
                                    [
                                        'tour_id' => $id,
                                        'value' => $i,
                                        'tag_id' => 2,
                                        'not_update' => 1,
                                        'hide' => 1
                                    ]
                                );
                            }
                        }

                    }

                }

                // Вставляем связи
                ToursTagsRelation::insert($arr);
            }

        }
    }

    public function createThumbs()
    {
        $allTours = Tours::all();

        foreach ($allTours as $tour) {
            $images = json_decode($tour->images);

            foreach ($images as $image) {
                if ($image && File::exists(public_path('img/tours/full/' . substr($tour->id, 0, 2) . '/' . $image))) {

                    $img = Image::make(public_path('img/tours/full/' . substr($tour->id, 0, 2) . '/' . $image));
                    $img->resize(null, 235, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $folderPath = 'public/img/tours/thumbs/' . substr($tour->id, 0, 2);

                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true, true);
                    }
                    /* if thumb not exist — save picture */
                    if (!File::exists($folderPath . '/' . $image)) {
                        echo $folderPath . '/' . $image . "\n\r";
                        $img->save($folderPath . '/' . $image, 75);
                    }
                }

            }
        }
    }

    public function insertTagsFromModx()
    {
        // Get old data from modx relation table

        $tags = DB::table('modx_tours_tags')->where('title', '<>', 'data_viezda')->where('title', '<>', 'travel_type')->get();
        foreach ($tags as $tag) {

            $existFixValue = ToursTagsValues::where('value', $tag->value)->first();
            $tagAttribute = ToursTags::where('title', $tag->title)->first();

            // Check or insert new tag value

            if ($existFixValue) {
                $valueId = $existFixValue->id;
            } else {
                $newTaggFixValue = new ToursTagsValues;

                $newTaggFixValue->tag_id = $tagAttribute->id;
                $newTaggFixValue->value = $tag->value;
                $newTaggFixValue->alias = $tag->alias;
                $newTaggFixValue->date = $tag->date;

                $newTaggFixValue->save();

                $valueId = $newTaggFixValue->id;
            }

            //  Insert relation tag to tour

            /* check exist */
            $exist = ToursTagsRelation::join('tours_tags', 'tours_tags.id', '=', 'tour_tags_relations.tag_id')
                ->join('tours_tags_values', 'tours_tags_values.id', 'tour_tags_relations.value')
                ->where('tour_tags_relations.tour_id', $tag->tour_id)
                ->where('tours_tags.title', $tag->title)
                ->where('tours_tags_values.value', $tag->value)
                ->exists();

            /* create relation */
            if (!$exist) {
                $tagRelation = new ToursTagsRelation();

                $tagRelation->tour_id = $tag->tour_id;
                $tagRelation->tag_id = $tagAttribute->id;

                /* value id if fix value */
                $tagRelation->value = $valueId;

                $tagRelation->save();
            }

        }
    }
}
