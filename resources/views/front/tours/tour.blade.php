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
                        'country' => 'russia',
                        'level' => 'russia' ?: 'tury',
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
                                    <h1>{{$tour->title}}</h1>
                                    <div>
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
                                    <a href="#" class="btn-more-dates">Показать еще даты тура</a>
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
                                        <div class="search-completed-item tablet-hide">
                                            <div class="search-completed-item-preview">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
                                                    <div class="row">
                                                        <div class="search-completed-preview-left">
                                                            <div class="search-completed-item-title">{{$tour['title']}}</div>
                                                            <ul>
                                                                <li>{{count($tour['par_points']) ?: 1}} {!! Gliss::numeralCase('город', count($tour['par_points']) ?: 1) !!}</li>
                                                                <li>14 экскурсий</li>
                                                                <li>Поездка
                                                                    на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5">
                                                    <div class="row">
                                                        <div class="search-completed-preview-right">
                                                            <div class="search-completed-item-price">
                                                                @if($tour['price'] > 0)
                                                                    <b>от {{number_format($tour['price'], 0, '.',' ') }}
                                                                        <span class="glyphicon glyphicon-rub"
                                                                              aria-hidden="true"></span>
                                                                    </b>
                                                                    <span>за человека</span>
                                                                @else
                                                                    <b>Цена</b>
                                                                    <span>не указана</span>
                                                                @endif
                                                            </div>
                                                            <a href="#" class="btn btn-orange" data-toggle="modal"
                                                               data-target="#tourOrderModal">Заказать</a>
                                                            <a href="{{Gliss::tourLink($tour)}}" class="btn btn-blue">Подробнее</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="search-completed-item-more" style="display: none">
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="row">
                                                        <a href="#" class="search-completed-item-img">
                                                            @php
                                                                $images = (array) json_decode($tour['images']);
                                                            @endphp
                                                            @if(count($images))
                                                                <img src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}"
                                                                     alt="">
                                                            @else
                                                                <img src="{{asset('/img/search-completed-item-1.jpg')}}"
                                                                     alt="">
                                                            @endif
                                                            @if(count($images))
                                                                <span class="tour-images-button"
                                                                      data-images="{{ $tour['images'] }}"
                                                                      data-tour-id="{{$tour['id']}}" data-toggle="modal"
                                                                      data-target="#tourImagesModal">Все фото ({{count($images)}}
                                                                    )</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                    <div class="row">
                                                        <div class="search-completed-item-more-right">
                                                            <div class="search-completed-item-route">
                                                                <span>Маршрут тура:</span>
                                                                @if(count($tour['par_points']))

                                                                    @php
                                                                        $i = 1;
                                                                    @endphp

                                                                    @foreach($tour['par_points'] as $point)
                                                                        @if($i < count($tour['par_points']))
                                                                            <a href="#">{{array_get($point,'points_par.title')}}</a>
                                                                            ,
                                                                        @else
                                                                            <a href="#">{{array_get($point,'points_par.title')}}</a>
                                                                        @endif
                                                                        @php $i++ @endphp
                                                                    @endforeach

                                                                @else
                                                                    @if(count($tour['par_ways']))
                                                                        {{$tour['par_ways'][0]['ways_par']['title']}}
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div class="search-completed-item-date">
                                                                @php $num = 0; @endphp

                                                                @foreach($tour['dates'] as $date)
                                                                    @if ($num > 5)
                                                                        @break
                                                                    @endif
                                                                    <a href="#" class="green">
                                                                        {{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}
                                                                    </a>

                                                                    @php $num++; @endphp
                                                                @endforeach

                                                                @if(count($tour['dates']) > 6)
                                                                    <a href="#" class="all-dates">Все даты
                                                                        <b>>>></b></a>
                                                                @endif
                                                            </div>
                                                            <div class="search-completed-item-desc">
                                                                {!! Str::words($tour['description'], 17,'...') !!}
                                                                <a href="{{Gliss::tourLink($tour)}}">Подробнее</a>
                                                            </div>
                                                            <div class="search-completed-item-tags">
                                                                @php
                                                                    $tourTypes = [];
                                                                @endphp
                                                                @foreach($tour['tour_tags'] as $tag)
                                                                    @if(in_array($tag['tag_id'], [3,4,5]))
                                                                        @php
                                                                            $tourTypes[] = array_get($tag, 'fix_value.alias');
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                {!! implode(', ', $tourTypes) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    @include('front.tours.modal.order')
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

            $.each($.parseJSON(images), function (key, value) {
                if (key == imgActive.attr('data-image-id')) active = "active"; else active = '';
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
                e.preventDefault();
                $('#tourOrderModal').modal('show')
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