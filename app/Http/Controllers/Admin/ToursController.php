<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tours;
use App\Models\Worldparts;
use App\Models\Ways;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

use Sunra\PhpSimple\HtmlDomParser;

class ToursController extends Controller
{
    public function index()
    {
        return view('admin.tours.index', ['tours' => Tours::all()]);
    }

    public function parser()
    {
        $client = new Client;
        $jar = CookieJar::fromArray([
            '__utma' => '217549706.1523632669.1514038036.1514038036.1514038036.1',
            '__utmb' => '217549706.5.10.1514038036',
            '__utmc' => '217549706',
            '__utmz' => '217549706.1514038036.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided)',
            '_ym_uid' => '1514038036220437473',
            '_ym_visorc_37339525' => 'w',
            '_ym_isad' => '2',
        ], 'magput.ru');
        $response = $client->post('https://new.magput.ru/backend/Search/SearchPrograms', [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/57.0',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control' => 'max-age=0',
                'Connection' => 'keep-alive',
                'Content-Length' => 410,
                'Content-Type' => 'application/json; charset=utf-8',
                'Host' => 'new.magput.ru',
                'Origin' => 'https://magput.ru',
                'Referer' => 'https://magput.ru/?id=1161',
                'Cookie' => [
                    '__utma' => '217549706.1523632669.1514038036.1514038036.1514038036.1',
                    '__utmb' => '217549706.5.10.1514038036',
                    '__utmc' => '217549706',
                    '__utmz' => '217549706.1514038036.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided)',
                    '_ym_uid' => '1514038036220437473',
                    '_ym_visorc_37339525' => 'w',
                    '_ym_isad' => '2',
                ],

            ],
            'cookies' => $jar,
            'json' => [
                'Count' => 0,
                'CountOnly' => false,
                'ItemsPerPage' => 10,
                'CurrentPage' => 0,
                'Type' => 8,
                'SubType' => -1,
                'OptType' => -1,
                'CityType' => -1,
                'CityName' => -1,
                'StartCityName' => null,
                'ByCheckin' => false,
                'Checkin' => null,
                'ByRange' => false,
                'Range' => 3,
                'DurationMin' => 1,
                'DurationMax' => 20,
                'PriceMin' => null,
                'PriceMax' => null,
                'GuideName' => null,
                'FilterDates' => false,
                'OnlyHits' => false,
                'OnlyNew' => false,
                'ProgramIds' => [],
                'ProgramTypes' => [0 => 50],
                0 => 50,
                'ProgramTypesAndLogic' => false
            ]
        ]);
        dd(json_decode($response->getBody()));

        $parsingPage = file_get_contents('https://magput.ru/?id=1161');
        die(iconv('windows-1251', 'UTF-8//IGNORE', $parsingPage));
        $parsingPage = HtmlDomParser::file_get_html('https://magput.ru/?id=1161');
        dd(\GuzzleHttp\json_decode($parsingPage->outertext));


    }

    public function show(Request $request, $id)
    {
        $action = camel_case($id);
        if (method_exists($this, $action)) {
            return $this->$action($request);
        }
        return abort(404);
    }
}