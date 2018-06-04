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

use App\Models\ToursSletat;
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

    public function statusCheck($req, $country)
    {
        $touroperatorProccessed = $this->api->GetLoadState($req)
            ->GetLoadStateResult
            ->Data;

        foreach ($touroperatorProccessed as $tour) {
            if ($tour->IsProcessed == true) {
                $process = true;
                continue;
            } else {
                sleep(1.5);
                echo "Waiting for touroperator's response for (" . $country . "). Trying again ... \n";
                return false;
            }
        }
        echo "Full response. Getting tours in (" . $country . ")... \n";
        return $process;

    }

    public function getAll()
    {
        $filters['cityFromId'] = '832';
        $filters['pageSize'] = 1000;
        $filters['includeOilTaxesAndVisa'] = '1';
        $countries = countriesWay::all();
        foreach ($countries as $country) {
            unset($filters['updateResult']);
            unset($filters['requestId']);

            //1.Создаётся поисковый запрос методом GetTours. Сохраняется идентификатор запроса, полученный в ответе.
            $filters['countryId'] = $country['id'];
            $filters['requestId'] = $this->api->GetTours($filters)->GetToursResult->Data->requestId;
            $filters['updateResult'] = 1;

            //2.Создаётся цикл для получения статуса поискового запроса. В цикле вызывается метод GetLoadState с использованием идентификатора запроса. 
            do {
                $result = $this->statusCheck($filters['requestId'], $country['name']);
            } while (!$result);

            if ($result) {
                //3.Снова вызывается метод GetTours, но уже с использованием полученного ранее идентификатора и параметра updateResult=1.
                //Метод вернет все найденные туры в рамках поискового запроса.
                $countryTours = $this->api->GetTours($filters)->GetToursResult->Data->aaData;
                $oilTaxes = $this->api->GetTours($filters)->GetToursResult->Data->oilTaxes;
                foreach ($countryTours as $eachTour) {
                    // Price_id ???? NEED TO DEFINE A UNIQUE IDENTIFICATOR FOR COMPARING
                    $tour = ToursSletat::where('price_id', '=', $eachTour[0])->first();
                    //- - - - - - - -- - - - - - -- - - - - - -- - - - - -- - - - - - -- 
                    // Добавить новый тур

                    if ($tour === null) {
                        $newTour = new ToursSletat();
                        $newTour->price_id = $eachTour[0];
                        $newTour->cityFrom_id = $eachTour[32];
                        $newTour->way_id = $eachTour[30];
                        $newTour->leaveDate = $eachTour[12];
                        $newTour->departDate = $eachTour[13];
                        $newTour->resort_id = $eachTour[5];
                        $newTour->hotel_id = $eachTour[3];
                        $newTour->operator_id = $oilTaxes[0][0];
                        $newTour->hash_operator_id = $eachTour[1];
                        $newTour->adults_count = $eachTour[16];
                        $newTour->children_count = $eachTour[17];
                        $newTour->meal_type = $eachTour[10];
                        $newTour->hotel_category = $eachTour[8];
                        $newTour->hotel_desc = $eachTour[38];
                        $newTour->title = $eachTour[6];
                        $newTour->price = $eachTour[15];
                        $newTour->duration = $eachTour[14];
                        $newTour->source = 'sletat';
                        $newTour->image_url = $eachTour[29];
                        $newTour->finish_date = $eachTour[28];
                        $newTour->tour_id_cash = $eachTour[79];
                        try {
                            $newTour->save();
                            // Logging
                            echo "Добавлено: Страна - " . $eachTour[31] . ', Тур - ' . $newTour->title . "\n";
                        } catch (Exception $e) {
                            print_r($e);
                        }
                        // Обновить существующий тур
                    } else {
                        $tour->price = $eachTour[15];
                        $tour->title = $eachTour[6];
                        $tour->duration = $eachTour[14];
                        $tour->finish_date = $eachTour[28];
                        try {
                            $tour->save();
                            // Logging
                            echo "Обновлено: Страна - " . $eachTour[31] . ', Тур - ' . $tour->title . "\n";
                        } catch (Exception $e) {
                            print_r($e);
                        }
                    }
                }
            }
        }
    }

}