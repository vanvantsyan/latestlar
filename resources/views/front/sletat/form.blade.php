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
                                <select name="departCity" id="departCity" class="selectFirstLine">
                                    @foreach($slDepartCities as $departCity)
                                        <option value="{{$departCity->id}}">{{$departCity->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="tour-filter-item" class="filterPoint">
                                <label>Куда</label>
                                <select name="countryWay" id="countryWay" class="selectFirstLine">
                                    @foreach($slCountries as $countryWay)
                                        <option value="{{$countryWay->id}}">{{$countryWay->name}}</option>
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
                                <div class="allChecked"><input name="allResorts" id="allResorts" type="checkbox" checked>Выбраны все курорты</div>
                                <div class="scrollingBlock">
                                    @foreach($slResorts as $resort)
                                        <div>
                                            <input name="resort" id="resort" type="checkbox" value="{{$resort->id}}" title="{{$resort->name}}" ><span>{{Str::limit($resort->name, 25)}}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tour-filter-item" class="filterPoint">
                                <label>Отели</label>
                                <div class="allChecked"><input name="allHotel" id="allHotel" type="checkbox" checked>Выбраны все отели</div>
                                <div class="scrollingBlock">
                                    @foreach($slHotels as $hotel)
                                        <div>
                                            <input name="hotel" id="hotel" type="checkbox" value="{{$hotel->id}}" title="{{$hotel->name}}"><span>{{Str::limit($hotel->name, 25)}}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="tour-filter-item" style="display: none">
                                <label>Направление</label>
                                <input name="tourWay" id="tourWay" type="text" placeholder=""
                                       value="{{$way->title or ''}}">
                            </div>
                            <div class="tour-filter-item" style="display: none">
                                <label>Длительность</label>
                                {{--<input name="duration" id="duration" type="text" placeholder="" value="{{$duration or ''}}">--}}
                            </div>
                            <div class="tour-filter-item time-mob" class="filterDuration">
                                <label>Длительность тура (дни)</label>
                                @if(isset($postData['durationFrom']) or isset($durationFrom))
                                    @php
                                        $currentFrom = isset($postData['durationFrom']) ? $postData['durationFrom'] : $durationFrom;
                                    @endphp
                                @else
                                    @php
                                        $currentFrom = '';
                                    @endphp
                                @endif
                                <select name="durationFrom" id="durationFrom">
                                    @for($i=1; $i < 16; $i++)

                                        @if($currentFrom)
                                            <option value="{{$i}}" @if($currentFrom == $i) selected @endif>
                                                от {{$i}}</option>
                                        @else

                                            @if($i == 1)
                                                <option value="{{$i}}" selected>от {{$i}}</option>
                                            @else
                                                <option value="{{$i}}">от {{$i}}</option>
                                            @endif
                                        @endif
                                    @endfor
                                </select>
                                @if((isset($postData['durationTo']) && $postData['durationTo'] != "more") or isset($durationTo))
                                    @php
                                        $currentTo = isset($postData['durationTo']) ? $postData['durationTo'] : $durationTo;
                                    @endphp
                                @else
                                    @php
                                        $currentTo = '';
                                    @endphp
                                @endif
                                <select name="durationTo" id="durationTo">
                                    @for($i=1; $i < 15; $i++)

                                        @if($currentTo && $currentTo != "more")
                                            <option value="{{$i}}" @if($currentTo == $i) selected @endif>
                                                до {{$i}}</option>
                                        @else
                                            @if($i == 8)
                                                <option value="{{$i}}">до {{$i}}</option>
                                            @else
                                                <option value="{{$i}}">до {{$i}}</option>
                                            @endif
                                        @endif
                                    @endfor
                                    <option value="more"
                                            @if(!$currentTo || (isset($postData['durationTo']) && $postData['durationTo'] == "more")) selected @endif>
                                        неограниченно
                                    </option>
                                </select>
                            </div>

                            <div class="tour-filter-item value">
                                <label>Стоимость</label>
                                <input name="priceFrom" type="text" placeholder="от 12000"
                                       @if(isset($postData['priceFrom'])) value="{{$postData['priceFrom']}}@endif">
                                <input name="priceTo" type="text" placeholder="до 12000000"
                                       @if(isset($postData['priceTo'])) value="{{$postData['priceTo']}}@endif">
                            </div>

                            <div class="tour-filter-item category">
                                <label>Категория тура</label>
                                <select name="tourType">
                                    <option value="0">Все варианты</option>
                                    @isset($tourTypes)
                                        @forelse($tourTypes as $tourType)
                                            @if(isset($postData['tourType']))
                                                <option value="{{$tourType->id}}"
                                                        @if($tourType->id == $postData['tourType'])selected="selected"@endif>{{$tourType->alias}}</option>
                                            @else
                                                <option value="{{$tourType->id}}"
                                                        @if(is_object($tag) && $tourType->id == $tag->id)selected="selected"@endif>{{$tourType->alias}}</option>
                                            @endif
                                        @empty
                                        @endforelse
                                    @endisset
                                </select>
                            </div>
                            <input id="filterTours" type="submit" class="btn btn-blue" value="Найти">

                        </form>
                    </div>
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