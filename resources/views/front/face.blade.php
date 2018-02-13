@extends('layouts.front')

@section('content')

    <div class="wrapper main-page">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="main-page-sliders">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                            <div class="row">
                                <div class="main-slider-left">
                                    <div class="main-slider-left-item">
                                        <img src="img/main-slider-left.jpg" alt="">
                                        <div class="main-slider-left-item-cont">
                                            <span><b>Рождественская сказка близко!</b></span> <br>
                                            <span>Тур в Прагу на Новый год</span> <br>
                                            <span>от <b>18900 р</b> (3 ночи)</span> <br>
                                            <a href="#" class="btn btn-yellow mobile-hide">Посмотреть все предложения</a>
                                            <a href="#" class="btn btn-yellow desk-hide">Все предложения</a>
                                        </div>
                                    </div>
                                    <div class="main-slider-left-item">
                                        <img src="img/main-slider-left.jpg" alt="">
                                        <div class="main-slider-left-item-cont">
                                            <span><b>Рождественская сказка близко!</b></span> <br>
                                            <span>Тур в Прагу на Новый год</span> <br>
                                            <span>от <b>18900 р</b> (3 ночи)</span> <br>
                                            <a href="#" class="btn btn-yellow mobile-hide">Посмотреть все предложения</a>
                                            <a href="#" class="btn btn-yellow desk-hide">Все предложения</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="row">
                                <div class="main-slider-right">
                                    <div class="main-slider-right-item">
                                        <img src="img/main-slider-right.jpg" alt="">
                                        <div class="main-slider-right-item-cont">
                                            <h2>Лето 2018</h2>
                                            <span>Раннее бронирование</span> <br>
                                            <span>уже открыто!</span> <br>
                                            <div>Выбирайте более, чем из 1200 предложений</div>
                                        </div>
                                    </div>
                                    <div class="main-slider-right-item">
                                        <img src="img/main-slider-right.jpg" alt="">
                                        <div class="main-slider-right-item-cont">
                                            <h2>Лето 2018</h2>
                                            <span>Раннее бронирование</span> <br>
                                            <span>уже открыто!</span> <br>
                                            <div>Выбирайте более, чем из 1200 предложений</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tour-filter-tabs">
                        <div class="tour-filter-tabs-menu mobile-hide">
                            <a href="#tour-filter-tab-1" class="current">Быстрый поиск тура</a>
                            <a href="#tour-filter-tab-2">Подбор отеля</a>
                            <a href="#tour-filter-tab-3">Авиабилеты</a>
                        </div>
                        <div class="tour-filter-tabs-menu desk-hide">
                            <a href="#tour-filter-tab-1" class="current">Туры</a>
                            <a href="#tour-filter-tab-2">Отели</a>
                            <a href="#tour-filter-tab-3">Авиа</a>
                        </div>
                        <div class="tour-filter-content">
                            <div id="tour-filter-tab-1">
                                <div class="tour-filter">
                                    <form>
                                        <div class="tour-filter-item tablet-hide">
                                            <label>Страна</label>
                                            <select>
                                                <option>Выберите страну</option>
                                                <option>Страна 1</option>
                                                <option>Страна 2</option>
                                                <option>Страна 3</option>
                                            </select>
                                        </div>
                                        <div class="tour-filter-item desk-hide">
                                            <label>Выберите категорию</label>
                                            <select>
                                                <option>Все варианты</option>
                                                <option>Страна 1</option>
                                                <option>Страна 2</option>
                                                <option>Страна 3</option>
                                            </select>
                                        </div>
                                        <div class="tour-filter-item sight">
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
                                        <div class="tour-filter-item value">
                                            <label>Стоимость</label>
                                            <input type="text" placeholder="от 12000">
                                            <input type="text" placeholder="до 12000000">
                                        </div>
                                        <a href="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>
                                        <a href="#" class="tour-filter-more desk-hide"><span>Показать еще фильтры</span> &#9660;</a>
                                        <a href="#" class="btn other-filter">+ Еще фильтры</a>
                                        <input type="submit" class="btn btn-blue" value="Подобрать варианты">
                                    </form>
                                </div>
                            </div>
                            <div id="tour-filter-tab-2">
                                <div class="tour-filter">
                                    <form>
                                        <div class="tour-filter-item tablet-hide">
                                            <label>Страна</label>
                                            <select>
                                                <option>Выберите страну</option>
                                                <option>Страна 1</option>
                                                <option>Страна 2</option>
                                                <option>Страна 3</option>
                                            </select>
                                        </div>
                                        <div class="tour-filter-item desk-hide">
                                            <label>Выберите категорию</label>
                                            <select>
                                                <option>Все варианты</option>
                                                <option>Страна 1</option>
                                                <option>Страна 2</option>
                                                <option>Страна 3</option>
                                            </select>
                                        </div>
                                        <div class="tour-filter-item sight">
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
                                        <div class="tour-filter-item value">
                                            <label>Стоимость</label>
                                            <input type="text" placeholder="от 12000">
                                            <input type="text" placeholder="до 12000000">
                                        </div>
                                        <a href="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>
                                        <a href="#" class="btn other-filter">+ Еще фильтры</a>
                                        <input type="submit" class="btn btn-blue" value="Подобрать варианты">
                                    </form>
                                </div>
                            </div>
                            <div id="tour-filter-tab-3">
                                <div class="tour-filter">
                                    <form>
                                        <div class="tour-filter-item tablet-hide">
                                            <label>Страна</label>
                                            <select>
                                                <option>Выберите страну</option>
                                                <option>Страна 1</option>
                                                <option>Страна 2</option>
                                                <option>Страна 3</option>
                                            </select>
                                        </div>
                                        <div class="tour-filter-item desk-hide">
                                            <label>Выберите категорию</label>
                                            <select>
                                                <option>Все варианты</option>
                                                <option>Страна 1</option>
                                                <option>Страна 2</option>
                                                <option>Страна 3</option>
                                            </select>
                                        </div>
                                        <div class="tour-filter-item sight">
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
                                        <div class="tour-filter-item value">
                                            <label>Стоимость</label>
                                            <input type="text" placeholder="от 12000">
                                            <input type="text" placeholder="до 12000000">
                                        </div>
                                        <a href="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>
                                        <a href="#" class="btn other-filter">+ Еще фильтры</a>
                                        <input type="submit" class="btn btn-blue" value="Подобрать варианты">
                                    </form>ef="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>
                                    <input type="submit" class="btn btn-blue" value="Подобрать варианты">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="popular-tours">
                        <h1 class="tablet-hide">Самые популярные туры в ноябре из <a href="#">Москвы</a></h1>
                        <h1 class="desk-hide">Самые популярные туры из <a href="#">Москвы</a></h1>
                        <div class="popular-tours-items tablet-hide">
                            <table>
                                <tbody>
                                <tr>
                                    <td rowspan="2">
                                        <a href="#" class="popular-tours-item big">
                                            <img src="img/popular-tours-item-9.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Сочи</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал исключением. Приглашаем посетить удивительную страну противоречий и контрастов, восточную сказку - Азейбарджан!</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-10.jpg" alt="">
                                            <div class="price">от 8900 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Санкт-Петербург</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-11.jpg" alt="">
                                            <div class="price">от 8900 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Тунис</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-12.jpg" alt="">
                                            <div class="price">от 8900 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Азейрбаджан</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-13.jpg" alt="">
                                            <div class="price">от 8900 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Барселона</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <a href="#" class="btn-more-tours">Показать все направления</a>
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
                                            <img src="img/popular-tours-item-14.jpg" alt="">
                                            <span>Лучшие цены на авиабилеты - LetsFly.ru</span> <br>
                                            <span>Проект компании СтарТур</span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="popular-tours-items desk-hide">
                            <table>
                                <tbody>
                                <tr>
                                    <td rowspan="2">
                                        <a href="#" class="popular-tours-item big">
                                            <img src="img/popular-tours-item-1.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Золотое кольцо</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал исключением. Приглашаем посетить удивительную страну противоречий и контрастов, восточную сказку - Азейбарджан!</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-2.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Серебряное кольцо</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-3.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Великий устюг</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-4.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Казань</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-5.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Байкал</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-6.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Святые места</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="popular-tours-item">
                                            <img src="img/popular-tours-item-7.jpg" alt="">
                                            <div class="price">от 3500 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span></div>
                                            <div class="popular-tours-item-cont">
                                                <div class="popular-tours-item-title">Санкт-Петербург</div>
                                                <p>Каждый год мы радуем своих Туристов новыми направлениями и этот год не стал.</p>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
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
                    <div class="burning-tours">
                        <div class="title hot">Горящие туры из <a href="#">Москвы</a></div>
                        <div class="burning-tours-filter-wrap">
                            <div class="burning-tours-filter">
                                <a href="#" class="active">Все направления</a>
                                <a href="#" class="with-flag">Греция</a>
                                <a href="#" class="with-flag">Прага</a>
                                <a href="#" class="with-flag">Тайланд</a>
                                <a href="#" class="with-flag">Тунис</a>
                                <a href="#" class="with-flag">Париж</a>
                                <a href="#" class="with-flag">Доминикана</a>
                            </div>
                            <a href="#" class="btn-more-country"><span>Больше стран</span> ></a>
                        </div>
                        <div class="burning-tours-items-wrap">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="burning-tours-items mobile-hide">
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                                            <div class="row">
                                                <a href="#" class="burning-tours-item">
                                                    <div class="burning-tours-item-img">
                                                        <img src="img/burning-tours-item-2.jpg" alt="">
                                                        <span>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</span>
                                                    </div>
                                                    <div class="burning-tours-item-desc">
                                                        <span>Турция / Аланья</span>
                                                        <b>Kemer Resort & Spa 5*</b>
                                                        <span>Вылет: 10.11 (на 10 ночей)</span>
                                                        <div class="btn btn-orange">Забронировать</div>
                                                        <span class="burning-tours-item-more">Узнать подробнее</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="burning-tours-items-mob desk-hide">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="burning-tours-item">
                                                    <div class="burning-tours-item-desc">
                                                        <div class="burning-item-desc-left">
                                                            <span>Суздаль</span>
                                                            <b>Русь Святая</b>
                                                        </div>
                                                        <div class="burning-item-desc-middle">
                                                            <b>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</b>
                                                            <span>От 10.11 (на 1 день)</span>
                                                        </div>
                                                        <a href="#" class="burning-tours-more-btn"><span>></span></a>
                                                    </div>
                                                </div>
                                                <div class="burning-tours-item">
                                                    <div class="burning-tours-item-desc">
                                                        <div class="burning-item-desc-left">
                                                            <span>Суздаль</span>
                                                            <b>Русь Святая</b>
                                                        </div>
                                                        <div class="burning-item-desc-middle">
                                                            <b>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</b>
                                                            <span>От 10.11 (на 1 день)</span>
                                                        </div>
                                                        <a href="#" class="burning-tours-more-btn"><span>></span></a>
                                                    </div>
                                                </div>
                                                <div class="burning-tours-item">
                                                    <div class="burning-tours-item-desc">
                                                        <div class="burning-item-desc-left">
                                                            <span>Суздаль</span>
                                                            <b>Русь Святая</b>
                                                        </div>
                                                        <div class="burning-item-desc-middle">
                                                            <b>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</b>
                                                            <span>От 10.11 (на 1 день)</span>
                                                        </div>
                                                        <a href="#" class="burning-tours-more-btn"><span>></span></a>
                                                    </div>
                                                </div>
                                                <div class="burning-tours-item">
                                                    <div class="burning-tours-item-desc">
                                                        <div class="burning-item-desc-left">
                                                            <span>Суздаль</span>
                                                            <b>Русь Святая</b>
                                                        </div>
                                                        <div class="burning-item-desc-middle">
                                                            <b>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</b>
                                                            <span>От 10.11 (на 1 день)</span>
                                                        </div>
                                                        <a href="#" class="burning-tours-more-btn"><span>></span></a>
                                                    </div>
                                                </div>
                                                <div class="burning-tours-item">
                                                    <div class="burning-tours-item-desc">
                                                        <div class="burning-item-desc-left">
                                                            <span>Суздаль</span>
                                                            <b>Русь Святая</b>
                                                        </div>
                                                        <div class="burning-item-desc-middle">
                                                            <b>от 19000 <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> / чел.</b>
                                                            <span>От 10.11 (на 1 день)</span>
                                                        </div>
                                                        <a href="#" class="burning-tours-more-btn"><span>></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn-more-tours mobile-hide">Показать еще больше горящих туров</a>
                                    <a href="#" class="btn-more-tours desk-hide">Показать еще</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="popular-category">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title mobile-hide">Не можете определиться со страной?</div>
                                <div class="title desk-hide">Не знаете куда поехать?</div>
                                <div class="subtitle">Выберите одну из категорий, которая Вам ближе по характеру отдыха и мы подберем варианты за 10 секунд!</div>
                                <div class="popular-category-items">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-5.png" alt=""></div>
                                                <span>Пляжный отдых в ноябре</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-6.png" alt=""></div>
                                                <span>На новый год и рождество</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-7.png" alt=""></div>
                                                <span>Горнолыжные курорты</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-8.png" alt=""></div>
                                                <span>Культура и прогулки</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-9.png" alt=""></div>
                                                <span>Отдых в России</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-10.png" alt=""></div>
                                                <span>Активный отдых</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-6.png" alt=""></div>
                                                <span>На новый год и рождество</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-7.png" alt=""></div>
                                                <span>Горнолыжные курорты</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-8.png" alt=""></div>
                                                <span>Культура и прогулки</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                        <div class="row">
                                            <a href="#" class="poular-category-item">
                                                <div class="poular-category-item-img"><img src="img/poular-category-item-9.png" alt=""></div>
                                                <span>Отдых в России</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tours-notes tablet-hide">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="title">Советы для путешественников</div>
                                <div class="tours-notes-items-wrap">
                                    <div class="tours-notes-items">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-4.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-5.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-6.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-3.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-7.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-8.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-9.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <div class="row">
                                                <a href="#" class="tours-notes-item">
                                                    <div class="tours-notes-item-img"><img src="img/tours-notes-item-10.jpg" alt=""></div>
                                                    <div class="tours-notes-item-cont">
                                                        <b>Как не опоздать на поезд?</b>
                                                        <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
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
                    <div class="search-tour-country tablet-hide">
                        <div class="title">Поиск тура по странам</div>
                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                            <div class="row">
                                <ul>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                            <div class="row">
                                <ul>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                            <div class="row">
                                <ul>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                            <div class="row">
                                <ul>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-1-5 col-sm-1-5 col-md-1-5 col-lg-1-5">
                            <div class="row">
                                <ul>
                                    <li class="with-flag"><a href="#">Туры в Чехию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Германию</a></li>
                                    <li class="with-flag"><a href="#">Туры в Польшу</a></li>
                                    <li class="with-flag"><a href="#">Туры в Испанию</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="reviews tablet-hide">
                        <div class="title">Отзывы наших клиентов</div>
                        <div class="subtitle"><a href="#">Вы также можете оставить свой фотоотзыв и получить скидку 7% на следующее бронирование!</a></div>
                        <div class="reviews-slider">
                            <div class="reviews-slider-item">
                                <img src="img/reviews-item-1.png" alt="">
                                <div>Спасибо компании Стартур за организацию отпуска для моей семьи!</div>
                                <div>Ирина Митрофановна, г.Москва</div>
                            </div>
                            <div class="reviews-slider-item">
                                <img src="img/reviews-item-2.png" alt="">
                                <div>Отлично отдохнули, СПАСИБО!!!</div>
                                <div>Иван Иванов, г.Екатеринбург</div>
                            </div>
                            <div class="reviews-slider-item">
                                <img src="img/reviews-item-3.png" alt="">
                                <div>Спасибо компании Стартур за организацию отпуска для моей семьи!</div>
                                <div>Ирина Митрофановна, г.Москва</div>
                            </div>
                            <div class="reviews-slider-item">
                                <img src="img/reviews-item-2.png" alt="">
                                <div>Отлично отдохнули, СПАСИБО!!!</div>
                                <div>Иван Иванов, г.Екатеринбург</div>
                            </div>
                        </div>
                        <a href="#" class="btn-more-tours">Показать больше отзывов</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tours-notes desk-hide">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <h2>Заметки для путешественников по России</h2>
                    <div class="tours-notes-items-wrap">
                        <div class="tours-notes-items">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item">
                                        <div class="tours-notes-item-img"><img src="img/tours-notes-item-1.jpg" alt=""></div>
                                        <div class="tours-notes-item-cont">
                                            <b>Как не опоздать на поезд?</b>
                                            <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item">
                                        <div class="tours-notes-item-img"><img src="img/tours-notes-item-2.jpg" alt=""></div>
                                        <div class="tours-notes-item-cont">
                                            <b>Как не опоздать на поезд?</b>
                                            <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item">
                                        <div class="tours-notes-item-img"><img src="img/tours-notes-item-3.jpg" alt=""></div>
                                        <div class="tours-notes-item-cont">
                                            <b>Как не опоздать на поезд?</b>
                                            <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item">
                                        <div class="tours-notes-item-img"><img src="img/tours-notes-item-1.jpg" alt=""></div>
                                        <div class="tours-notes-item-cont">
                                            <b>Как не опоздать на поезд?</b>
                                            <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item">
                                        <div class="tours-notes-item-img"><img src="img/tours-notes-item-2.jpg" alt=""></div>
                                        <div class="tours-notes-item-cont">
                                            <b>Как не опоздать на поезд?</b>
                                            <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item">
                                        <div class="tours-notes-item-img"><img src="img/tours-notes-item-3.jpg" alt=""></div>
                                        <div class="tours-notes-item-cont">
                                            <b>Как не опоздать на поезд?</b>
                                            <p>В этой статье мы поделимся с Вами секретом о том, как быстро собраться в дорогу</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item no-img">
                                        <div class="tours-notes-item-cont">
                                            <b>Еще одна интерестная заметка</b>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item no-img">
                                        <div class="tours-notes-item-cont">
                                            <b>Выбираем отель в Российской глубинке сами...</b>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item no-img">
                                        <div class="tours-notes-item-cont">
                                            <b>Нормы провоза багажа</b>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row">
                                    <a href="#" class="tours-notes-item no-img">
                                        <div class="tours-notes-item-cont">
                                            <b>Советы новичкам</b>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn-more-tours mobile-hide">Показать еще больше советов</a>
                        <a href="#" class="btn-more-tours desk-hide">Показать еще</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="popular-category desk-hide">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="title">Популярные категории</div>
                    <div class="popular-category-items">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-1.png" alt=""></div>
                                    <span>Русские усадьбы</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-2.png" alt=""></div>
                                    <span>Народные промыслы</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-3.png" alt=""></div>
                                    <span>Религиозные экскурсии</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-4.png" alt=""></div>
                                    <span>Это интересно детям</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-1.png" alt=""></div>
                                    <span>Русские усадьбы</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-2.png" alt=""></div>
                                    <span>Народные промыслы</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-3.png" alt=""></div>
                                    <span>Религиозные экскурсии</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="row">
                                <a href="#" class="poular-category-item">
                                    <div class="poular-category-item-img"><img src="img/poular-category-item-4.png" alt=""></div>
                                    <span>Это интересно детям</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar-wrap desk-hide">
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
            <div class="sidebar-notice">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat voluptatum eos harum officiis laborum reiciendis architecto ad iste eligendi, corrupti porro, similique perferendis facilis! Excepturi odit quas repellendus tempora, repellat.</div>
        </div>
        <div class="seo-txt desk-hide">
            <h2>SEO текст для раздела о России</h2>
            <p>Золотое Кольцо России - это маршрут, раскрывающий красоту древней Руси, который был разработан для тех, кто желает познакомиться с нашей страной. Это настоящая энциклопедия архитектурных ценностей. В туры по Золотому кольцу входят путешествия по восьми основным городам Российской Федерации: Владимир, Суздаль, Сергиев Посад, Переславль-Залесский, Ростов Великий, Ярославль, Кострома, Иваново.</p>
            <div class="seo-txt-more">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit expedita nemo voluptatibus nesciunt blanditiis totam, aut, quod optio quisquam, quia minus eligendi. Blanditiis minus, facilis assumenda molestiae fuga adipisci mollitia.</div>
            <a href="#" class="seo-txt-btn">Больше информации</a>
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
                            <p>"СтарТур" - одно из популярных туристических агенств, ежедневно помогающее людям в подборе и бронировании туров, авиабилетов, трансферов, экскурсий и круизов. В месяц мы обслуживаем свыше 4000 клиентов.</p>
                            <p>Наша главная задача - сэкономить ваши деньги и обеспечить вас наилучшим отдыхом.</p>
                            <p><b>За 14 лет плодотворной работы мы смогли:</b></p>
                            <ul>
                                <li>Накопить свыше 500 корпоративных клиентов;</li>
                                <li>Принять в штат 40 сотрудников;</li>
                                <li>Заполучить более сотни партнеров в России и Европе.</li>
                            </ul>
                            <p>Мы с первого дня совершенствуемся, накапливаем опыт и принимаем активное участие в различных мероприятиях. Наши дипломы и награды говорят о наших достижениях и высоком качестве предоставлямых услуг.</p>
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
                                <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">Адрес: Россия, <span itemprop="addressLocality">г.Москва</span>, <span itemprop="streetAddress">ул. Кузнецкий Мост, д. 21/5</span>
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

@endsection