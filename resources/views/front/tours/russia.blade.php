@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <style>
        .preloader {
            background-image: url("/img/preloader.svg");
            background-color: rgb(66, 176, 235);
            background-repeat: repeat;
        }

        .poular-category-item-img {
            overflow: hidden;
        }

        .subscription form {
            color: #0f0f0f;
        }
        form span {
            float: right;
            color: red;
            margin-left: 10px;
        }
    </style>
@endsection

@section('title', "Туры по России")
@section('description', "Туры по России")
@section('keywords', "Туры по России")

@section('breadcrumbs')
    <div class="breadcrumbs">
        @include('front.tours.modules.breadcrumbs', ['pTitle' => "Туры по России"])
    </div>
@endsection

@section('content')
    <div class="wrapper page-russia">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                         'level' => "russia" ?: 'tury',

                         'cities' => $cities,
                         'citiesGolden' => $citiesGolden,
                         'tourTypes' => $tourTypes,
                         'countries' => $countries,
                         'subText' => $seo['subText'],
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
                    <div class="tour-preview">
                        <h1>Туры по России</h1>
                        <div class="tour-preview-desc">Компания STARTOUR предлагает лучшие туры по России. Только самые
                            интересные и проверенные маршруты!
                        </div>
                        <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить
                            заявку на подбор тура</a>
                    </div>
                    @include('front.tours.modules.filters', [
                        'tourTypes' => $tourTypes,
                        'way' => isset($way) ? $way : '',
                        'point' => isset($point) ? $point : '',
                        'tag' => $tag,
                        'postData' => $postData ?? '',
                      ])

                    <div class="search-completed-items mobile-hide"></div>
                    <div class="popular-tours">
                        <h2>Самые популярные туры в {{Gliss::case(Date::now()->format('F'), "П")}} в России</h2>
                        <div class="popular-tours-items">
                            <table>
                                <tbody>
                                <tr>
                                    <td rowspan="2">
                                        <a href="/russia/tury-zolotoe-kolczo" class="popular-tours-item big">
                                            @php
                                                $images = json_decode($countriesGrid['319']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($countriesGrid['319']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$countriesGrid['319']['title']}}</div>
                                                <p>{!! $countriesGrid['319']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/russia/serebryannoe-kolco-rossii" class="popular-tours-item">
                                            @php
                                                $images = json_decode($typesGrid['39']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/tourstagsvalues/full/' . (head($images)))}}"
                                                     alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($typesGrid['39']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$typesGrid['39']['alias']}}</div>
                                                <p>{!! $typesGrid['39']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/russia/tury-velikij-ustyug" class="popular-tours-item">
                                            @php
                                                $images = json_decode($countriesGrid['419']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($countriesGrid['419']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$countriesGrid['419']['title']}}</div>
                                                <p>{!! $countriesGrid['419']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/russia/tury-kazan-i-tatarstan" class="popular-tours-item">
                                            @php
                                                $images = json_decode($countriesGrid['387']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($countriesGrid['387']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$countriesGrid['387']['title']}}</div>
                                                <p>{!! $countriesGrid['387']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/russia/tury-bajkal" class="popular-tours-item">
                                            @php
                                                $images = json_decode($countriesGrid['405']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($countriesGrid['405']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$countriesGrid['405']['title']}}</div>
                                                <p>{!! $countriesGrid['405']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/russia/svyatye-mesta" class="popular-tours-item">
                                            @php
                                                $images = json_decode($typesGrid['25']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/tourstagsvalues/full/' . (head($images)))}}"
                                                     alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($typesGrid['25']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$typesGrid['25']['alias']}}</div>
                                                <p>{!! $typesGrid['25']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/russia/tury-sankt-peterburg-i-leningradskaya-oblast"
                                           class="popular-tours-item">
                                            @php
                                                $images = json_decode($countriesGrid['323']['images']);
                                            @endphp
                                            @if(count($images))
                                                <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                            @endif
                                            <div class="price">
                                                от {{number_format($countriesGrid['323']['minPrice'],0,'.','')}} <span
                                                        class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">{{$countriesGrid['323']['title']}}</div>
                                                <p>{!! $countriesGrid['323']['description'] !!}</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #007cbc;">
                                        <div class="popular-tours-item small" id="sendPhone">
                                            <div class="popular-tours-item-title">Подберем тур по Вашим запросам!</div>
                                            <form>
                                                <div class="popular-item-phone">
                                                    <i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>
                                                    <input type="text" placeholder="+7 (095) 322-44-54">
                                                </div>
                                                <input class="btn btn-blue" type="submit" value="Жду звонка">
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="popular-tours-item small">
                                            <img src="img/popular-tours-item-8.jpg" alt="">
                                            <span class="orange">Все санатории России.</span>
                                            <span>Бронируйте он-лайн <br> через STARTOUR!</span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="burning-tours">
                        <div class="burning-tours-filter-wrap">
                            <h2 class="hot">Горящие туры по России из <a href="#">Москвы</a></h2>
                            <div class="burning-tours-filter" id="toursTab">
                                <a class="active" href="#allTours" class="active" data-toggle="tab">Все</a>
                                <a href="#oneDay" data-toggle="tab">Однодневные</a>
                                <a href="#manyDay" data-toggle="tab">Многодневные</a>
                                <a href="#activeTours" data-toggle="tab">Активный отдых</a>
                            </div>
                        </div>
                        <div class="burning-tours-items-wrap">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row tab-content">
                                    <div class="burning-tours-items tab-pane fade in active" id="allTours">
                                        @foreach($hotToursAny as $tour)
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row">
                                                    <div class="burning-tours-item">
                                                        <div class="burning-tours-item-img">
                                                            @php
                                                                $images = (array) json_decode($tour['images']);
                                                            @endphp
                                                            <img src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}"
                                                                 alt="">
                                                            @if($tour['price'] > 0)
                                                                <span>от {{number_format($tour['price'], 0 ,'.','')}}
                                                                    <span
                                                                            class="glyphicon glyphicon-rub"
                                                                            aria-hidden="true"></span> / чел.</span>
                                                            @endif
                                                        </div>
                                                        <div class="burning-tours-item-desc">
                                                            <span>
                                                                @if(count($tour['par_ways']))
                                                                    {{$tour['par_ways'][0]['ways_par']['title']}}
                                                                @else
                                                                    Россия
                                                                @endif
                                                            </span>
                                                            <b>{{$tour['title']}}</b>
                                                            <span>на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</span>
                                                            <div class="btn btn-orange" data-toggle="modal"
                                                                 data-target="#tourOrderModal">Забронировать
                                                            </div>

                                                            <a href="{{Gliss::tourLink($tour)}}"
                                                               class="burning-tours-item-more">Узнать подробнее</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="burning-tours-items tab-pane fade in" id="oneDay">
                                        @foreach($hotToursOne as $tour)
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row">
                                                    <div class="burning-tours-item">
                                                        <div class="burning-tours-item-img">
                                                            @php
                                                                $images = (array) json_decode($tour['images']);
                                                            @endphp
                                                            <img src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}"
                                                                 alt="">
                                                            @if($tour['price'] > 0)
                                                                <span>от {{number_format($tour['price'], 0 ,'.','')}}
                                                                    <span
                                                                            class="glyphicon glyphicon-rub"
                                                                            aria-hidden="true"></span> / чел.</span>
                                                            @endif
                                                        </div>
                                                        <div class="burning-tours-item-desc">
                                                            <span>
                                                                @if(count($tour['par_ways']))
                                                                    {{$tour['par_ways'][0]['ways_par']['title']}}
                                                                @else
                                                                    Россия
                                                                @endif
                                                            </span>
                                                            <b>{{$tour['title']}}</b>
                                                            <span>на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</span>
                                                            <div class="btn btn-orange" data-toggle="modal"
                                                                 data-target="#tourOrderModal">Забронировать
                                                            </div>

                                                            <a href="{{Gliss::tourLink($tour)}}"
                                                               class="burning-tours-item-more">Узнать подробнее</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="burning-tours-items tab-pane fade in" id="manyDay">
                                        @foreach($hotToursMany as $tour)
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row">
                                                    <div class="burning-tours-item">
                                                        <div class="burning-tours-item-img">
                                                            @php
                                                                $images = (array) json_decode($tour['images']);
                                                            @endphp
                                                            <img src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}"
                                                                 alt="">
                                                            @if($tour['price'] > 0)
                                                                <span>от {{number_format($tour['price'], 0 ,'.','')}}
                                                                    <span
                                                                            class="glyphicon glyphicon-rub"
                                                                            aria-hidden="true"></span> / чел.</span>
                                                            @endif
                                                        </div>
                                                        <div class="burning-tours-item-desc">
                                                            <span>
                                                                @if(count($tour['par_ways']))
                                                                    {{$tour['par_ways'][0]['ways_par']['title']}}
                                                                @else
                                                                    Россия
                                                                @endif
                                                            </span>
                                                            <b>{{$tour['title']}}</b>
                                                            <span>на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</span>
                                                            <div class="btn btn-orange" data-toggle="modal"
                                                                 data-target="#tourOrderModal">Забронировать
                                                            </div>

                                                            <a href="{{Gliss::tourLink($tour)}}"
                                                               class="burning-tours-item-more">Узнать подробнее</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="burning-tours-items tab-pane fade in" id="activeTours">
                                        @foreach($hotToursActive as $tour)
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row">
                                                    <div class="burning-tours-item">
                                                        <div class="burning-tours-item-img">
                                                            @php
                                                                $images = (array) json_decode($tour['images']);
                                                            @endphp
                                                            <img src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}"
                                                                 alt="">
                                                            @if($tour['price'] > 0)
                                                                <span>от {{number_format($tour['price'], 0 ,'.','')}}
                                                                    <span
                                                                            class="glyphicon glyphicon-rub"
                                                                            aria-hidden="true"></span> / чел.</span>
                                                            @endif
                                                        </div>
                                                        <div class="burning-tours-item-desc">
                                                            <span>
                                                                @if(count($tour['par_ways']))
                                                                    {{$tour['par_ways'][0]['ways_par']['title']}}
                                                                @else
                                                                    Россия
                                                                @endif
                                                            </span>
                                                            <b>{{$tour['title']}}</b>
                                                            <span>на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</span>
                                                            <div class="btn btn-orange" data-toggle="modal"
                                                                 data-target="#tourOrderModal">Забронировать
                                                            </div>

                                                            <a href="{{Gliss::tourLink($tour)}}"
                                                               class="burning-tours-item-more">Узнать подробнее</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a target="_blank" href="http://startour.ru/goryashhie-turyi/"
                                       class="btn-more-tours">Показать еще больше горящих туров</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('front.tours.modules.articles')
                    @include('front.tours.modules.popularTypes')
                </div>
            </div>
            <div class="clear"></div>
            <div class="seo-txt">
                <h2>О стране</h2>
                {!! Str::words($country->description, 50, '...') !!}
                <div class="seo-txt-more">
                    {!! $country->description !!}
                </div>
                <a href="#" class="seo-txt-btn">Больше информации</a>
            </div>
        </div>
        @include('front.modules.subscription')
        @include('front.modules.infoCompany')
        @include('front.modules.partners')
        @include('front.modules.bigFooter')
    </div>
    @include('front.tours.modal.order')
@endsection

@section('js')
    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{asset('/js/moment.js')}}"></script>
    <script src="{{asset('/js/daterangepicker.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('#toursTab a').click(function (e) {
            $('#toursTab a').removeClass('active');
            $(this).addClass('active');
        })
    </script>
    <script>$(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })</script>
    <script>
        $('#sendPhone input[type=submit]').on('click', function (e) {
            e.preventDefault();
            $('#sendPhone').html('<div class="popular-tours-item-title">Заявка отправлена</div><p>Благодарим за обращение</p>');
        });
    </script>
    <script>
        moment.locale('ru');

        $('#tourDate').daterangepicker({
            locale: {
                format: 'DD.MM.YYYY',
                "daysOfWeek": [
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб",
                    "Вс"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
            },
            @if($month)
            startDate: '{!! date('d.m.Y', strtotime("1 " . $month)) !!}',
            endDate: '{!! date('d.m.Y', strtotime("last day of " . $month)) !!}',
            @else
            startDate: moment().format('DD.MM.YYYY'),
            endDate: moment().add(30, 'day').format('DD.MM.YYYY'),
            @endif
            "autoApply": true,
        });
    </script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // See all photos of the tour

        $('#tourImagesModal').on('show.bs.modal', function (e) {
            var tourId = $(e.relatedTarget).attr('data-tour-id');

            var images = $(e.relatedTarget).attr('data-images');
            var slideBlock = '';

            var slideContainer = ".carousel-inner";
            var indicators = '';

            $.each($.parseJSON(images), function (key, value) {
                if (!key) active = "active"; else active = '';
                slideBlock += "<div class='item " + active + "'> <img src=\'/img/tours/full/" + tourId.substr(0, 2) + "/" + value + "'></div>";

                indicators += "<li data-target=\"#tourImagesCarousel\" data-slide-to='" + key + "' class='" + active + "'></li>";
            })

            $(slideContainer).html(slideBlock);
            $('.carousel-indicators').html(indicators);
        });

        // Get more tours in tour list

        $('.btn-more-toursNo').on('click', function () {

            var btn = $(this);
            btn.html('<img style="padding-bottom: 8px" src="/img/preloader.svg">');

            var countTours = $('.search-completed-item').length;

            var filters = {};

            $.each($('.tour-filter form').serializeArray(), function () {
                filters[this.name] = this.value;
            });

            // Add data to params array
            filters['country'] = '{{ $country->slug or ""}}';
            filters['sort'] = $('.tours-sorting a:first').attr('data-sort');

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

            $('.tour-filter form').attr('action', '{{route('tour.list')}}');
            $('.tour-filter form').submit();

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
                {name: 'country', value: '{{ $country->slug or ""}}'},
                {name: 'sort', value: $('.tours-sorting-items a:first').attr('data-sort')}
            );

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

                $.ajax({
                    url: "/getCountTours",
                    cache: false,
                    data: data,
                    type: "POST",

                }).done(function (data) {
                    $('#countFound').text(data);
                });

            }).error(function () {
                // If errors
            });
        });

        // Points title auto complete input
        $("#tourPoint").autocomplete({
            source: "/search/autocomplete",
            minLength: 3,
            select: function (event, ui) {
                $('#tourPoint').val(ui.item.value);
            }
        });

        // Sort tours
        $('.tours-sorting-items a').on('click', function () {

            var data = $('.tour-filter form').serializeArray();
            var toursBlock = $('.search-completed-items');

            // Add data to params array
            data.push(
                {name: 'country', value: '{{ $country->slug or ""}}'},
                {name: 'sort', value: $(this).attr('data-sort')}
            );

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

        //Insert dates
        $('.search-completed-item-date a').on('click', function (e) {
            e.preventDefault();
            var date = $(this).attr('data-date');

            $('#tourDate').data('daterangepicker').setStartDate(date);
            $('#tourDate').data('daterangepicker').setEndDate(date);

            $('#filterTours').trigger('click');
        });

        // Insert point
        $('.search-completed-item-route a').on('click', function (e) {
            e.preventDefault();
            var point = $(this).text();

            $('#tourPoint').attr('value', point.trim(','));

            $('#filterTours').trigger('click');
        });
    </script>
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
                        // console.log(key+ ' - ' + value + '\n');
                        $('#' + key + ' span').addClass("red");
                        $('#' + key + ' span').text(value);
                    })
                } else {
                    $('#tourOrderModal .modal-footer').remove();
                    $('#tourOrderModal .modal-body').html("<p style='text-align: center' class=\"alert alert-success\">" + data.message +"</p>");
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