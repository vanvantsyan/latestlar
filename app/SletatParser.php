<?php

namespace App;


use App\Models\Sletat as SletatApi;

use App\Models\SlGeoRelation as geoRel;
use App\Models\SlCountries as countriesWay;
use App\Models\SlDepartCities as departCities;
use App\Models\SlResorts as resort;
use Mockery\Exception;


class SletatParser
{

    protected $api;

    public function __construct()
    {
        $this->api = new SletatApi;
    }

    public function parsDepartCities()
    {

        $citiesArray = $this->api->GetDepartCities();

        if (!$citiesArray) throw new Exception('Связь с апи нарушена');

        foreach ($citiesArray->GetDepartCitiesResult->Data as $unit) {

            departCities::updateOrCreate([
                'id' => $unit->Id,
                'name' => $unit->Name,
                'country_id' => $unit->CountryId,
                'description_url' => $unit->DescriptionUrl,
                'is_popular' => $unit->IsPopular,
                'parent_id' => $unit->ParentId
            ]);
        }
    }

    public function parsCountries()
    {

        $array = departCities::all();
        foreach ($array as $unit) {

            $countries = $this->api->GetCountries($unit->id);
            foreach ($countries->GetCountriesResult->Data as $item) {

                geoRel::updateOrCreate([
                    'sub_ess' => 'country',
                    'par_ess' => 'departCity',

                    'sub_id' => $item->Id,
                    'par_id' => $unit->id,
                ]);

                if (!countriesWay::where('id', '=', $item->Id)->exists()) {

                    countriesWay::updateOrCreate([

                        'id' => $item->Id,
                        'name' => $item->Name,
                        'alias' => $item->Alias,

                        'city_id' => $unit->id,

                        'flags' => $item->Flags,
                        'has_tickets' => $item->HasTickets,
                        'hotel_is_not_stop' => $item->HotelIsNotInStop,
                        'is_pro_visa' => $item->IsProVisa,
                        'is_visa' => $item->IsVisa,
                        'rank' => $item->Rank,
                        'tickets_included' => $item->TicketsIncluded
                    ]);
                }
            }
        }
    }

    public function parsResorts()
    {
        $array = countriesWay::all();
        foreach ($array as $unit) {

            $countries = $this->api->GetCities($unit->id);
            foreach ($countries->GetCitiesResult->Data as $item) {


                if (!resort::where('id', '=', $item->Id)->exists()) {

                    try {
                        resort::updateOrCreate([

                            'id' => $item->Id,
                            'name' => $item->Name,
                            'country_id' => $item->CountryId,
                            'description_url' => $item->DescriptionUrl,
                            'is_popular' => $item->IsPopular,
                            'parent_id' => $item->ParentId
                        ]);
                    } catch (Exception $e) {
                        var_dump($item);
                        dd($e);
                    }
                }
            }
        }

    }
}