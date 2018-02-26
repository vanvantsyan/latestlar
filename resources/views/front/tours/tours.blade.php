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
        .tours-sorting-items a{
            padding: 5px 0;
        }
        .tours-sorting-items.active {
            box-shadow: 0 16px 16px 0 rgba(0,0,0,.2),0 2px 6px 0 rgba(0,0,0,.1);
            border-radius: 5px;
        }
        form span {
            float: right;
            color: red;
            margin-left: 10px;
        }
    </style>
@endsection

@section('title', $seo['bTitle'])
@section('description', $seo['metaDesc'])
@section('keywords', $seo['metaKey'])

@section('breadcrumbs')
    <div class="breadcrumbs">
        @include('front.tours.modules.breadcrumbs', ['pTitle' => $seo['pTitle']])
    </div>
@endsection

@section('content')
    <div class="wrapper tours-list-page">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                        'level' => $country ?: 'tury',

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
                    <div class="tour-preview-wrap">
                        <div class="tour-preview">
                            <h1>{{$seo['pTitle']}}</h1>
                            <div class="tour-preview-desc">Компания Star Tour предлагает лучшие туры по России. <span>Только самые интересные и проверенные маршруты!</span>
                            </div>
                            <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить
                                заявку<span> на подбор тура</span></a>
                        </div>
                    </div>
                    {{--{{dd($postData)}}--}}
                    @include('front.tours.modules.filters', [
                        'tourTypes' => $tourTypes,
                        'way' => isset($way) ? $way : '',
                        'point' => isset($point) ? $point : '',
                        'tag' => $tag,
                        'postData' => $postData,
                        'duration' => isset($duration) ? $duration : '',
                      ])

                    <div class="search-completed">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title"><span id="toursFrom">{{ $seo['pTitle'] }}</span> из г. Москва, найдено: <span
                                            id="countFound">{{$countTours}}</span></div>
                                <a href="#" class="btn sorting-btn">Кратко</a>
                                <div class="tours-sorting mobile-hide">
                                    Сортировать по: <a href="#" data-sort="duration-desc"><span>Длительности (от большей к меньшей)</span>
                                        <b></b></a>
                                    <div class="tours-sorting-items">
                                        <a href="#" data-sort="price-asc">Стоимости тура (от меньшей к большей)</a>
                                        <a href="#" data-sort="price-desc">Стоимости тура (от большей к меньшей)</a>
                                        <a href="#" data-sort="duration-asc">Длительности (от меньшей к большей)</a>
                                        <a href="#" data-sort="duration-desc" style="display: none">Длительности (от
                                            большей к меньшей)</a>
                                    </div>
                                </div>
                                <div class="tours-sorting desk-hide">
                                    Сортировать по: <a href="#"><span>Стоимости тура</span> <b></b></a>
                                    <div class="tours-sorting-items">
                                        <a href="#">Стоимости тура</a>
                                        <a href="#">Стоимости тура 2</a>
                                        <a href="#">Стоимости тура 3</a>
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
                    <div class="tours-sort-other desk-hide">
                        <a href="#" class="tours-sort-other-item">Туры по тематике</a>
                        <a href="#" class="tours-sort-other-item">Туры по городам России</a>
                        <a href="#" class="tours-sort-other-item">Туры по Золотому кольцу</a>
                        <a href="#" class="tours-sort-other-item">Санатории</a>
                        <a href="#" class="tours-sort-other-item">Речные круизы</a>
                        <a href="#" class="tours-sort-other-item">Другие страны</a>
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
                                            <img src="/img/popular-tours-item-8.jpg" alt="">
                                            <span class="orange">Все санатории России.</span>
                                            <span>Бронируйте он-лайн <br> через СтарТур!</span>
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

                        <a href="#" class="btn-more-tours">Показать еще туры</a>
                    </div>

                    @include('front.tours.modules.articles')
                    @include('front.tours.modules.popularTypes')

                </div>
            </div>
            <div class="clear"></div>
            <div class="seo-txt">
                <h2>Подбор туров</h2>
                <p>Бронирование туров онлайн: быстро и дешево. Подбор отличных туров от всех туроператоров на сайте
                    Стартур.</p>
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
@endsection

@section('js')

    @include('front.tours.modules.list-scripts')

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

        $('.btn-more-tours').on('click', function () {

            var btn = $(this);
            btn.html('<img style="padding-bottom: 8px" src="/img/preloader.svg">');

            var countTours = $('.search-completed-item').length;

            var filters = {};

            $.each($('.tour-filter form').serializeArray(), function () {
                filters[this.name] = this.value;
            });

            // Add data to params array
            filters['country'] = '{{ $country or ""}}';
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
                {name: 'country', value: '{{ $country or ""}}'},
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

                // Get count tours for inscription
                $.ajax({
                    url: "/getCountTours",
                    cache: false,
                    data: data,
                    type: "POST",

                }).done(function (data) {
                    $('#countFound').text(data);
                });

                // Get seo tours for inscription
                $.ajax({
                    url: "{{route('tours.seo')}}",
                    cache: false,
                    data: data,
                    type: "POST",

                }).done(function (data) {
                    $('#toursFrom').text(data.pTitle);
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
                {name: 'country', value: '{{ $country or ""}}'},
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
        $('.search-completed-item-date a.green').on('click', function (e) {
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