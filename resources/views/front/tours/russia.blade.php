@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/russia.css')}}">
    <style>
        @if($country->banner)
        .page-{{substr($country->slug,0,10)}}           {
            background: url(/uploads/countries/banners/{{$country->banner}}) 50% 0 no-repeat;
        }
        @endif
    </style>
@endsection

@section('title', $seo['bTitle'])
@section('description', $seo['metaDesc'])
@section('keywords', $seo['metaKey'])

@section('breadcrumbs')
    <div class="breadcrumbs">
        @include('front.tours.modules.breadcrumbs', ['pTitle' => "Туры " . morph($country->country, 'В', $country->country_cases)])
    </div>
@endsection

@section('content')
    <div class="wrapper @if($country->banner) page-{{substr($country->slug, 0, 10)}} @else page-russia @endif">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                         'level' => $country->slug ?: 'tury',

                         'cities' => $cities,
                         'citiesGolden' => $citiesGolden,
                         'tourTypes' => $tourTypes,
                         'countries' => $countries,
                         'subText' => isset($seo['subText']) ? $seo['subText'] : '',
                         'tag' => $tag,
                         'way' => isset($way) ? $way : '',
                         'point' => isset($point) ? $point : '',
                         'duration' => $duration ?? '',
                         'layer' => $layer,
                      ])
                </div>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="tour-preview">
                        <span class="country-tour-count">{{$country->count_tours}} {{Gliss::numeralCase('тур', $country->count_tours)}}</span>
                        <h1 class="stroke-h">
                            {!!  $seo['pTitle']  !!}
                        </h1>
                        <div class="tour-preview-desc">
                            <div class="stroke-desc">
                                @if (isset($seo['topText']) && $seo['topText'])
                                    {!! $seo['topText'] !!}
                                @else
                                    Компания STARTOUR предлагает лучшие туры
                                    {{ morph($country->country, 'В', $country->country_cases) }}. 
                                    Только самые интересные и проверенные маршруты!
                                @endif
                            </div>
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
                    @if($country->id == 1)
                        <div class="popular-tours">
                            <h2>Самые популярные туры в {{Gliss::case(Date::now()->format('F'), "П")}}
                                {{ morph($country->country, 'В', $country->country_cases) }}</h2>
                            <div class="popular-tours-items">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td style="background-color: #007cbc;">
                                            <div class="popular-tours-item small" id="sendPhone">
                                                <div class="popular-tours-item-title">Подберем тур по Вашим запросам!
                                                </div>
                                                <form>
                                                    <div class="popular-item-phone" id="phone">
                                                        <i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>
                                                        <input name="phone" type="text"
                                                               placeholder="+7 (___) ___-__-__">
                                                    </div>
                                                    <input class="btn btn-blue" type="submit" value="Жду звонка">
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="popular-tours-item small">
                                                <a href="/sanatorii-i-pansionatyi">
                                                    <img src="img/popular-tours-item-8.jpg" alt="">
                                                    <span class="orange">Все санатории России.</span>
                                                    <span>Бронируйте он-лайн <br> через STARTOUR!</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
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
                                                    от {{number_format($countriesGrid['319']['minPrice'],0,'.','')}}
                                                    <span
                                                            class="glyphicon glyphicon-rub" aria-hidden="true"></span>
                                                </div>
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
                                                            class="glyphicon glyphicon-rub" aria-hidden="true"></span>
                                                </div>
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
                                                    if(isset($countriesGrid['419']))
                                                        $images = json_decode($countriesGrid['419']['images']);
                                                    else $images = [];
                                                @endphp
                                                @if(count($images))
                                                    <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                                @endif
                                                @isset($countriesGrid['419'])
                                                    <div class="price">
                                                        от {{number_format($countriesGrid['419']['minPrice'],0,'.','')}}
                                                        <span
                                                                class="glyphicon glyphicon-rub"
                                                                aria-hidden="true"></span>
                                                    </div>

                                                    <div class="popular-tours-item-cont">
                                                        <div class="popular-tours-item-title">{{$countriesGrid['419']['title']}}</div>
                                                        <p>{!! $countriesGrid['419']['description'] !!}</p>
                                                    </div>
                                                @endif
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
                                                    от {{number_format($countriesGrid['387']['minPrice'],0,'.','')}}
                                                    <span
                                                            class="glyphicon glyphicon-rub" aria-hidden="true"></span>
                                                </div>
                                                <div class="popular-tours-item-cont">
                                                    <div class="popular-tours-item-title">{{$countriesGrid['387']['title']}}</div>
                                                    <p>{!! $countriesGrid['387']['description'] !!}</p>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/russia/tury-bajkal" class="popular-tours-item">
                                                @php
                                                    if(isset($countriesGrid[405]))
                                                        $images = json_decode($countriesGrid['405']['images']);
                                                    else $images = [];
                                                @endphp
                                                @if(count($images))
                                                    <img src="{{asset('/img/ways/full/' . (head($images)))}}" alt="">
                                                @endif
                                                @isset($countriesGrid[405])
                                                    <div class="price">
                                                        от {{number_format($countriesGrid['405']['minPrice'],0,'.','')}}
                                                        <span
                                                                class="glyphicon glyphicon-rub"
                                                                aria-hidden="true"></span>
                                                    </div>
                                                    <div class="popular-tours-item-cont">
                                                        <div class="popular-tours-item-title">{{$countriesGrid['405']['title']}}</div>
                                                        <p>{!! $countriesGrid['405']['description'] !!}</p>
                                                    </div>
                                                @endif
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
                                                            class="glyphicon glyphicon-rub" aria-hidden="true"></span>
                                                </div>
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
                                                    от {{number_format($countriesGrid['323']['minPrice'],0,'.','')}}
                                                    <span
                                                            class="glyphicon glyphicon-rub" aria-hidden="true"></span>
                                                </div>
                                                <div class="popular-tours-item-cont">
                                                    <div class="popular-tours-item-title">{{$countriesGrid['323']['title']}}</div>
                                                    <p>{!! $countriesGrid['323']['description'] !!}</p>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="burning-tours">
                        <div class="burning-tours-filter-wrap">
                            <h2 class="hot">Горящие туры {{ morph($country->country, 'В', $country->country_cases) }} из <a href="#">Москвы</a>
                            </h2>
                            <div class="burning-tours-filter" id="toursTab">
                                @if(count($hotToursAny))<a class="active" href="#hotToursAny" class="active"
                                                           data-toggle="tab">Все</a>@endif
                                @if(count($hotToursOne))<a href="#hotToursOne" data-toggle="tab">Однодневные</a>@endif
                                @if(count($hotToursMany))<a href="#hotToursMany"
                                                            data-toggle="tab">Многодневные</a>@endif
                                @if(count($hotToursActive))<a href="#hotToursActive" data-toggle="tab">Активный
                                    отдых</a>@endif
                            </div>
                        </div>
                        <div class="burning-tours-items-wrap">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row tab-content">
                                    @php
                                        $hot = [
                                            'hotToursAny',
                                            'hotToursOne',
                                            'hotToursMany',
                                            'hotToursActive'
                                        ];
                                    @endphp

                                    @foreach($hot as $hotTypeName)
                                        <div class="burning-tours-items tab-pane fade in @if($loop->first) active @endif"
                                             id="{{$hotTypeName}}">
                                            @foreach($$hotTypeName as $tour)
                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="row">
                                                        <div class="burning-tours-item">
                                                            <div class="burning-tours-item-img">
                                                                @php
                                                                    $images = (array) json_decode($tour['images']);
                                                                @endphp
                                                                <img onclick="window.open('{{Gliss::tourLink($tour)}}','_blank')"
                                                                     src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}"
                                                                     alt="">
                                                                @if($tour['price'] > 0)
                                                                    <span>от {{number_format($tour['price'], 0 ,'.','')}}
                                                                        <span class="glyphicon glyphicon-rub"
                                                                              aria-hidden="true"></span> / чел.
                                                                </span>
                                                                @else
                                                                    <span>Цена не указана</span>
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
                                    @endforeach

                                    <a target="_blank" href="http://startour.ru/goryashhie-turyi/"
                                       class="btn-more-tours">Показать еще больше горящих туров</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--@include('front.tours.modules.articles')--}}
                    @include('front.tours.modules.popularTypes')
                </div>
            </div>
            <div class="clear"></div>
            <div class="seo-txt">
                @if (isset($seo['bottomText']) && $seo['bottomText'])
                    {!! $seo['bottomText'] !!}
                @else
                    <h2>О стране</h2>
                    @php
                        $colSimbols = strlen(Str::words($country->description, 50, '...'));
                    @endphp
                    {!! Str::words($country->description, 50, '...') !!}
                    <div class="seo-txt-more">
                        {!! substr($country->description, $colSimbols) !!}
                    </div>
                    <a href="#" class="seo-txt-btn">Больше информации</a>
                @endif
            </div>
        </div>
        {{--@include('front.modules.subscription')--}}
        {{--@include('front.modules.infoCompany')--}}
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
    <script src="{{asset('/js/russia.js')}}"></script>
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
                url: "{!! route('mail.order')!!}",
                cache: false,
                data: data,
                type: "POST",

            }).done(function (data) {

                $('#tourOrderModal form span').text("");

                if (!data.ok && data.errors) {
                    $.each(data.errors, function (key, value) {
                        console.log(key + ' - ' + value + '\n');
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

        // Tours filter apply
        $('#filterTours').on('click', function (e) {

            $('.tour-filter form').attr('action', '{!! route('tour.list')!!}');
            $('.tour-filter form').submit();

            var filterBtn = $(this);

            filterBtn.removeClass('btn-blue');
            filterBtn.addClass('preloader');
            filterBtn.attr('value', 'Идет подбор туров...');


            // Avoid the jump
            e.preventDefault();
        });
    </script>

@endsection