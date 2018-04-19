<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SlCountries;
use App\Models\SlDepartCities;
use App\Models\Sletat;
use App\Models\SlGeoRelation;
use App\Models\SlHotels;
use App\Models\SlHotelStars;
use App\Models\SlMeals;
use App\Models\SlOperators;
use App\Models\SlResorts;
use Illuminate\Http\Request;
use sletatru\XmlGate;
use sletatru\BaseServiceSoap;

class SletatController extends Controller
{
    protected $api;

    public function __construct()
    {
        $this->api = new Sletat;
    }

    public function index()
    {
        $xml = new XmlGate([
            'login' => 'info@startour.ru',
            'password' => 'YwO49DFBfwEe6qC',
        ]);

        $departCities = $xml->GetHotelInformation(17);

        dd($departCities);

        $hotelsIds = slGeoRelation::where([
            'sub_ess' => 'hotel',
            'par_ess' => 'country',
            'par_id' => 119
        ])->pluck('id');

        $operatorsIdsByCountries = slGeoRelation::where([
            'sub_ess' => 'operator',
            'par_ess' => 'country',
            'par_id' => 119
        ])->pluck('sub_id')->toArray();

        $operatorsIdsByCities = slGeoRelation::where([
            'sub_ess' => 'operator',
            'par_ess' => 'departCity',
            'par_id' => 832
        ])->pluck('sub_id')->toArray();

        $operatorsId = array_intersect($operatorsIdsByCountries, $operatorsIdsByCities);

        return view('front.sletat.form'
            ,
            [
                'slDepartCities' => SlDepartCities::all(),
                'slCountries' => SlCountries::all(),
                'slHotels' => SlHotels::whereIn('id', $hotelsIds)->get(),
                'slHotelStars' => SlHotelStars::all(),
                'slMeals' => SlMeals::all(),
                'slOperators' => SlOperators::whereIn('id', $operatorsId)->get(),
                'slResorts' => SlResorts::all(),
            ]
        );
    }

    public function getTours(Request $request)
    {
        $data = $request->all();

        $filters = [];

        $filters['cityFromId'] = $data['cityFromId'];
        $filters['countryId'] = $data['countryId'];

//        if (isset($data['includeDescriptions']))
//            $filters['includeDescriptions'] = $data['includeDescriptions'];

        if (isset($data['resort']) && ($data['resort'] or count($data['resort']))) {

            if (is_array($data['resort'])) {

                $filters['resort'] = implode(',', $data['resort']);
            } else {

                $filters['countryId'] = $data['countryId'];
            }
        }

        $response = $this->api->GetTours($filters);

//        $response = $this->api->GetTours([
//            "cityFromId" => 832,
//            "countryId" => 35,
//            "cities" => 724,
//            "meals" => 114,
//            "stars" => 401,
//            "s_adults" => 2,
//            'requestId' => 1204004600,
//            'updateResult' => 1
//        ]);

        if (isset($data['requestId']) && $data['requestId']) {
//            dd($response);
//            return $response->GetToursResult->Data->aaData;
            return view('front.sletat.list', ['tours' => $response->GetToursResult->Data->aaData]);
        }

        return json_encode($response);
    }

    public function getStatus(Request $request)
    {

        $data = $request->all();

        if (isset($data['requestId']) && $data['requestId']) {
            $response = $this->api->GetLoadState($data['requestId']);

            $processed = 0;
            $countOperators = count($response->GetLoadStateResult->Data);

            foreach ($response->GetLoadStateResult->Data as $operator) {

                if ($operator->IsProcessed) {
                    $processed++;
                }

                if ($operator->IsError) {
//                    $countOperators--;
                }
            }

            return json_encode($processed / $countOperators);
        }

        return false;

    }
}