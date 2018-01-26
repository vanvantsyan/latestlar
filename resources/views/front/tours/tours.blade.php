@extends('layouts.front')

@section('css')
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
    <div class="wrapper tours-list-page">
        <div class="container">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="row">
                    <div class="sidebar-wrap">
                        <div class="sidebar">
                            <div class="sidebar-city-tour">
                                <div class="sidebar-tour-title">Туры по России</div>
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
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <div class="row">
                    <div class="tour-preview-wrap">
                        <div class="tour-preview">
                            <h2>Россия</h2>
                            <div class="tour-preview-desc">Компания Star Tour предлагает лучшие туры по России. Только
                                самые интересные и проверенные маршруты!
                            </div>
                            <a href="#" class="btn btn-yellow">Отправить заявку на подбор тура</a>
                        </div>
                    </div>
                    <div class="tour-filter">
                        <form>
                            <div class="tour-filter-item">
                                <label>Город или достопримечательность</label>
                                <input type="text" placeholder="Красная площадь">
                            </div>
                            <div class="tour-filter-item date-mob">
                                <label>Даты поездки <span>?</span></label>
                                <input class="date-pick dp-applied">
                            </div>
                            <div class="tour-filter-item time-mob">
                                <label>Срок поездки (дни)</label>
                                <select>
                                    <option>от 7</option>
                                    <option>от 8</option>
                                    <option>от 9</option>
                                    <option>от 10</option>
                                </select>
                                <select>
                                    <option>до 7</option>
                                    <option>до 8</option>
                                    <option>до 9</option>
                                    <option>до 10</option>
                                </select>
                            </div>
                            <div class="tour-filter-item category">
                                <label>Категория тура</label>
                                <select>
                                    <option>Все варианты</option>
                                    <option>Категория 1</option>
                                    <option>Категория 2</option>
                                    <option>Категория 3</option>
                                </select>
                            </div>
                            <div class="tour-filter-item value">
                                <label>Стоимость</label>
                                <input type="text" placeholder="от 12000">
                                <input type="text" placeholder="до 12000000">
                            </div>
                            <a href="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>
                            <input type="submit" class="btn btn-blue" value="Подобрать варианты">
                        </form>
                    </div>
                    <div class="search-completed">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Туры по Золотому кольцу из г. Москва, найдено: 18</div>
                                <a href="#" class="btn sorting-btn">Кратко</a>
                                <div class="tours-sorting">
                                    Сортировать по: <a href="#"><span>Стоимости тура (от большей к меньшей)</span>
                                        <b></b></a>
                                    <div class="tours-sorting-items">
                                        <a href="#">Стоимости тура (от меньшей к большей)</a>
                                        <a href="#">Стоимости тура (от меньшей к большей) 2</a>
                                        <a href="#">Стоимости тура (от меньшей к большей) 3</a>
                                    </div>
                                </div>
                                <div class="search-completed-items">


                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $half = ceil($tours->count() / 2);
                        $toursParts = $tours->chunk($half);
                    @endphp
                    <div class="search-completed-items">

                        @foreach($toursParts[0] as $tour)
                            <div class="search-completed-item">
                                <div class="search-completed-item-preview">
                                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                        <div class="row">
                                            <div class="search-completed-preview-left">
                                                <div class="search-completed-item-title">{{$tour->title}}</div>
                                                <ul>
                                                    <li>{{$tour->cityCount ?: 1}} {!! Gliss::numeralCase('город', $tour->cityCount ?: 1) !!}</li>
                                                    <li>14 экскурсий</li>
                                                    <li>Поездка
                                                        на {{$tour->duration}} {!! Gliss::numeralCase('день', $tour->duration) !!}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                        <div class="row">
                                            <div class="search-completed-preview-right">
                                                <div class="search-completed-item-price">
                                                    @if($tour->price > 0)
                                                        <b>от {{number_format($tour->price, 0, '.',' ') }}
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
                                            <div class="search-completed-item-img">
                                                @php
                                                    $images = json_decode($tour->images);
                                                @endphp
                                                @if(count($images))
                                                    <img src="/img/tours/full/{!! substr($tour->id, 0,2) !!}/{{$images[0]}}"
                                                         alt="">
                                                @else
                                                    <img src="img/search-completed-item-1.jpg" alt="">
                                                @endif
                                                @if(count($images))
                                                    <span class="tour-images-button" data-images="{{$tour->images}}"
                                                          data-tour-id="{{$tour->id}}" data-toggle="modal"
                                                          data-target="#tourImagesModal">Все фото ({{count($images)}}
                                                        )</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                        <div class="row">
                                            <div class="search-completed-item-more-right">
                                                <div class="search-completed-item-route">
                                                    <span>Маршрут тура:</span>

                                                    @if($tour->points->count())

                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($tour->points as $point)
                                                            {{$i < $tour->points->count() ? $point->point->title . ', ' : $point->point->title}}
                                                            @php $i++ @endphp
                                                        @endforeach
                                                        {{--<b>Москва</b> - Владимир, Боголюбово, Суздаль, Иваново, Кострома,--}}
                                                        {{--Ярославль, Ростов Великий, Переславль Залесский, Сергиев Посад - <b>Москва</b>--}}

                                                    @else
                                                        {{$tour->ways[0]->waysPar->title}}
                                                    @endif
                                                </div>
                                                <div class="search-completed-item-date">
                                                    @php $num = 0; @endphp

                                                    @foreach($tour->dates as $date)
                                                        @if ($num > 5)
                                                            @break
                                                        @endif
                                                        <a href="#" class="green">
                                                            {{Carbon\Carbon::createFromTimestamp($date->value)->format('d.m')}}
                                                        </a>

                                                        @php $num++; @endphp
                                                    @endforeach

                                                    @if($tour->dates->count() > 6)
                                                        <a href="#" class="all-dates">Все даты <b>>>></b></a>
                                                    @endif
                                                </div>

                                                <div class="search-completed-item-desc">
                                                    {!! Str::words($tour->description, 17,'...') !!}
                                                    <a href="#">Подробнее</a>
                                                </div>

                                                <div class="search-completed-item-tags">Для детей, Золотое кольцо,
                                                    Новогодние туры
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="popular-tours">
                        <div class="popular-tours-items">
                            <table>
                                <tbody>
                                <tr>
                                    <td style="background-color: #007cbc;">
                                        <div class="popular-tours-item small">
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
                                            <span>Бронируйте он-лайн <br> через СтарТур!</span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="search-completed-items">

                        @foreach($toursParts[1] as $tour)
                            <div class="search-completed-item">
                                <div class="search-completed-item-preview">
                                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                        <div class="row">
                                            <div class="search-completed-preview-left">
                                                <div class="search-completed-item-title">{{$tour->title}}</div>
                                                <ul>
                                                    <li>{{$tour->cityCount ?: 1}} {!! Gliss::numeralCase('город', $tour->cityCount ?: 1) !!}</li>
                                                    <li>14 экскурсий</li>
                                                    <li>Поездка
                                                        на {{$tour->duration}} {!! Gliss::numeralCase('день', $tour->duration) !!}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                        <div class="row">
                                            <div class="search-completed-preview-right">
                                                <div class="search-completed-item-price">
                                                    @if($tour->price > 0)
                                                        <b>от {{number_format($tour->price, 0, '.',' ') }}
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
                                            <div class="search-completed-item-img">
                                                @php
                                                    $images = json_decode($tour->images);
                                                @endphp
                                                @if(count($images))
                                                    <img src="/img/tours/full/{!! substr($tour->id, 0,2) !!}/{{$images[0]}}"
                                                         alt="">
                                                @else
                                                    <img src="img/search-completed-item-1.jpg" alt="">
                                                @endif
                                                @if(count($images))
                                                    <span class="tour-images-button" data-images="{{$tour->images}}"
                                                          data-tour-id="{{$tour->id}}" data-toggle="modal"
                                                          data-target="#tourImagesModal">Все фото ({{count($images)}}
                                                        )</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                        <div class="row">
                                            <div class="search-completed-item-more-right">
                                                <div class="search-completed-item-route">
                                                    <span>Маршрут тура:</span>

                                                    @if($tour->points->count())

                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach($tour->points as $point)
                                                            {{$i < $tour->points->count() ? $point->point->title . ', ' : $point->point->title}}
                                                            @php $i++ @endphp
                                                        @endforeach
                                                        {{--<b>Москва</b> - Владимир, Боголюбово, Суздаль, Иваново, Кострома,--}}
                                                        {{--Ярославль, Ростов Великий, Переславль Залесский, Сергиев Посад - <b>Москва</b>--}}

                                                    @else
                                                        {{$tour->ways[0]->waysPar->title}}
                                                    @endif
                                                </div>
                                                <div class="search-completed-item-date">
                                                    @php $num = 0; @endphp

                                                    @foreach($tour->dates as $date)
                                                        @if ($num > 5)
                                                            @break
                                                        @endif
                                                        <a href="#" class="green">
                                                            {{Carbon\Carbon::createFromTimestamp($date->value)->format('d.m')}}
                                                        </a>

                                                        @php $num++; @endphp
                                                    @endforeach

                                                    @if($tour->dates->count() > 6)
                                                        <a href="#" class="all-dates">Все даты <b>>>></b></a>
                                                    @endif
                                                </div>

                                                <div class="search-completed-item-desc">
                                                    {!! Str::words($tour->description, 17,'...') !!}
                                                    <a href="#">Подробнее</a>
                                                </div>

                                                <div class="search-completed-item-tags">Для детей, Золотое кольцо,
                                                    Новогодние туры
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <a href="#" class="btn-more-tours">Показать еще туры</a>
                    </div>

                    <div class="tours-notes">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Заметки для путешественников по России</div>
                                <div class="tours-notes-items-wrap">
                                    <div class="tours-notes-items">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="img/tours-notes-item-1.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="img/tours-notes-item-2.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="img/tours-notes-item-3.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="img/tours-notes-item-1.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="img/tours-notes-item-2.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро
                                                            собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img
                                                                src="img/tours-notes-item-3.jpg" alt=""></div>
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
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-1.png" alt=""></div>
                                                <span>Русские усадьбы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-2.png" alt=""></div>
                                                <span>Народные промыслы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-3.png" alt=""></div>
                                                <span>Религиозные экскурсии</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-4.png" alt=""></div>
                                                <span>Это интересно детям</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-1.png" alt=""></div>
                                                <span>Русские усадьбы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-2.png" alt=""></div>
                                                <span>Народные промыслы</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-3.png" alt=""></div>
                                                <span>Религиозные экскурсии</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img
                                                            src="img/poular-category-item-4.png" alt=""></div>
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
                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                    <div class="row">
                        <div class="about-company">
                            <h3>Информация о компании</h3>
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
                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                    <div class="row">
                        <div class="news-company">
                            <h3>Новости компании</h3>
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
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="img/partners-item-1.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="img/partners-item-2.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="img/partners-item-3.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="img/partners-item-4.jpg" alt=""></div>
                        </div>
                    </div>
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="partners-item"><img src="img/partners-item-5.jpg" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sitemap">
            <div class="container">
                <div class="sitemap-items">
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
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
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
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
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
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
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
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
                    <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                        <div class="row">
                            <div class="sitemap-item">
                                <div class="phone">
                                    <span>+7 (499) <b>490-44-12</b></span>
                                    <span>+7 (800) <b>770-06-22</b></span>
                                </div>
                                <a href="#" class="mail">travel@startour.ru</a>
                                <p>Адрес: Россия, г.Москва, ул. Кузнецкий Мост, д. 21/5 <br> 1 подъезд</p>
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

    <!-- Modal tour images-->
    <div class="modal fade" id="tourImagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Изображения тура</h4>
                </div>
                <div class="modal-body">
                    <div id="tourImagesCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators"></ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner"></div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#tourImagesCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#tourImagesCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
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
        })

    </script>
@endsection