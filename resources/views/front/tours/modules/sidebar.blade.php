<div class="sidebar-wrap">
    <div class="sidebar">
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Категории туров</div>
            <ul>
                @if($layer == 3)
                    {{--<li><a class="march-icon" href="/{{$level}}/8-marta">Туры на 8 марта</a></li>--}}
                    @if($countTours = Gliss::countTours("/$level/mayskie-prazdniki"))
                        <li>
                            <a class="may-icon" href="/{{$level}}/mayskie-prazdniki">На майские праздники</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    {{--<li><a href="/{{$level}}/vip">ВИП туры</a></li>--}}
                @else

                    {{--<li><a class="march-icon"--}}
                    {{--href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}8-marta{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">Туры--}}
                    {{--на 8 марта</a></li>--}}
                    @if($countTours = Gliss::countTours(
                    "/$level/" . (($tag && $tag->tag->title == "status") ? $tag->value . "/" : "") . ($way ? "tury-" . $way->url ."/" : "") . (($point) ? "tury-" . $point->url ."/" : "") . "mayskie-prazdniki" . (($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : '') . ($duration ? "/". $duration : "") . "/"
                    ))
                        <li>
                            <a class="may-icon"
                               href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}mayskie-prazdniki{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">
                                На майские праздники</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    {{--<li><a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}vip{{($tag && in_array($tag->tag->title, ["holiday", "tour_type"])) ? "/" . $tag->value : ''}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">ВИП туры</a></li>--}}
                @endif

                @if(in_array($level, ['russia','tury']))
                    @if($countTours = Gliss::countTours("/russia/tury-zolotoe-kolczo"))
                        <li>
                            <a href="/{{$level}}/tury-zolotoe-kolczo">Золотое кольцо</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    @if($countTours = Gliss::countTours("/russia/tury-sankt-peterburg-i-leningradskaya-oblast"))
                        <li>
                            <a href="/russia/tury-sankt-peterburg-i-leningradskaya-oblast">Санкт-Петербург</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    @if($countTours = Gliss::countTours("/russia/tury-altaj"))
                        <li>
                            <a href="/russia/tury-altaj">Алтай</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    @if($countTours = Gliss::countTours("/russia/tury-bajkal"))
                        <li>
                            <a href="/russia/tury-bajkal">Байкал</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    @if($countTours = Gliss::countTours("/russia/tury-kamchatka"))
                        <li>
                            <a href="/russia/tury-kamchatka">Камчатка</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    @if($countTours = Gliss::countTours("/russia/tury-sochi-i-krasnodarskij-kraj"))
                        <li>
                            <a href="/russia/tury-sochi-i-krasnodarskij-kraj">Сочи и Кавказ</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    @if($countTours = Gliss::countTours("/russia/tury-kryim"))
                        <li>
                            <a href="/russia/tury-kryim">Крым</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                @endif

                <li><a href="/{{$level}}/na-1-den">Однодневные
                        туры</a><span>{{Gliss::countTours("/$level/na-1-den")}}</span></li>
                <li><a href="/{{$level}}/">Многодневные туры</a><span>{{Gliss::countTours("/$level")}}</span></li>
            </ul>
        </div>
        @if(in_array($level, ['russia','tury']))
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">Города России</div>
                <ul>
                    {{--@forelse($cities as $city)--}}
                    {{--@if($layer == 3)--}}
                    {{--<li><a href="/{{$level}}/tury-{{$city->url}}">Туры в {{Gliss::case($city->title, "П")}}</a></li>--}}
                    {{--@else--}}
                    {{--<li>--}}
                    {{--<a href="/{{$level}}/tury-{{$city->url}}{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры--}}
                    {{--в {{Gliss::case($city->title, "П")}}</a>--}}
                    {{--</li>--}}
                    {{--@endif--}}
                    {{--@if($loop->iteration == 4)--}}
                    {{--@break--}}
                    {{--@endif--}}
                    {{--@empty--}}
                    @if($layer == 3)
                        @if($countTours = Gliss::countTours("/russia/tury-moskva"))
                            <li>
                                <a href="/russia/tury-moskva">Туры в Москве</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-sankt-peterburg"))
                            <li>
                                <a href="/russia/tury-sankt-peterburg">Туры в Санкт-Петербурге</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-ekaterinburg"))
                            <li>
                                <a href="/russia/tury-ekaterinburg">Туры в Екатеринбурге</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-kazani"))
                            <li>
                                <a href="/russia/tury-kazani">Туры в Казани</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-sochi"))
                            <li>
                                <a href="/russia/tury-sochi">Туры в Сочи</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                    @else
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-moskva", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-moskva", $tag, $month, $duration)}}">Туры
                                    в Москве</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-sankt-peterburg", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-sankt-peterburg", $tag, $month, $duration)}}">Туры
                                    в Санкт-Петербурге</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-ekaterinburg", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-ekaterinburg", $tag, $month, $duration)}}">Туры
                                    в Екатеринбурге</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-kazani", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-kazani", $tag, $month, $duration)}}">Туры
                                    в Казани</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-sochi", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-sochi", $tag, $month, $duration)}}">Туры
                                    в
                                    Сочи</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                    @endif
                    {{--<li><a href="#">Города не выбраны</a></li>--}}
                    {{--@endforelse--}}
                </ul>
                <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourCitiesModal">Другие города</a>
            </div>
        @endif

        @if(in_array($level, ['russia','tury']))
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">Туры по золотому кольцу</div>
                <ul>
                    {{--@forelse($citiesGolden as $city)--}}
                    {{--@if($layer == 3)--}}
                    {{--<li><a href="/{{$level}}/tury-{{$city->url}}">Туры в {{Gliss::case($city->title, "П")}}</a></li>--}}
                    {{--@else--}}
                    {{--<li>--}}
                    {{--<a href="/{{$level}}/tury-{{$city->url}}{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры--}}
                    {{--в {{Gliss::case($city->title, "П")}}</a>--}}
                    {{--</li>--}}
                    {{--@endif--}}

                    {{--@if($loop->iteration == 4)--}}
                    {{--@break--}}
                    {{--@endif--}}
                    {{--@empty--}}
                    {{--<li><a href="#">Города не выбраны</a></li>--}}
                    {{--@endforelse--}}

                    @if($layer == 3)
                        @if($countTours = Gliss::countTours("/russia/tury-moskva"))
                        <li>
                            <a href="/russia/tury-vladimir">Туры в Владимире</a>
                            <span>{{Gliss::countTours('/russia/tury-vladimir')}}</span>
                        </li>
                        @endif
                        <li><a href="/russia/tury-rostov-velikiy">Туры в Ростове
                                Великом</a><span>{{Gliss::countTours('/russia/tury-rostov-velikiy')}}</span></li>
                        <li><a href="/russia/tury-sergiev-posad">Туры в Сергиевом
                                Посаде</a><span>{{Gliss::countTours('/russia/tury-sergiev-posad')}}</span></li>
                        <li><a href="/russia/tury-suzdal">Туры в
                                Суздале</a><span>{{Gliss::countTours('/russia/tury-suzdal')}}</span></li>
                        <li><a href="/russia/tury-yaroslavl">Туры в
                                Ярославле</a><span>{{Gliss::countTours('/russia/tury-yaroslavl')}}</span></li>
                    @else
                        <li>
                            <a href="{{Gliss::generatedCityLink("/russia/tury-vladimir", $tag, $month, $duration)}}">Туры
                                во Владимире</a>
                            <span>{{Gliss::countTours(Gliss::generatedCityLink("/russia/tury-vladimir", $tag, $month, $duration))}}</span>
                        </li>
                        <li>
                            <a href="{{Gliss::generatedCityLink("/russia/tury-rostov-velikiy", $tag, $month, $duration)}}">Туры
                                в Ростове Великом</a>
                            <span>{{Gliss::countTours(Gliss::generatedCityLink("/russia/tury-rostov-velikiy", $tag, $month, $duration))}}</span>
                        </li>
                        <li>
                            <a href="{{Gliss::generatedCityLink("/russia/tury-sergiev-posad", $tag, $month, $duration)}}">Туры
                                в Сергиевом Посаде</a>
                            <span>{{Gliss::countTours(Gliss::generatedCityLink("/russia/tury-sergiev-posad", $tag, $month, $duration))}}</span>
                        </li>
                        <li>
                            <a href="{{Gliss::generatedCityLink("/russia/tury-suzdal", $tag, $month, $duration)}}">Туры
                                в Суздале</a>
                            <span>{{Gliss::countTours(Gliss::generatedCityLink("/russia/tury-suzdal", $tag, $month, $duration))}}</span>
                        </li>
                        <li>
                            <a href="{{Gliss::generatedCityLink("/russia/tury-yaroslavl", $tag, $month, $duration)}}">Туры
                                в Ярославле</a>
                            <span>{{Gliss::countTours(Gliss::generatedCityLink("/russia/tury-yaroslavl", $tag, $month, $duration))}}</span>
                        </li>

                    @endif
                </ul>
                <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourGoldensModal">Другие города</a>
            </div>
        @endif

        @if($tag or $way or $point or !$country or $duration)
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">Туры по месяцам</div>
                <ul>
                    @forelse(config('main.month') as $key => $value)
                        @if(in_array($key, ['january', 'february']))
                            @continue
                        @endif
                        @if($layer == 3)
                            <li>
                                <a href="/{{$level}}/{{$key}}">{{$value}}</a>
                                <span>{{Gliss::countTours("/$level/$key")}}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{Gliss::generatedMonthLink($level, $way, $point, $tag,$key,$duration)}}">{{$value}}</a>
                                <span>{{Gliss::countTours(Gliss::generatedMonthLink($level, $way, $point, $tag,$key,$duration))}}</span>
                            </li>
                        @endif

                        @if($loop->iteration == 8)
                            @break
                        @endif
                    @empty
                    @endforelse
                </ul>
            </div>
        @endif
        @if($country or $tag or $month)
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">Туры по длительности</div>
                <ul class="restType">
                    @foreach(config('main.duration') as $key => $value)

                        @if($layer == 3)

                            @php
                                $link = "/$level/na-$key";
                            @endphp
                            @if($countLinkTours = Gliss::countTours($link))
                                <li>
                                    <a href="/{{$level}}/na-{{$key}}">{{$value}}</a>
                                    <span>{{$countLinkTours}}</span>
                                </li>
                            @endif

                        @else

                            @php
                                $link = Gliss::generatedDurationLink($level,$month, $way, $point, $tag, $key);
                            @endphp

                            @if($countLinkTours = Gliss::countTours($link))
                                <li>
                                    <a href="{{$link}}">{{$value}}</a>
                                    <span>{{$countLinkTours}}</span>
                                </li>
                            @endif

                        @endif

                    @endforeach
                </ul>
            </div>
        @endif
        @if(count($tourTypes))
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-title">Виды отдыха</div>
                <ul>
                    @forelse($tourTypes as $type)
                        @if($layer == 3)

                            @php
                                $link = "/$level/$type->value";
                            @endphp

                            @if($countLinkTours = Gliss::countTours($link))
                                <li>
                                    <a href="{{$link}}">{{$type->alias}}</a>
                                    <span>{{$countLinkTours}}</span>
                                </li>
                            @endif
                        @else
                            @php
                                $link = Gliss::generatedTypeLink($level,$way, $point, $tag, $type);
                            @endphp

                            @if($countLinkTours = Gliss::countTours($link))
                                <li>
                                    <a href="{{$link}}">{{$type->alias}}</a>
                                    <span>{{$countLinkTours}}</span>
                                </li>
                            @endif
                        @endif

                        @if($loop->iteration == 5)
                            @break
                        @endif
                    @empty
                        <li><a href="#">Нет видов отдыха</a></li>
                    @endforelse
                </ul>

                @if(count($tourTypes) > 5)
                    <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourTypesModal">Все типы</a>
                @endif
            </div>
        @endif

        @if(count($tourTypes))
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-title">Типы туров</div>
                <ul>
                    @forelse($tourTypes as $type)

                        @if($loop->iteration == 11)
                            @break
                        @endif

                        @if($loop->iteration > 5)
                            @if($layer == 3)
                                @php
                                    $link = "/$level/$type->value";
                                @endphp

                                @if($countLinkTours = Gliss::countTours($link))
                                    <li>
                                        <a href="{{$link}}">{{$type->alias}}</a>
                                        <span>{{$countLinkTours}}</span>
                                    </li>
                                @endif
                            @else
                                @php
                                    $link = Gliss::generatedTypeLink($level,$way, $point, $tag, $type);
                                @endphp

                                @if($countLinkTours = Gliss::countTours($link))
                                    <li>
                                        <a href="{{$link}}">{{$type->alias}}</a>
                                        <span>{{$countLinkTours}}</span>
                                    </li>
                                @endif
                            @endif
                        @endif
                    @empty
                        <li><a href="#">Нет видов отдыха</a></li>
                    @endforelse
                </ul>
                @if(count($tourTypes) > 5)
                    <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourTypesModal">Показать
                        остальные
                        типы</a>
                @endif
            </div>
        @endif

        @if(count($countries))
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-title">Другие страны</div>
                <ul>
                    @forelse($countries as $country)
                        <li class="with-flag">
                            @php
                                $images = json_decode($country->country->images);
                            @endphp

                            {{--<a href="/{{$country->url}}{{$tag ? "/" . $tag->value : ""}}{{$month ? "/" . $month : ""}}">--}}
                            <a href="/{{$country->url}}{{$month ? "/" . $month : ""}}">
                                @if($country->country->flag)
                                    <img width="15" src="/uploads/countries/flags/{{$country->country->flag}}"/>
                                @endif
                                Туры в {{Gliss::case($country->title, "П")}}
                            </a>
                            <span>{{$country->country->count_tours}}</span>
                        </li>
                        @if($loop->iteration == 5)
                            @break
                        @endif
                    @empty
                        <li><a href="#">Нет стран</a></li>
                    @endforelse
                </ul>
                @if(count($countries))
                    <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#countriesModal">Все страны</a>
                @endif
            </div>
        @endif
    </div>
    <div class="sidebar-notice">{!!$subText!!}</div>
</div>