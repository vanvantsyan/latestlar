@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
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
            margin-top: 20px;
            border-top: 1px solid #d5d5d5;
            padding: 20px 0 0 0;
            display: inline-block;
        }

    </style>
@endsection


@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <a href="#">Главная страница</a> -
                    <a href="#">Поиск тура</a> -
                    <span>Туры по России</span>
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
                    <div class="sidebar-wrap">
                        <div class="sidebar">
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-title">Отдых в России</div>
                                <ul>
                                    <li><a href="#" class="new-year-icon">Новогодние туры</a></li>
                                    <li><a href="#">На майские праздники</a></li>
                                    <li><a href="#">Однодневные туры</a></li>
                                    <li><a href="#">Многодневные туры</a></li>
                                    <li><a href="#">Золотое кольцо</a></li>
                                    <li><a href="#">Для детей и взрослых</a></li>
                                    <li><a href="#">Туры выходного дня</a></li>
                                    <li><a href="#">Индивидуальные туры</a></li>
                                    <li><a href="#">ВИП туры</a></li>
                                    <li><a href="#">Камчатка</a></li>
                                    <li><a href="#">Алтай</a></li>
                                </ul>
                            </div>
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-subtitle">Города России</div>
                                <ul>
                                    <li><a href="#">Туры в Казань</a></li>
                                    <li><a href="#">Туры в Екатеринбург</a></li>
                                    <li><a href="#">Туры в Суздаль</a></li>
                                    <li><a href="#">Туры в Санкт-Петербург</a></li>
                                    <li><a href="#">Другие города</a></li>
                                </ul>
                            </div>
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-subtitle">Туры по золотому кольцу</div>
                                <ul>
                                    <li><a href="#">Владимир</a></li>
                                    <li><a href="#">Кострома</a></li>
                                    <li><a href="#">Ярославль</a></li>
                                    <li><a href="#">Ростов</a></li>
                                    <li><a href="#">Суздаль</a></li>
                                    <li><a href="#">Другие города</a></li>
                                </ul>
                            </div>
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-title">Виды отдыха</div>
                                <ul>
                                    <li><a href="#">Гастрономические туры</a></li>
                                    <li><a href="#">Экскурсионные туры</a></li>
                                    <li><a href="#">Активный отдых</a></li>
                                    <li><a href="#">Семейный отдых</a></li>
                                    <li><a href="#">Рыбалка и охота</a></li>
                                    <li><a href="#">Пляжный отдых</a></li>
                                </ul>
                            </div>
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-title">Типы туров</div>
                                <ul>
                                    <li><a href="#">Экскурсии с животными</a></li>
                                    <li><a href="#">Экскурсии в Москве</a></li>
                                    <li><a href="#">Экскурсии</a></li>
                                    <li><a href="#">Фабрики и заводы</a></li>
                                    <li><a href="#">Усадьбы, дворцы</a></li>
                                    <li><a href="#">Событийные туры</a></li>
                                    <li><a href="#">Серебрянное кольцо России</a></li>
                                </ul>
                                <a class="btn-rest-tours" href="#">Показать остальные туры</a>
                            </div>
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-title">Другие страны</div>
                                <ul>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-notice">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat
                            voluptatum eos harum officiis laborum reiciendis architecto ad iste eligendi, corrupti
                            porro, similique perferendis facilis! Excepturi odit quas repellendus tempora, repellat.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="card-slider">
                        @foreach(json_decode($tour->images) as $image)
                            <div class="card-slider-item">
                                <img src="{{Gliss::tourImg($image, $tour->id)}}" alt="">
                                <div class="card-slider-item-cont">
                                    <a href="{{route('tourList')}}" class="back-tours-list">< Вернуться назад к
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
                                    <a href="#" class="btn btn-yellow">Отправить заявку на тур</a>
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
                        <a href="#">Заявка на тур</a>
                    </div>

                    <div class="card-tour-desc" id="card-tour-desc">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Описание и фото тура</div>
                                <p></p>
                                <div class="card-tour-photo">
                                    @foreach(json_decode($tour->images) as $image)
                                        <img height="150" src="{{Gliss::tourThumb($image, $tour->id)}}"
                                             alt="{{$tour->title}}">
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-tour-dates" id="card-tour-dates">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Доступные даты начала тура</div>
                                <div class="card-tour-dates-items">
                                    @php
                                        $dateTime = new \DateTime('now');
                                    @endphp

                                    @for ($i=0;$i<12;$i++)
                                        @if($i < 3)
                                            <div class="card-tour-dates-item">
                                                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                    <div class="row">
                                                        <div class="card-tour-dates-item-month">
                                                            @if($i == 0)
                                                                {{config('main.month.' . strtolower($dateTime->modify('+ 0 month')->format('F'))) }}
                                                            @else
                                                                {{config('main.month.' . strtolower($dateTime->modify('+ 1 month')->format('F')))}}
                                                            @endif
                                                            , {{$dateTime->format('Y')}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                                    <div class="row">
                                                        <div class="card-tour-dates-item-day">
                                                            @foreach($tour->dates as $date)
                                                                @if(Carbon\Carbon::createFromTimestamp($date['value'])->format('m') == $dateTime->format('m'))
                                                                    <a href="#"
                                                                       class="green"> {{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}</a>
                                                                @endif
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
                                                            @if($i == 0)
                                                                {{config('main.month.' . strtolower($dateTime->modify('+ 0 month')->format('F'))) }}
                                                            @else
                                                                {{config('main.month.' . strtolower($dateTime->modify('+ 1 month')->format('F')))}}
                                                            @endif
                                                            , {{$dateTime->format('Y')}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                                    <div class="row">
                                                        <div class="card-tour-dates-item-day">
                                                            @foreach($tour->dates as $date)
                                                                @if(Carbon\Carbon::createFromTimestamp($date['value'])->format('m') == $dateTime->format('m'))
                                                                    <a href="#"
                                                                       class="green"> {{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}</a>
                                                                @endif
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endfor

                                </div>
                                <a href="#" class="btn-more-dates">Показать еще даты тура</a>
                            </div>
                        </div>
                    </div>
                    @php
                        $textData = Gliss::parsTourDescription($tour->text);
                    @endphp
                    @if($textData['includedInPrice'])
                        <div class="card-base-price" id="card-base-price">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="title">Что включено в базовую
                                        стоимость {{number_format($tour['price'], 0, '.',' ')}} <span
                                                class="glyphicon glyphicon-rub" aria-hidden="true"></span> за человека?
                                    </div>
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

                                        <a href="#" class="card-schedule-day active">
                                            {{$day}} день <span class="caret"></span>
                                        </a>

                                        <div class="card-schedule-day-desc">
                                            <div class="accommodation-options-day-cont"> {!! $dayDesc!!}</div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="tour-card-text" id="accommodation-options">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                {!!  $textData['rest'] !!}
                            </div>
                        </div>
                        <div class="card-desc">{{$tour->description }}</div>
                    </div>

                    <div class="card-tour-similar">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Похожие туры</div>
                                <div class="search-completed-items mobile-hide">
                                    <div class="search-completed-item">
                                        <div class="search-completed-item-preview">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-7">
                                                <div class="row">
                                                    <div class="search-completed-preview-left">
                                                        <div class="search-completed-item-title">Легендарная Русь 4* -
                                                            очень длинный заголовок очень длинный заголовок
                                                        </div>
                                                        <ul>
                                                            <li>9 городов</li>
                                                            <li>14 экскурсий</li>
                                                            <li>Поездка на 4 дня</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                                                <div class="row">
                                                    <div class="search-completed-preview-right">
                                                        <div class="search-completed-item-price">
                                                            <b>от 8200 <span class="glyphicon glyphicon-rub"
                                                                             aria-hidden="true"></span></b>
                                                            <span>за человека</span>
                                                        </div>
                                                        <a href="#" class="btn btn-orange">Заказать</a>
                                                        <a href="#" class="btn btn-blue">Подробнее</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="search-completed-item-more">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row">
                                                    <a href="#" class="search-completed-item-img">
                                                        <img src="{{asset('/img/search-completed-item-1.jpg')}}" alt="">
                                                        <span>Все фото (18)</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                                <div class="row">
                                                    <div class="search-completed-item-more-right">
                                                        <div class="search-completed-item-route">
                                                            <span>Маршрут тура:</span> <b>Москва</b> - Владимир,
                                                            Боголюбово, Суздаль, Иваново, Кострома, Ярославль, Ростов
                                                            Великий, Переславль Залесский, Сергиев Посад - <b>Москва</b>
                                                        </div>
                                                        <div class="search-completed-item-date">
                                                            <a href="#" class="red">14.12</a>
                                                            <a href="#" class="green">22.12</a>
                                                            <a href="#" class="red">26.12</a>
                                                            <a href="#" class="red">14.12</a>
                                                            <a href="#" class="green">22.12</a>
                                                            <a href="#" class="red">26.12</a>
                                                            <a href="#" class="green">22.12</a>
                                                            <a href="#" class="all-dates">Все даты <b>>>></b></a>
                                                        </div>
                                                        <div class="search-completed-item-desc">
                                                            Великий праздник Пасхи в одном из самых святых уголков
                                                            русской земли! Знакомство со святынями былинного Мурома и
                                                            Светлое Христово Воскресение...
                                                            <a href="#">Подробнее</a>
                                                        </div>
                                                        <div class="search-completed-item-tags">Для детей, Золотое
                                                            кольцо, Новогодние туры
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-completed-item">
                                        <div class="search-completed-item-preview">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-7">
                                                <div class="row">
                                                    <div class="search-completed-preview-left">
                                                        <div class="search-completed-item-title">Легендарная Русь 4* -
                                                            очень длинный заголовок очень длинный заголовок
                                                        </div>
                                                        <ul>
                                                            <li>9 городов</li>
                                                            <li>14 экскурсий</li>
                                                            <li>Поездка на 4 дня</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                                                <div class="row">
                                                    <div class="search-completed-preview-right">
                                                        <div class="search-completed-item-price">
                                                            <b>от 8200 <span class="glyphicon glyphicon-rub"
                                                                             aria-hidden="true"></span></b>
                                                            <span>за человека</span>
                                                        </div>
                                                        <a href="#" class="btn btn-orange">Заказать</a>
                                                        <a href="#" class="btn btn-blue">Подробнее</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="search-completed-item-more">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="row">
                                                    <a href="#" class="search-completed-item-img">
                                                        <img src="{{asset('/img/search-completed-item-1.jpg')}}" alt="">
                                                        <span>Все фото (18)</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                                <div class="row">
                                                    <div class="search-completed-item-more-right">
                                                        <div class="search-completed-item-route">
                                                            <span>Маршрут тура:</span> <b>Москва</b> - Владимир,
                                                            Боголюбово, Суздаль, Иваново, Кострома, Ярославль, Ростов
                                                            Великий, Переславль Залесский, Сергиев Посад - <b>Москва</b>
                                                        </div>
                                                        <div class="search-completed-item-date">
                                                            <a href="#" class="red">14.12</a>
                                                            <a href="#" class="green">22.12</a>
                                                            <a href="#" class="red">26.12</a>
                                                            <a href="#" class="red">14.12</a>
                                                            <a href="#" class="green">22.12</a>
                                                            <a href="#" class="red">26.12</a>
                                                            <a href="#" class="green">22.12</a>
                                                            <a href="#" class="all-dates">Все даты <b>>>></b></a>
                                                        </div>
                                                        <div class="search-completed-item-desc">
                                                            Великий праздник Пасхи в одном из самых святых уголков
                                                            русской земли! Знакомство со святынями былинного Мурома и
                                                            Светлое Христово Воскресение...
                                                            <a href="#">Подробнее</a>
                                                        </div>
                                                        <div class="search-completed-item-tags">Для детей, Золотое
                                                            кольцо, Новогодние туры
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tours-notes">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <h2>Заметки для путешественников по России</h2>
                                <div class="tours-notes-items-wrap">
                                    <div class="tours-notes-items">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="/img/tours-notes-item-1.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="/img/tours-notes-item-2.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="/img/tours-notes-item-3.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="{{asset('img/tours-notes-item-1.jpg')}}" alt="">
                                                    </div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="{{asset('img/tours-notes-item-2.jpg')}}" alt="">
                                                    </div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="{{asset('img/tours-notes-item-3.jpg')}}" alt="">
                                                    </div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="#" class="btn-more-tours">Показать еще больше советов</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="popular-category">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Популярные категории</div>
                                <div class="popular-category-items">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-1.png" alt=""></div>
                                                <span>Русские усадьбы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-2.png" alt=""></div>
                                                <span>Народные промыслы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-3.png" alt=""></div>
                                                <span>Религиозные экскурсии</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-4.png" alt=""></div>
                                                <span>Это интересно детям</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-1.png" alt=""></div>
                                                <span>Русские усадьбы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-2.png" alt=""></div>
                                                <span>Народные промыслы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-3.png" alt=""></div>
                                                <span>Религиозные экскурсии</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="/img/poular-category-item-4.png" alt=""></div>
                                                <span>Это интересно детям</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
@endsection

@section('js')
    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.btn-more-dates').on('click', function(){

            $('.card-tour-dates-item').removeClass('hide');
            $(this).addClass('hide');

            return false;
        });
    </script>
@endsection