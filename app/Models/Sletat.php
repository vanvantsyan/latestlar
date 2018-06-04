<?php
/**
 * External REST api for http://wiki.sletat.ru
 * Author: Admin
 * Date: 05.04.2018
 * Time: 16:20
 */

namespace App\Models;

class Sletat
{
    private $login = "info@startour.ru";
    private $password = "YwO49DFBfwEe6qC";

    protected $requestId;

    /**
     * Create curl request
     *
     * @param $url
     * @return mixed
     */
    public function curlRequest($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
        ));

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }


    /**
     * Create uri string for GET request
     *
     * @param array $params
     * @return string
     */
    public function setParams(array $params)
    {

        $uri = "";
        $i = 0;

        foreach ($params as $name => $param) {

            if ($param || $name == "all") {

                if (!$i) {
                    $uri .= "?";
                } else {
                    $uri .= "&";
                }


                $uri .= $name . '=' . $param;
                $i++;

            }

        }

        return $uri;
    }



    // — — — — — — — — — — — — — — Справочники — — — — — — — — — — — — — — — — — —



    /*
     * Cities of departure
     */
    public function GetDepartCities()
    {

        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetDepartCities');
        return json_decode($output);
    }

    /**
     * Ways (направления)
     * @param int $townFromId
     */
    public function GetCountries(int $townFromId)
    {

        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetCountries?townFromId=' . $townFromId);
        return json_decode($output);
    }

    /**
     * @param int $countryId
     * @return mixed
     */
    public function GetCities(int $countryId)
    {

        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetCities?countryId=' . $countryId);
        return json_decode($output);
    }

    /**
     * Список отелей
     *
     * @param int $countryId — Идентификатор направления.
     * @param string $towns — Идентификаторы городов, разделённые запятыми.
     * @param string $stars — Идентификаторы категорий отелей, разделённые запятыми.
     * @param string $filter — Фильтрация по названию отеля.
     * @param int|null $all — Количество отелей в выдаче. Возможные значения: “-1” – в выдачу попадают все отели; любое положительное целое число – точное количество отелей.
     */
    public function GetHotels(int $countryId, string $towns = "", string $stars = "", string $filter = "", int $all = -1)
    {

        $paramsList = compact(
            "countryId",
            "towns",
            "stars",
            "filter",
            "all"
        );

        $params = $this->setParams($paramsList);

        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetHotels' . $params);
        return json_decode($output);

    }

    /**
     * Возвращает список доступных категорий отелей в выбранных курортах.
     *
     * @param int $countryId — Идентификатор направления.
     * @param string $towns — Идентификаторы городов, разделённые запятыми.
     * @return mixed
     */
    public function GetHotelStars(int $countryId, string $towns = "")
    {

        $paramsList = compact(
            "countryId",
            "towns"
        );

        $params = $this->setParams($paramsList);

        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetHotelStars' . $params);
        return json_decode($output);
    }


    /**
     * Возвращает список типов питания.
     *
     * @return mixed
     */
    public function GetMeals()
    {

        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetMeals');
        return json_decode($output);
    }

    /**
     *  Возвращает список доступных туроператоров.
     *
     * @param int $townFromId
     * @param int $countryId
     * @return mixed
     */
    public function GetTourOperators(int $townFromId, int $countryId)
    {

        $paramsList = compact(
            "townFromId",
            "countryId"
        );

        $params = $this->setParams($paramsList);
        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetTourOperators' . $params . "&login=" . $this->login . "&password=" . $this->password);

        return json_decode($output);
    }

    /**
     * Возвращает список доступных дат вылета
     *
     * @param int $townFromId
     * @param int $countryId
     * @param string|null $resorts
     * @param string|null $sources
     * @return mixed
     */
    public function GetTourDates(int $townFromId, int $countryId, string $resorts = null, string $sources = null)
    {

        $paramsList = compact(
            "townFromId",
            "countryId",
            "resorts",
            "sources"
        );

        $params = $this->setParams($paramsList);
        $output = $this->curlRequest('http://module.sletat.ru/Main.svc/GetTourDates' . $params . "&login=" . $this->login . "&password=" . $this->password);

        return json_decode($output);
    }

    /*
     * Фингарантии операторов. Если понадобится опишу
     */
    public function GetSourseAssurances()
    {

    }



    // — — — — — — — — — — — — — — Методы загрузки туров — — — — — — — — — — — — — — — — — —

    /**
     * Список туров по заданным параметрам
     *
     * @param array $params
     * @return array
     */
    public function GetTours(array $paramsArr) {

        $params = $this->setParams($paramsArr);

        $output = $this->curlRequest('https://module.sletat.ru/Main.svc/GetTours' . $params . "&login=" . $this->login . "&password=" . $this->password . "");

        return json_decode($output);

    }

    /**
     * Статус обработки запроса
     *
     * @param $requestId
     * @return mixed
     */
    public function GetLoadState($requestId){

        $output = $this->curlRequest('https://module.sletat.ru/Main.svc/GetLoadState?requestId=' . $requestId);
        return json_decode($output);
    }

}