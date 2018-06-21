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

        @if(isset($country) && $country->banner)
        .page-{{$country->slug}}     {
            background: url(/uploads/countries/banners/{{$country->banner}}) 50% 0 no-repeat;
        }
        @endif
    </style>
@endsection

@section('title', "404 Страница не найдена")
@section('description', "404 Страница не найдена")
@section('keywords',"404 Страница не найдена")

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

                        <span itemprop="title">Страница не найдена</span>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper page-russia">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                         'level' => 'tury',
                            'tag' => "",
                            'way' => '',
                            'point' => "",
                    'country' => '',
                    'month' => '',
                    'tourTypes' => [],
                    'countries' => [],
                    'duration' => '',
                    'subText' => '',
                         'layer' => 3,
                      ])
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="tour-preview">
                        <h1 class="stroke-h">
                            Страница не найдена | 404
                        </h1>
                        <div class="tour-preview-desc">
                            <div class="stroke-desc">
                                Добро пожаловать на страницу 404! Вы находитесь здесь, потому что ввели адрес страницы,
                                которая уже не существует или была перемещена по другому адресу
                            </div>
                        </div>
                        <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить
                            заявку на подбор тура</a>
                    </div>

                    {{--@include('front.tours.modules.articles')--}}
                    {{--@include('front.tours.modules.popularTypes')--}}
                </div>
            </div>
            <div class="clear"></div>
        </div>
        {{--@include('front.modules.subscription')--}}
        {{--@include('front.modules.infoCompany')--}}
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
    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{asset('/js/moment.js')}}"></script>
    <script src="{{asset('/js/daterangepicker.js')}}"></script>
    {{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
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

            startDate: moment().format('DD.MM.YYYY'),
            endDate: moment().add(30, 'day').format('DD.MM.YYYY'),

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