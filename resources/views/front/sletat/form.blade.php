@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <style>
        .preloader {
            background-image: url("/img/preloader.svg");
            background-color: rgb(66, 176, 235);
            background-repeat: repeat;
        }

        form span {
            float: right;
            color: red;
            margin-left: 10px;
        }


    </style>
@endsection

@section('title', "Слетать")
@section('description', "Слетать")
@section('keywords', "Слетать")

@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <a href="/" itemprop="url">
                            <span itemprop="title">Главная</span>
                        </a>
                    </div>

                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <a href="{{route('tour.list')}}" itemprop="url">
                            <span itemprop="title">Поиск тура</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper tours-list-page">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                        'level' => 'tury',
                        'subText' => "",
                        'tag' => "",
                        'month' => "",
                        'country' => "",
                        "tourTypes" => [],
                        "countries" => [],
                        'way' => isset($way) ? $way : '',
                        'point' => isset($point) ? $point : '',
                        'duration' => "",
                        'layer' => "tury",
                     ])
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="tour-preview-wrap @if(!isset($country) or !$country) back-tours @endif">
                        <div class="tour-preview">
                            <h1 class="stroke-h">Слетать</h1>
                            <div class="tour-preview-desc">
                                <div class="stroke-desc">
                                    Компания STARTOUR предлагает лучшие туры по России. <span>Только самые интересные и проверенные маршруты!</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить
                                заявку<span> на подбор тура</span></a>
                        </div>
                    </div>

                    <div class="tour-filter" id="sletatForm">
                        <form method="POST">
                            {{ csrf_field() }}
                            <div class="tour-filter-item filterCountry">
                                <label>Откуда</label>
                                <select name="cityFromId" id="cityFromId" class="selectFirstLine">
                                    @foreach($slDepartCities as $departCity)
                                        <option value="{{$departCity->id}}">{{$departCity->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="tour-filter-item" class="filterPoint">
                                <label>Куда</label>
                                <select name="countryId" id="countryId" class="selectFirstLine">
                                    @foreach($slCountries as $countryWay)
                                        @if($countryWay->id == 119)
                                            <option value="{{$countryWay->id}}" selected>{{$countryWay->name}}</option>
                                        @else
                                            <option value="{{$countryWay->id}}">{{$countryWay->name}}</option>
                                            @enif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="tour-filter-item date-mob filterDate">
                                <label>Интервал дат вылета <span data-toggle="tooltip"
                                                                 title="Укажите желаемые даты вылета">?</span>
                                    <div id="dateFilterToggle" class="off">включить</div>
                                </label>
                                <input name="tourDate" id="tourDate" class="date-pick dp-applied" value="" disabled>
                                <label class="icon-calendar" for="tourDate">
                                    <img src="/img/icon-date.png" alt="date-icon" title="Выберите даты выезда"/>
                                </label>
                            </div>
                            <div class="tour-filter-item" class="filterPoint">
                                <label>Курорт</label>
                                <div class="allChecked">
                                    <input name="allResorts" id="allResorts" type="checkbox" data-check="all" checked>Выбраны все курорты
                                </div>
                                <div class="scrollingBlock">
                                    @foreach($slResorts as $resort)
                                        <div>
                                            <input name="resort[]" id="resort" type="checkbox" value="{{$resort->id}}" title="{{$resort->name}}"><span>{{Str::limit($resort->name, 25)}}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tour-filter-item" class="filterPoint">
                                <label>Отели</label>
                                <div class="allChecked">
                                    <input name="allHotel" id="allHotel" type="checkbox" data-check="all" checked>Выбраны
                                    все отели
                                </div>
                                <div class="scrollingBlock">
                                    @foreach($slHotels as $hotel)
                                        <div>
                                            <input name="hotel" id="hotel" type="checkbox" value="{{$hotel->id}}"
                                                   title="{{$hotel->name}}"><span>{{Str::limit($hotel->name, 25)}}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tour-filter-item no-margin-right">
                                <label>Операторы</label>
                                <div class="allChecked">
                                    <input name="allOperatorsa" id="allOperatorsa" type="checkbox" data-check="all" checked>Выбраны
                                    все операторы
                                </div>
                                <div class="scrollingBlock">
                                    @foreach($slOperators as $operator)
                                        <div>
                                            <input name="hotel" id="hotel" type="checkbox" value="{{$operator->id}}"
                                                   title="{{$operator->name}}"><span>{{Str::limit($operator->name, 25)}}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="tour-filter-item time-mob filterDurations">
                                <label>Ночей</label>

                                <select name="durationFrom" id="durationFrom">
                                    @for($i=1; $i < 30; $i++)

                                        @if($i == 7)
                                            <option value="{{$i}}" selected>от {{$i}}</option>
                                        @else
                                            <option value="{{$i}}">от {{$i}}</option>
                                        @endif

                                    @endfor
                                </select>

                                <select name="durationTo" id="durationTo">
                                    @for($i=1; $i < 30; $i++)

                                        @if($i == 14)
                                            <option value="{{$i}}" selected>до {{$i}}</option>
                                        @else
                                            <option value="{{$i}}">до {{$i}}</option>
                                        @endif

                                    @endfor
                                </select>
                            </div>

                            <div class="tour-filter-item value">
                                <label>Стоимость</label>
                                <input name="priceFrom" type="text" placeholder="от 12000"
                                       @if(isset($postData['priceFrom'])) value="{{$postData['priceFrom']}}@endif">
                                <input name="priceTo" type="text" placeholder="до 12000000"
                                       @if(isset($postData['priceTo'])) value="{{$postData['priceTo']}}@endif">
                            </div>

                            <div class="tour-filter-item half">
                                <label>Взрослых</label>

                                <select name="adults" id="adults">
                                    @for($i=1; $i < 5; $i++)

                                        @if($i == 1)
                                            <option value="{{$i}}" selected>{{$i}}</option>
                                        @else
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endif

                                    @endfor
                                </select>
                            </div>

                            <div class="tour-filter-item half">
                                <label>Детей</label>

                                <select name="childen" id="childen">
                                    @for($i=0; $i < 4; $i++)

                                        @if($i == 0)
                                            <option value="{{$i}}" selected>{{$i}}</option>
                                        @else
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endif

                                    @endfor
                                </select>
                            </div>

                            <div class="tour-filter-item meals">
                                <label>Питание</label>
                                <div class="allChecked">
                                    <input name="allMeals" id="allMeals" type="checkbox" data-check="all" checked>Выбраны
                                    все
                                </div>
                                @foreach($slMeals as $meal)
                                    <div><input type="checkbox" name="mials[]"
                                                value="{{$meal['id']}}"><span>{{$meal['name']}}</span></div>
                                @endforeach
                            </div>

                            <div class="tour-filter-item stars">
                                <label>Категории отеля</label>
                                <div class="allChecked"><input name="allStars" id="allStars" type="checkbox" data-check="all" checked>Выбраны
                                    все
                                </div>
                                @foreach($slHotelStars as $star)
                                    <div><input type="checkbox" name="stars[]"
                                                value="{{$star['id']}}"><span>{{$star['name']}}</span></div>
                                @endforeach
                            </div>
                            <input id="filterTours" type="submit" class="btn btn-blue" value="Найти">

                        </form>
                    </div>

                    <div class="progress-bar-wrapper">
                        <div class="progress-bar" style="display: none;">
                            <img style="position: absolute;margin-left: -69px;margin-top: 3px;" src="/img/preloader.svg">
                            <span class="progress-bar-fill" style="width: 0%"></span>
                        </div>
                    </div>
                    <div class="search-completed-items"></div>

                </div>
            </div>


            <div class="clear"></div>
            <div class="seo-txt">
                <h2>Подбор туров</h2>
                <p>Бронирование туров онлайн: быстро и дешево. Подбор отличных туров от всех туроператоров на сайте
                    STARTOUR.</p>
                <div class="seo-txt-more">Распродажа горящих туров с вылетом из Москвы. Поиск цены на горящие туры всех
                    туроператоров. Каталог горящих путёвок!
                </div>
                <a href="#" class="seo-txt-btn">Больше информации</a>
            </div>
        </div>


        @include('front.modules.subscription')
        @include('front.modules.infoCompany')
        @include('front.modules.partners')
        @include('front.modules.bigFooter')
    </div>
    @include('front.tours.modal.images')
    @include('front.tours.modal.order')
    @include('front.tours.modal.types')
    @include('front.tours.modal.cities')
    @include('front.tours.modal.countries')
    @include('front.tours.modal.goldens')
@endsection

@section('js')

    @include('front.tours.modules.list-scripts')
    <script src="{{asset('/js/sletat.js')}}"></script>

    <script>

        // Send order
        $('#tourOrderModal .modal-footer a:last-child').on('click', function (e) {

            e.preventDefault();

            var data = {};
            $.each($('#tourOrderModal form').serializeArray(), function (i, field) {
                if (field.value) data[field.name] = field.value;
            });

            // Request on server
            $.ajax({
                url: "{{route('mail.order')}}",
                cache: false,
                data: data,
                type: "POST",

            }).done(function (data) {

                $('#tourOrderModal form span').text("");

                if (!data.ok && data.errors) {

                    $.each(data.errors, function (key, value) {

                        $('#' + key + ' span').addClass("red");
                        $('#' + key + ' span').text(value);
                    })
                } else {
                    $('#tourOrderModal .modal-footer').remove();
                    $('#tourOrderModal .modal-body').html("<p style='text-align: center' class=\"alert alert-success\">" + data.message + "</p>");
                    setTimeout(function () {
                        $('#tourOrderModal').modal('hide')
                    }, 3000);
                }

            }).error(function () {
                // If errors
            });
        });
    </script>


@endsection