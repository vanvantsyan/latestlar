@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/tours.css')}}">
    <style>
        @if($country && $country->banner)
        .tour-preview-wrap {
            background: url("/uploads/countries/banners/{{$country->banner}}") 50% 50% no-repeat !important;
        }
        @endif
    </style>
@endsection

@section('title', Gliss::templateVars($seo['bTitle']))
@section('description', Gliss::templateVars($seo['metaDesc']))
@section('keywords', Gliss::templateVars($seo['metaKey']))

@section('breadcrumbs')
    <div class="breadcrumbs">
        @include('front.tours.modules.breadcrumbs', ['pTitle' => Gliss::templateVars($seo['pTitle'])])
    </div>
@endsection

@section('content')
    <div class="wrapper tours-list-page">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                        'level' => (isset($country)) ? $country->slug : 'tury',

                        'cities' => $cities,
                        'citiesGolden' => $citiesGolden,
                        'tourTypes' => $tourTypes,
                        'countries' => $countries,
                        'subText' => isset ($seo['subText']) ? Gliss::templateVars($seo['subText']) : '',
                        'tag' => $tag,
                        'way' => isset($way) ? $way : '',
                        'point' => isset($point) ? $point : '',
                        'duration' => $duration,
                        'layer' => $layer,
                     ])
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="tour-preview-wrap @if(!$country) back-tours @endif">
                        <div class="tour-preview">
                            <h1 class="stroke-h">{!! Gliss::templateVars($seo['pTitle']) !!}</h1>
                            <div class="tour-preview-desc">
                                <div class="stroke-desc">
                                    @if(isset($seo['topText']) && $seo['topText'])
                                        {!! Gliss::templateVars($seo['topText']) !!}
                                    @else
                                        Компания STARTOUR предлагает лучшие туры по России. <span>Только самые интересные и проверенные маршруты!</span>
                                    @endif
                                </div>
                            </div>
                            <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить
                                заявку<span> на подбор тура</span></a>
                        </div>
                    </div>
                    @include('front.tours.modules.filters', [
                        'tourTypes' => $tourTypes,
                        'way' => isset($way) ? $way : '',
                        'point' => isset($point) ? $point : '',
                        'tag' => $tag,
                        'postData' => $postData,
                        'duration' => isset($duration) ? $duration : '',
                        'durationFrom' => $durationFrom ?? '',
                        'durationTo' => $durationTo ?? '',
                      ])

                    <div class="search-completed">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title"><span
                                            id="toursFrom">{!! Gliss::templateVars($seo['pTitle']) !!}</span> из г.
                                    Москва,
                                    найдено: <span
                                            id="countFound">{{$countTours}}</span></div>
                                <a href="#" class="btn sorting-btn">Кратко</a>
                                <div class="tours-sorting mobile-hide">
                                    Сортировать по: <a href="#"
                                                       data-sort="date-asc"><span>Дате (Сначала ближайшие)</span>
                                        <b></b></a>
                                    <div class="tours-sorting-items">
                                        <a href="#" data-sort="date-asc" style="display: none">Дате (Сначала
                                            ближайшие)</a>
                                        <a href="#" data-sort="price-asc">Стоимости тура (от меньшей к большей)</a>
                                        <a href="#" data-sort="price-desc">Стоимости тура (от большей к меньшей)</a>
                                        <a href="#" data-sort="duration-asc">Длительности (от меньшей к большей)</a>
                                        <a href="#" data-sort="duration-desc">Длительности (от большей к меньшей)</a>
                                    </div>
                                </div>
                                <div class="tours-sorting desk-hide">
                                    Сортировать по: <a href="#"><span>Длительности (от большей к меньшей)</span> <b></b></a>
                                    <div class="tours-sorting-items">
                                        <a href="#" data-sort="date-asc" style="display: none">Дате (Сначала
                                            ближайшие)</a>
                                        <a href="#" data-sort="price-asc">Стоимости тура (от меньшей к большей)</a>
                                        <a href="#" data-sort="price-desc">Стоимости тура (от большей к меньшей)</a>
                                        <a href="#" data-sort="duration-asc">Длительности (от меньшей к большей)</a>
                                        <a href="#" data-sort="duration-desc">Длительности (от большей к меньшей)</a>
                                    </div>
                                </div>
                                @php
                                    $half = ceil(count($tours) / 2);

                                    if($half) {
                                        $toursParts = array_chunk($tours, $half);
                                    } else {
                                        $toursParts = [];
                                    }
                                @endphp

                            </div>
                        </div>
                    </div>

                    <div class="search-completed-items">
                        @if(count($toursParts))
                            @foreach($toursParts[0] as $tour)
                                @include('front.tours.snippets.list-block', $tour)
                            @endforeach
                        @endif
                    </div>
                    <div class="popular-tours">
                        <div class="popular-tours-items">
                            <table>
                                <tbody>
                                <tr>
                                    <td style="background-color: #007cbc;">
                                        <div class="popular-tours-item small" id="sendPhone">
                                            <div class="popular-tours-item-title">Подберем тур по Вашим запросам!</div>
                                            <form>
                                                <div class="popular-item-phone" id="phone">
                                                    <i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>
                                                    <input name="phone" type="text" placeholder="+7 (___) ___-__-__">
                                                </div>
                                                <input class="btn btn-blue" type="submit" value="Жду звонка">
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="popular-tours-item small">
                                            <a href="/sanatorii-i-pansionatyi">
                                                <img src="/img/popular-tours-item-8.jpg" alt="">
                                                <span class="orange">Все санатории России.</span>
                                                <span>Бронируйте он-лайн <br> через STARTOUR!</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="search-completed-items">
                        @if(count($toursParts) > 1)
                            @forelse($toursParts[1] as $tour)
                                @include('front.tours.snippets.list-block', $tour)
                            @empty
                            @endforelse
                        @endif
                        @if($countTours > 15)
                            <a href="#" class="btn-more-tours">Показать еще туры</a>
                        @endif
                    </div>
                    <div class="tours-sort-other desk-hide">
                        {{--<a href="#" class="tours-sort-other-item">Туры по тематике</a>--}}
                        {{--<a href="#" class="tours-sort-other-item">Туры по городам России</a>--}}
                        <a href="/tury/tury-zolotoe-kolczo" class="tours-sort-other-item">Туры по Золотому кольцу</a>
                        <a href="/tury/ekskursii" class="tours-sort-other-item">Экскурсии</a>
                        <a href="http://startour.ru/kruizyi/" class="tours-sort-other-item">Речные круизы</a>
                        {{--<a href="#" class="tours-sort-other-item">Другие страны</a>--}}
                    </div>

                    {{--@include('front.tours.modules.articles')--}}
                    @include('front.tours.modules.popularTypes')

                </div>
            </div>
            <div class="clear"></div>
            <div class="seo-txt">
                @isset($seo['bottomText'])
                    {!! Gliss::templateVars($seo['bottomText']) !!}
                @else
                    <h2>Подбор туров</h2>
                    <p>Бронирование туров онлайн: быстро и дешево. Подбор отличных туров от всех туроператоров на сайте
                        STARTOUR.</p>
                    <div class="seo-txt-more">Распродажа горящих туров с вылетом из Москвы. Поиск цены на горящие туры
                        всех
                        туроператоров. Каталог горящих путёвок!
                    </div>
                    <a href="#" class="seo-txt-btn">Больше информации</a>
                @endif
            </div>
        </div>
        @include('front.modules.subscription')
        @include('front.modules.infoCompany')
        @include('front.modules.partners')
        @include('front.modules.bigFooter')
    </div>
    @include('front.tours.modal.images')
    @php
    unset($tour);
    @endphp
    @include('front.tours.modal.order')
    <div id="modalContainer"></div>
@endsection

@section('js')
    @include('front.tours.modules.list-scripts')
    <script src="{{asset('/js/tours.js')}}"></script>
    <script>

        // Get more tours in tour list
        $('.btn-more-tours').on('click', function () {

            var btn = $(this);
            btn.html('<img style="padding-bottom: 8px" src="/img/preloader.svg">');

            var countTours = $('.search-completed-item').length;

            var filters = {};

            $.each($('.tour-filter form').serializeArray(), function () {
                filters[this.name] = this.value;
            });

            // Add data to params array
            filters['sort'] = $('.tours-sorting a:first').attr('data-sort');

            if (filters['tourCountry']) {
                filters['country'] = filters['tourCountry'];
            }
            else {
                filters['country'] = '{{ $country->slug or ""}}';
            }

            $.ajax({
                url: "/moreTours",
                cache: false,
                data: {offset: countTours, limit: 15, params: filters},
                type: "POST",

            }).done(function (data) {

                btn.html('Показать еще туры');

                $('.search-completed-item').last().after(data);
            }).error(function () {
                btn.html('Показать еще туры');
                $('.search-completed-item').last().after('<p class="alert">ошибка</p>');
            });

            return false
        });


        /* Tours filter apply */

        $('#filterTours').on('click', function (e) {

            var filterBtn = $(this);

            filterBtn.removeClass('btn-blue');
            filterBtn.addClass('preloader');
            filterBtn.attr('value', 'Идет подбор туров...');


            // Avoid the jump
            e.preventDefault();

            var data = $('.tour-filter form').serializeArray();
            var toursBlock = $('.search-completed-items');

            // Add data to params array
            data.push(
                {name: 'sort', value: $('.tours-sorting a:first').attr('data-sort')}
            );
            if (data[1].value) {
                data.push(
                    {name: 'country', value: data[1].value}
                );
            }
            else {
                data.push(
                    {name: 'country', value: '{{ $country->slug or ""}}'}
                );
            }


            // Request on server
            $.ajax({
                url: "/filterTours",
                cache: false,
                data: data,
                type: "POST",

            }).done(function (resp) {

                // Remove popular tours block
                $('.popular-tours').remove();

                // Remove second tours block if it exist
                if (toursBlock.length > 1) {
                    toursBlock.first().remove();
                }

                // Remove tours cards
                $('.search-completed-item').remove();

                // Insert tours cards
                toursBlock.before(resp);

                filterBtn.removeClass('preloader');
                filterBtn.addClass('btn-blue');
                filterBtn.attr('value', 'Подобрать варианты');


                /* Get inscription data */

                // Get count tours for inscription
                $.ajax({
                    url: "/getCountTours",
                    cache: false,
                    data: data,
                    type: "POST",
                }).done(function (count) {

                    $('#countFound').text(count);

                    if (0 == count) {

                        $('.tours-sorting:first').hide();
                        $('.sorting-btn').hide();
                    } else {

                        $('.tours-sorting:first').show();
                        $('.sorting-btn').show();
                    }

                });

                // Get seo tours for inscription
                $.ajax({
                    url: "{{route('tours.seo')}}",
                    cache: false,
                    data: data,
                    type: "POST",

                }).done(function (seo) {
                    $('#toursFrom').text(seo.pTitle);
                });

            }).error(function () {
                // If errors
            });
        });


        // Sort tours
        $('.tours-sorting-items a').on('click', function () {

            var data = $('.tour-filter form').serializeArray();
            var toursBlock = $('.search-completed-items');

            // Add data to params array
            data.push(
                {name: 'sort', value: $(this).attr('data-sort')}
            );
            if (data[1].value) {
                data.push(
                    {name: 'country', value: data[1].value}
                );
            }
            else {
                data.push(
                    {name: 'country', value: '{{ $country->slug or ""}}'}
                );
            }

            // Request on server
            $.ajax({
                url: "/filterTours",
                cache: false,
                data: data,
                type: "POST",

            }).done(function (data) {

                // Remove popular tours block
                $('.popular-tours').remove();

                // Remove second tours block if it exist
                if (toursBlock.length > 1) {
                    toursBlock.first().remove();
                }

                // Remove tours cards
                $('.search-completed-item').remove();

                // Insert tours cards
                toursBlock.before(data);

            }).error(function () {
                // If errors
            });

            $('.tours-sorting-items a[data-sort=' + $('.tours-sorting a').attr('data-sort') + ']').show();
            $(this).hide();

            $('.tours-sorting span').html(this.text);
            $('.tours-sorting a:first').attr('data-sort', $(this).attr('data-sort'));

        });
    </script>
@endsection