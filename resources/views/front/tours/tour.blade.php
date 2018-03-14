@extends('layouts.front')

@section('css')
    <style>
        .tour-card-text table td {
            border: 1px solid #d5d5d5;
        }

        .tour-card-text table tbody tr:nth-child(2n+1) td {
            padding-top: 20px;
            border-top: 1px solid #d5d5d5;
        }

        .tour-card-text table {
            word-break: break-all;
            margin: 20px auto;
        }

        .tour-card-text table td {
            padding: 0 5px;
        }

        .card-desc {
            display: inline-block;
        }

        a.order {
            width: auto !important;
        }

        .card-tour-photo {
            cursor: pointer;
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
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <a href="/">Главная страница</a> -
                    <a href="/tury">Поиск тура</a> -
                    <span>{{$tour->title}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper tours-card-page">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">

                    @include('front.tours.modules.sidebar', [
                        'country' => $country->slug ?? 'russia',
                        'level' => $country->slug ?: 'tury',
                        'cities' => $cities,
                        'citiesGolden' => $citiesGolden,
                        'tourTypes' => $tourTypes,
                        'countries' => $countries,
                        'subText' => $seo['subText'],
                        'tag' => '',
                        'way' => isset($way) ? $way : '',
                        'point' => isset($point) ? $point : '',
                        'duration' => '',
                        'month' => '',
                        'layer' => 3,
                     ])
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="card-slider">
                        @foreach(json_decode($tour->images) as $image)
                            <div class="card-slider-item">
                                <img src="{{Gliss::tourImg($image, $tour->id)}}" alt="">
                                <div class="card-slider-item-cont">
                                    <a href="{{route('tour.list')}}" class="back-tours-list">< Вернуться назад к
                                        списку</a>
                                    @if($loop->first)
                                        @if(Gliss::wordsCount($tour->title) > 5)
                                            <h1 class="font38">{{$tour->title}}</h1>
                                        @else
                                            <h1>{{$tour->title}}</h1>
                                        @endif
                                    @else
                                        @if(Gliss::wordsCount($tour->title) > 5)
                                            <div class="h1 font38">{{$tour->title}}</div>
                                        @else
                                            <div class="h1">{{$tour->title}}</div>
                                        @endif
                                    @endif
                                    <div>
                                        <div class="slider-tour-price">
                                            <span>
                                                @if($tour->price > 0)
                                                    Стоимость: от {{number_format($tour['price'], 0, '.',' ')}}
                                                    <span class="glyphicon glyphicon-rub" aria-hidden="true"></span>
                                                    за человека
                                                @else
                                                    <b>Цена</b> не указана
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-yellow" data-toggle="modal"
                                       data-target="#tourOrderModal">Отправить заявку на тур</a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="card-tour-filter">
                        <a href="#card-tour-desc" class="active">Описание и фото тура</a>
                        <a href="#card-tour-dates">Даты начала тура</a>
                        <a href="#card-base-price">Что включено в стоимость?</a>
                        <a href="#card-schedule">Расписание тура</a>
                        <a href="#accommodation-options">Варианты размещения</a>
                        <a href="#" data-toggle="modal" data-target="#tourOrderModal">Заявка на тур</a>
                    </div>

                    <div class="card-tour-desc" id="card-tour-desc">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Описание и фото тура</div>
                                <div class="card-tour-photo" data-images="{{ $tour['images'] }}"
                                     data-tour-id="{{ $tour['id'] }}">
                                    @foreach(json_decode($tour->images) as $key => $image)
                                        <img height="150" src="{{Gliss::tourThumb($image, $tour->id)}}"
                                             alt="{{$tour->title}}" data-image-id="{{$key}}" data-toggle="modal"
                                             data-target="#tourImagesModal">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(count($tour->dates))
                        <div class="card-tour-dates" id="card-tour-dates">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="title">Доступные даты начала тура</div>
                                    <div class="card-tour-dates-items">
                                        @php
                                            $dateMonths = [];
                                                foreach($tour->dates as $date) {
                                                    $dateMonths[(int) Carbon\Carbon::createFromTimestamp($date['value'])->format('m')][] = $date;
                                                }
                                        @endphp

                                        @php
                                            $dateTime = new \DateTime('now');
                                        @endphp

                                        @foreach ($dateMonths as $month => $dates)
                                            @if($loop->iteration < 4)

                                                <div class="card-tour-dates-item">
                                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                        <div class="row">
                                                            <div class="card-tour-dates-item-month">
                                                                {{ config('main.month.' . strtolower(date("F",mktime(0,0,0,$month)))) }}
                                                                , {{$dateTime->format('Y')}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                                        <div class="row">
                                                            <div class="card-tour-dates-item-day">

                                                                @foreach($dates as $date)

                                                                    <a href="#" class="green"
                                                                       data-date="{{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}">
                                                                        {{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}
                                                                    </a>

                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @else

                                                <div class="card-tour-dates-item hide">
                                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                        <div class="row">
                                                            <div class="card-tour-dates-item-month">
                                                                {{ config('main.month.' . strtolower(date("F",mktime(0,0,0,$month)))) }}
                                                                , {{$dateTime->format('Y')}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                                        <div class="row">
                                                            <div class="card-tour-dates-item-day">
                                                                @foreach($dates as $date)
                                                                    <a href="#" class="green"
                                                                       data-date="{{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}">
                                                                        {{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
                                    </div>
                                    @if(count($dateMonths) > 3)
                                        <a href="#" class="btn-more-dates">Показать еще даты тура</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @php
                        $textData = Gliss::parsTourDescription($tour->text);
                    @endphp
                    @if($textData['includedInPrice'])
                        <div class="card-base-price" id="card-base-price">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    @if($tour['price'] > 0)
                                        <div class="title">Что включено в базовую
                                            стоимость {{number_format($tour['price'], 0, '.',' ')}} <span
                                                    class="glyphicon glyphicon-rub" aria-hidden="true"></span> за
                                            человека?
                                        </div>
                                    @endif
                                    {!!  $textData['includedInPrice'] !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card-schedule" id="card-schedule">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Расписание тура</div>

                                @foreach($textData['tourDays'] as $day => $dayDesc)
                                    <div class="card-schedule-day-item">

                                        <a href="#" class="card-schedule-day">
                                            {{$day}} день <span class="caret"></span>
                                        </a>

                                        <div class="card-schedule-day-desc" style="display: none">
                                            <div class="accommodation-options-day-cont"> {!! $dayDesc!!}</div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="tour-card-text" id="accommodation-options">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                {!!  $textData['rest'] !!}
                            </div>
                        </div>

                        <div class="card-desc">
                            <h3>О туре</h3>
                            {{$tour->description }}</div>
                    </div>

                    <div class="card-tour-similar">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Похожие туры</div>
                                <div class="search-completed-items mobile-hide">

                                    @foreach($similars->toArray() as $tour)
                                        @include('front.tours.snippets.list-block', $tour)
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('front.tours.modules.articles')
                    @include('front.tours.modules.popularTypes')
                </div>
            </div>
            <div class="clear"></div>
            @if(isset($country['description']))
                <div class="seo-txt">
                    <h2>О стране</h2>
                    {!! Str::words($country->description, 50, '...') !!}
                    <div class="seo-txt-more">
                        {!! $country->description !!}
                    </div>
                    <a href="#" class="seo-txt-btn">Больше информации</a>
                </div>
            @endif
        </div>
        @include('front.modules.subscription')
        @include('front.modules.infoCompany')
        @include('front.modules.partners')
        @include('front.modules.bigFooter')
    </div>
    @include('front.tours.modal.images')
    @include('front.tours.modal.order', ['tour' => $tour])
@endsection

@section('js')

    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.btn-more-dates').on('click', function () {

            $('.card-tour-dates-item').removeClass('hide');
            $(this).addClass('hide');

            return false;
        });


        // See all photos of the tour

        $('#tourImagesModal').on('show.bs.modal', function (e) {

            var imgBlock = $(e.relatedTarget).closest('.card-tour-photo');
            var imgActive = $(e.relatedTarget);

            var tourId = imgBlock.attr('data-tour-id');
            var images = imgBlock.attr('data-images');

            var slideBlock = '';

            var slideContainer = ".carousel-inner";
            var indicators = '';
            var active = '';

            $.each($.parseJSON(images), function (key, value) {
                if (imgActive.attr('data-image-id') && key == imgActive.attr('data-image-id')) active = "active"; else active = '';
                slideBlock += "<div class='item " + active + "'> <img src=\'/img/tours/full/" + tourId.substr(0, 2) + "/" + value + "'></div>";

                indicators += "<li data-target=\"#tourImagesCarousel\" data-slide-to='" + key + "' class='" + active + "'></li>";
            });

            $(slideContainer).html(slideBlock);
            $('.carousel-indicators').html(indicators);
        });
    </script>

    <script>
        $('.card-tour-dates-item-day a').on({

            mouseenter: function () {
                $(this).text('Заказать');
                $(this).addClass('order');
            },
            mouseleave: function () {
                $(this).text($(this).attr('data-date'));
                $(this).removeClass('order');
            },
            click: function (e) {

                var tourDate = $(this).attr('data-date');
                $('input[name=tourDate]').attr('value', tourDate);

                e.preventDefault();
                $('#tourOrderModal').modal('show');
            }

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