<?php

namespace App;

use App\Models\SlCountries as countriesWay;
use App\Models\SlDepartCities as departCities;
use App\Models\Sletat as SletatApi;
use App\Models\SlGeoRelation as geoRel;
use App\Models\SlHotels as hotels;
use App\Models\SlHotelStars as hotelStars;
use App\Models\SlMeals as meals;
use App\Models\SlOperators as operators;
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


    public function parsHotels()
    {
        $array = countriesWay::all();
        foreach ($array as $unit) {


            // Request to api, get hotels by country
            echo "__for country " . $unit->name . "\n";

            $countries = $this->api->GetHotels($unit->id);
            foreach ($countries->GetHotelsResult->Data as $item) {

                geoRel::updateOrCreate([
                    'sub_ess' => 'hotel',
                    'par_ess' => 'country',

                    'sub_id' => $item->Id,
                    'par_id' => $unit->id,
                ]);

                if (!hotels::where('id', '=', $item->Id)->exists()) {

                    $insertData = [];

                    foreach ($item as $field => $value) {
                        $insertData[snake_case($field)] = $value;
                    }

                    try {
                        hotels::updateOrCreate($insertData);
                        echo "add hotel " . $item->Name . " in country " . $unit->name . "\n";

                    } catch (Exception $e) {
                        var_dump($item);
                        dd($e);
                    }
                } else {

                    // Hotel already exist
                    echo "Exist " . $item->Name . " in country " . $unit->name . "\n";
                }
            }
        }
    }

    public function parsHotelStars()
    {
        geoRel::where([
            'sub_ess' => 'hotelStar',
            'par_ess' => 'country',
        ])->delete();

        geoRel::where([
            'sub_ess' => 'hotelStar',
            'par_ess' => 'city',
        ])->delete();


        $array = countriesWay::all();
        foreach ($array as $unit) {

            // Request to api, get by country
            echo "__for country " . $unit->name . "\n";

            $cities = resort::where('country_id', $unit->id)->get();


            foreach ($cities as $city) {

                // Request to api, get by country
                echo "__for city " . $city->name . "\n";

                $starRespons = $this->api->GetHotelStars($unit->id, $city->id);

                foreach ($starRespons->GetHotelStarsResult->Data as $item) {

                    geoRel::updateOrCreate([
                        'sub_ess' => 'hotelStar',
                        'par_ess' => 'country',

                        'sub_id' => $item->Id,
                        'par_id' => $unit->id,
                    ]);

                    geoRel::updateOrCreate([
                        'sub_ess' => 'hotelStar',
                        'par_ess' => 'city',

                        'sub_id' => $item->Id,
                        'par_id' => $city->id,
                    ]);

                    if (!hotelStars::where('id', '=', $item->Id)->exists()) {

                        $insertData = [];

                        foreach ($item as $field => $value) {
                            $insertData[snake_case($field)] = $value;
                        }

                        try {
                            hotelStars::updateOrCreate($insertData);
                            echo "add " . $item->Name . " in country " . $unit->name . "\n";

                        } catch (Exception $e) {
                            var_dump($item);
                            dd($e);
                        }
                    } else {

                        // Already exist
                        echo "Exist " . $item->Name . " in country " . $unit->name . "\n";
                    }
                }
            }
        }
    }

    public function parsMeals()
    {

        $meals = $this->api->GetMeals();

        foreach ($meals->GetMealsResult->Data as $item) {


            if (!meals::where('id', '=', $item->Id)->exists()) {

                $insertData = [];


                foreach ($item as $field => $value) {
                    $insertData[snake_case($field)] = $value;
                }

                try {
                    meals::updateOrCreate($insertData);
                    echo "add " . $item->Name . "\n";

                } catch (Exception $e) {
                    var_dump($item);
                    dd($e);
                }
            } else {

                // Already exist
                echo "Exist " . $item->Name . "\n";
            }
        }
    }

    public function parsOperators()
    {
        geoRel::where([
            'sub_ess' => 'operator',
            'par_ess' => 'country',
        ])->delete();

        geoRel::where([
            'sub_ess' => 'operator',
            'par_ess' => 'departCity',
        ])->delete();

        foreach (departCities::all() as $city) {

            foreach (countriesWay::all() as $country) {

                $response = $this->api->GetTourOperators($city->id, $country->id);


                foreach ($response->GetTourOperatorsResult->Data as $item) {

                    if ($item->Enabled) {
                        unset($item->Enabled);

                        geoRel::updateOrCreate([
                            'sub_ess' => 'operator',
                            'par_ess' => 'country',

                            'sub_id' => $item->Id,
                            'par_id' => $country->id,
                        ]);

                        geoRel::updateOrCreate([
                            'sub_ess' => 'operator',
                            'par_ess' => 'departCity',

                            'sub_id' => $item->Id,
                            'par_id' => $city->id,
                        ]);


                        if (!operators::where('id', '=', $item->Id)->exists()) {

                            $insertData = [];


                            foreach ($item as $field => $value) {
                                $insertData[snake_case($field)] = $value;
                            }

                            try {
                                operators::updateOrCreate($insertData);
                                echo "add " . $item->Name . "\n";

                            } catch (Exception $e) {
                                var_dump($item);
                                dd($e);
                            }
                        } else {

                            // Already exist
                            echo "Update " . $item->Name . "\n";
                        }
                    }
                }
            }


        }
    }
}