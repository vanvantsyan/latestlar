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
                            <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить заявку<span> на подбор тура</span></a>
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
                                <div class="title">Туры по России из г. Москва, найдено: <span id="countFound">{{$countTours}}</span></div>
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
                                {{--<div class="search-completed-items mobile-hide">--}}
                                {{--<div class="search-completed-item tablet-hide">--}}
                                {{--<div class="search-completed-item-preview">--}}
                                {{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">--}}
                                {{--<div class="row">--}}
                                {{--<div class="search-completed-preview-left">--}}
                                {{--<div class="search-completed-item-title">Легендарная Русь 4* - очень длинный заголовок очень длинный заголовок</div>--}}
                                {{--<ul>--}}
                                {{--<li>9 городов</li>--}}
                                {{--<li>14 экскурсий</li>--}}
                                {{--<li>Поездка на 4 дня</li>--}}
                                {{--</ul>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-5">--}}
                                {{--<div class="row">--}}
                                {{--<div class="search-completed-preview-right">--}}
                                {{--<div class="search-completed-item-price">--}}
                                {{--<b>от 8200 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></b>--}}
                                {{--<span>за человека</span>--}}
                                {{--</div>--}}
                                {{--<a href="#" class="btn btn-orange">Заказать</a>--}}
                                {{--<a href="#" class="btn btn-blue">Подробнее</a>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="search-completed-item-more">--}}
                                {{--<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">--}}
                                {{--<div class="row">--}}
                                {{--<a href="#" class="search-completed-item-img">--}}
                                {{--<img src="img/search-completed-item-1.jpg" alt="">--}}
                                {{--<span>Все фото (18)</span>--}}
                                {{--</a>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">--}}
                                {{--<div class="row">--}}
                                {{--<div class="search-completed-item-more-right">--}}
                                {{--<div class="search-completed-item-route">--}}
                                {{--<span>Маршрут тура:</span> <b>Москва</b> - Владимир, Боголюбово, Суздаль, Иваново, Кострома, Ярославль, Ростов Великий, Переславль Залесский, Сергиев Посад - <b>Москва</b>--}}
                                {{--</div>--}}
                                {{--<div class="search-completed-item-date">--}}
                                {{--<a href="#" class="red">14.12</a>--}}
                                {{--<a href="#" class="green">22.12</a>--}}
                                {{--<a href="#" class="red">26.12</a>--}}
                                {{--<a href="#" class="red">14.12</a>--}}
                                {{--<a href="#" class="green">22.12</a>--}}
                                {{--<a href="#" class="red">26.12</a>--}}
                                {{--<a href="#" class="green">22.12</a>--}}
                                {{--<a href="#" class="all-dates">Все даты <b>>>></b></a>--}}
                                {{--</div>--}}
                                {{--<div class="search-completed-item-desc">--}}
                                {{--Великий праздник Пасхи в одном из самых святых уголков русской земли! Знакомство со святынями былинного Мурома и Светлое Христово Воскресение...--}}
                                {{--<a href="#">Подробнее</a>--}}
                                {{--</div>--}}
                                {{--<div class="search-completed-item-tags">Для детей, Золотое кольцо, Новогодние туры</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="search-completed-items mobile-hide">
                        @if(count($toursParts))
                            @foreach($toursParts[0] as $tour)
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
                                                    <a href="#" class="btn btn-orange">Заказать</a>
                                                    <a href="#" class="btn btn-blue">Подробнее</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-completed-item-more">
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
                                                        <img src="{{asset('/img/search-completed-item-1.jpg')}}" alt="">
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
                                                            <a href="#" class="all-dates">Все даты <b>>>></b></a>
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
                    <div class="search-completed-items mobile-hide">
                        @if(count($toursParts) > 1)
                            @forelse($toursParts[1] as $tour)
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
                                                    <a href="#" class="btn btn-orange">Заказать</a>
                                                    <a href="#" class="btn btn-blue">Подробнее</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-completed-item-more">
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
                                                        <img src="{{asset('/img/search-completed-item-1.jpg')}}" alt="">
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
                                                            <a href="#" class="all-dates">Все даты <b>>>></b></a>
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
                            @empty
                            @endforelse
                        @endif

                        <a href="#" class="btn-more-tours">Показать еще туры</a>
                    </div>

                    @include('front.tours.modules.notes')
                    @include('front.tours.modules.category')

                </div>
            </div>
            <div class="clear"></div>
            <div class="seo-txt">
                <h2>SEO текст для раздела о России</h2>
                <p>Золотое Кольцо России - это маршрут, раскрывающий красоту древней Руси, который был разработан для
                    тех, кто желает познакомиться с нашей страной. Это настоящая энциклопедия архитектурных ценностей. В
                    туры по Золотому кольцу входят путешествия по восьми основным городам Российской Федерации:
                    Владимир, Суздаль, Сергиев Посад, Переславль-Залесский, Ростов Великий, Ярославль, Кострома,
                    Иваново.</p>
                <div class="seo-txt-more">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit
                    expedita nemo voluptatibus nesciunt blanditiis totam, aut, quod optio quisquam, quia minus eligendi.
                    Blanditiis minus, facilis assumenda molestiae fuga adipisci mollitia.
                </div>
                <a href="#" class="seo-txt-btn">Больше информации</a>
            </div>
        </div>
        <div class="subscription">
            <div class="container">
                <div class="subscription-title">Получайте лучшие предложения по цене на почту!</div>
                <form>
                    <select>
                        <option>Все страны</option>
                        <option>Страна 1</option>
                        <option>Страна 2</option>
                    </select>
                    <input type="email" placeholder="Ваша электронная почта">
                    <input class="btn btn-blue" type="submit" value="Подписаться">
                </form>
            </div>
        </div>
        <div class="info-company">
            <div class="container">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                    <div class="row">
                        <div class="about-company">
                            <div class="info-company-title">Информация о компании</div>
                            <p>"СтарТур" - одно из популярных туристических агенств, ежедневно помогающее людям в
                                подборе и бронировании туров, авиабилетов, трансферов, экскурсий и круизов. В месяц мы
                                обслуживаем свыше 4000 клиентов.</p>
                            <p>Наша главная задача - сэкономить ваши деньги и обеспечить вас наилучшим отдыхом.</p>
                            <p><b>За 14 лет плодотворной работы мы смогли:</b></p>
                            <ul>
                                <li>Накопить свыше 500 корпоративных клиентов;</li>
                                <li>Принять в штат 40 сотрудников;</li>
                                <li>Заполучить более сотни партнеров в России и Европе.</li>
                            </ul>
                            <p>Мы с первого дня совершенствуемся, накапливаем опыт и принимаем активное участие в
                                различных мероприятиях. Наши дипломы и награды говорят о наших достижениях и высоком
                                качестве предоставлямых услуг.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                    <div class="row">
                        <div class="news-company">
                            <div class="info-company-title">Новости компании</div>
                            <div class="news-company-items">
                                <a href="#" class="news-company-item">
                                    <b>12.12.2017</b>
                                    <span>Новые правила провоза багажа...</span>
                                </a>
                                <a href="#" class="news-company-item">
                                    <b>12.12.2017</b>
                                    <span>В какие страны можно поехать без визы?</span>
                                </a>
                                <a href="#" class="news-company-item">
                                    <b>12.12.2017</b>
                                    <span>Куда поехать в ноябре?</span>
                                </a>
                                <a href="#" class="news-company-item">
                                    <b>12.12.2017</b>
                                    <span>Как не попасться на уловки мошенников?</span>
                                </a>
                                <a href="#" class="news-company-item">
                                    <b>12.12.2017</b>
                                    <span>Куда поехать в ноябре?</span>
                                </a>
                            </div>
                            <a href="#">Посмотреть все новости</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="partners">
            <div class="container">
                <div class="partners-items">
                    <div class="col-xs-6 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="/img/partners-item-1.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="/img/partners-item-2.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="/img/partners-item-3.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="/img/partners-item-4.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="/img/partners-item-5.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sitemap">
            <div class="container">
                <div class="sitemap-items">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-4-5">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="row">
                                    <div class="sitemap-item">
                                        <div class="title">Горящие туры</div>
                                        <ul>
                                            <li><a href="#">Греция от 15100Р</a></li>
                                            <li><a href="#">Хорватия от 15100Р</a></li>
                                            <li><a href="#">Санкт-Петербург от 15100Р</a></li>
                                            <li><a href="#">Прага от 15100Р</a></li>
                                            <li><a href="#">Доминикана от 15100Р</a></li>
                                            <li><a href="#">Париж от 15100Р</a></li>
                                            <li><a class="link-blue" href="#">Все варианты</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="row">
                                    <div class="sitemap-item">
                                        <div class="title">Поиск тура</div>
                                        <ul>
                                            <li><a class="link-blue" href="#">Поиск по стране</a></li>
                                            <li><a class="link-blue" href="#">Поиск по категории</a></li>
                                            <li><a href="#">Визовые вопросы</a></li>
                                            <li><a href="#">Страхование</a></li>
                                            <li><a href="#">Трансферы</a></li>
                                            <li><a href="#">Экскурсии</a></li>
                                            <li><a href="#">Круизы</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="row">
                                    <div class="sitemap-item">
                                        <div class="title">Для клиентов</div>
                                        <ul>
                                            <li><a href="#">Вопросы и ответы</a></li>
                                            <li><a href="#">Способы оплаты</a></li>
                                            <li><a href="#">Рассрочка и кредит</a></li>
                                            <li><a href="#">Советы туристу</a></li>
                                            <li><a href="#">Бонусная программа</a></li>
                                            <li><a href="#">Подарочные сертификаты</a></li>
                                            <li><a href="#">О нас</a></li>
                                            <li><a href="#">Акции</a></li>
                                            <li><a href="#">Отзывы</a></li>
                                            <li><a href="#">Контакты</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                <div class="row">
                                    <div class="sitemap-item">
                                        <div class="title">Партнерам</div>
                                        <ul>
                                            <li><a href="#">Для турагенств</a></li>
                                            <li><a href="#">Корпоративным клиентам</a></li>
                                            <li><a href="#">Центр бронирования</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-1-5">
                        <div class="row">
                            <div class="sitemap-item" itemscope itemtype="http://schema.org/Organization">
                                <div class="phone">
                                    <a href="tel:+74994904412" itemprop="telephone">+7 (499) <b>490-44-12</b></a>
                                    <a href="tel:+78007700622" itemprop="telephone">+7 (800) <b>770-06-22</b></a>
                                </div>
                                <a href="#" class="mail" itemprop="email">travel@startour.ru</a>
                                <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">Адрес:
                                    Россия, <span itemprop="addressLocality">г.Москва</span>, <span
                                            itemprop="streetAddress">ул. Кузнецкий Мост, д. 21/5</span>
                                    <br> 1 подъезд</p>
                                <div class="soc">
                                    <a href="#" class="tw"></a>
                                    <a href="#" class="vk"></a>
                                    <a href="#" class="fb"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('front.tours.modal.images')
    @include('front.tours.modal.order')
@endsection

@section('js')
    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{asset('/js/moment.js')}}"></script>
    <script src="{{asset('/js/daterangepicker.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>$(function(){$('[data-toggle="tooltip"]').tooltip()})</script>
    <script>
        $('#sendPhone input[type=submit]').on('click', function(e){
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
            @elseif($tourDate)
            @php
            $datesArr = explode('-', $tourDate);
            @endphp
            startDate: '{{trim(head($datesArr))}}',
            endDate: '{{trim(last($datesArr))}}',
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
@endsection