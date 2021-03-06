<div class="sidebar-wrap">
    <div class="sidebar">
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Категории туров</div>
            <ul>

                @if($layer == 3)
                    {{--<li><a class="march-icon" href="/{{$level}}/8-marta">Туры на 8 марта</a></li>--}}
                    {{--
                    @if($countTours = Gliss::countTours("/$level/iyunskie-prazdniki"))
                        <li>
                            <a class="may-icon" href="/{{$level}}/iyunskie-prazdniki">На июньские праздники</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    --}}
                    {{--<li><a href="/{{$level}}/vip">ВИП туры</a></li>--}}
                @else
                    {{--<li><a class="march-icon"--}}
                    {{--href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}8-marta{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">Туры--}}
                    {{--на 8 марта</a></li>--}}
                    {{-- 
                    @if($countTours = Gliss::countTours(
                    "/$level/" . (($tag && $tag->tag->title == "status") ? $tag->value . "/" : "") . ($way ? "tury-" . $way->url ."/" : "") . (($point) ? "tury-" . $point->url ."/" : "") . "iyunskie-prazdniki" . (($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : '') . ($duration ? "/". $duration : "") . "/"
                    ))
                        <li>
                            <a class="may-icon"
                               href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}iyunskie-prazdniki{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">
                                На июньские праздники</a>
                            <span>{{$countTours}}</span>
                        </li>
                    @endif
                    --}}
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
                @if(Gliss::countTours("/$level/na-1-den"))
                    <li><a href="/{{$level}}/na-1-den">Однодневные
                            туры</a><span>{{Gliss::countTours("/$level/na-1-den")}}</span></li>
                @endif
                @if(Gliss::countTours("/$level"))
                    <li><a href="/{{$level}}/">Многодневные туры</a><span>{{Gliss::countTours("/$level")}}</span></li>
                @endif
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
                                <a href="/russia/tury-moskva">Туры по Москве</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-sankt-peterburg"))
                            <li>
                                <a href="/russia/tury-sankt-peterburg">Туры в Санкт-Петербург</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-ekaterinburg"))
                            <li>
                                <a href="/russia/tury-ekaterinburg">Туры в Екатеринбург</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-kazani"))
                            <li>
                                <a href="/russia/tury-kazan">Туры в Казань</a>
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
                                    по Москве</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-sankt-peterburg", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-sankt-peterburg", $tag, $month, $duration)}}">Туры
                                    в Санкт-Петербург</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-ekaterinburg", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-ekaterinburg", $tag, $month, $duration)}}">Туры
                                    в Екатеринбург</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-kazani", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-kazani", $tag, $month, $duration)}}">Туры
                                    в Казань</a>
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
                        @if($countTours = Gliss::countTours("/russia/tury-yaroslavl"))
                            <li>
                                <a href="/russia/tury-yaroslavl">Туры в Ярославль</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-rostov-velikiy"))
                            <li>
                                <a href="/russia/tury-rostov-velikiy">Туры в Ростов Великий</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-pereslavl-zalesskiy"))
                            <li>
                                <a href="/russia/tury-pereslavl-zalesskiy">Туры в Переславль-Залесский</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-sergiev-posad"))
                            <li>
                                <a href="/russia/tury-sergiev-posad">Туры в Сергиев Посад</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-vladimir"))
                            <li>
                                <a href="/russia/tury-vladimir">Туры в Владимир</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-suzdal"))
                            <li>
                                <a href="/russia/tury-suzdal">Туры в Суздаль</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-ivanovo"))
                            <li>
                                <a href="/russia/tury-ivanovo">Туры в Иваново</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours("/russia/tury-kostroma"))
                            <li>
                                <a href="/russia/tury-kostroma">Туры в Кострому</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                    @else
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-yaroslavl", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-yaroslavl", $tag, $month, $duration)}}">Туры
                                    в Ярославль</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-rostov-velikiy", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-rostov-velikiy", $tag, $month, $duration)}}">Туры
                                    в Ростов Великий</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-pereslavl-zalesskiy", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-pereslavl-zalesskiy", $tag, $month, $duration)}}">Туры
                                    в Переславль-Залесский</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-sergiev-posad", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-sergiev-posad", $tag, $month, $duration)}}">Туры
                                    в Сергиев Посад</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-vladimir", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-vladimir", $tag, $month, $duration)}}">Туры
                                    во Владимир</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-suzdal", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-suzdal", $tag, $month, $duration)}}">Туры
                                    в Суздаль</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-ivanovo", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-ivanovo", $tag, $month, $duration)}}">Туры
                                    в Иваново</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        @if($countTours = Gliss::countTours(Gliss::generatedCityLink("/russia/tury-kostroma", $tag, $month, $duration)))
                            <li>
                                <a href="{{Gliss::generatedCityLink("/russia/tury-kostroma", $tag, $month, $duration)}}">Туры
                                    в Кострому</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        @endif

        @if($tag or $way or $point or !$country or $duration)

            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">
                    Туры @if($way) {{ morph($way->title, 'В', $way->title_cases) }} @endif @if($point) {{ morph($point->title, 'В', $point->title_cases) }} @endif
                    по месяцам
                </div>
                <ul>
                    @php ($monthDisplayed = 1) @endphp
                    @forelse(config('main.month') as $key => $value)

                        @if ($loop->iteration < now()->format('n'))
                            @continue
                        @endif
                        {{-- 
                        @if($layer == 3)
                            @if($countTours = Gliss::countTours("/$level/$key"))
                                <li>
                                    <a href="/{{$level}}/{{$key}}">{{$value}}</a>
                                    <span>{{$countTours}}</span>
                                </li>
                            @endif
                        @else
                            @if($countTours = Gliss::countTours(Gliss::generatedMonthLink($level, $way, $point, $tag,$key,$duration)))
                                <li>
                                    <a href="{{Gliss::generatedMonthLink($level, $way, $point, $tag,$key,$duration)}}">{{$value}}</a>
                                    <span>{{$countTours}}</span>
                                </li>
                            @endif
                        @endif
                        --}}
                        @if($countTours = Gliss::countTours(Gliss::generatedMonthLink($level, $way, $point, $tag,$key,$duration)))
                            <li>
                                <a href="{{Gliss::generatedMonthLink($level, $way, $point, $tag,$key,$duration)}}">{{$value}}</a>
                                <span>{{$countTours}}</span>
                            </li>
                        @endif
                        
                        @if ($monthDisplayed >= 6)
                            @break
                        @endif

                        @php ($monthDisplayed++) @endphp
                        
                    @empty
                    @endforelse
                </ul>
            </div>
        @endif

        @if($country or $tag or $month)
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">
                    Туры @if($way)  {{ morph($way->title, 'В', $way->title_cases) }} @endif @if($point) {{ morph($point->title, 'В', $point->title_cases) }} @endif
                    по длительности
                </div>
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
                <div class="sidebar-tour-title">Виды
                    отдыха @if($way) {{ morph($way->title, 'В', $way->title_cases) }} @endif @if($point) {{ morph($point->title, 'В', $point->title_cases) }} @endif</div>
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
                <div class="sidebar-tour-title">Типы
                    туров @if($way) {{ morph($way->title, 'В', $way->title_cases) }} @endif @if($point) {{ morph($point->title, 'В', $point->title_cases) }} @endif</div>
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
                    @forelse($countries as $countryItem)
                        @if(isset($country) && isset($country->slug))
                            @if( ($country->slug != $countryItem->url))
                                <li class="with-flag">
                                    @php
                                        $images = json_decode($countryItem->country->images);
                                    @endphp

                                    {{--<a href="/{{$country->url}}{{$tag ? "/" . $tag->value : ""}}{{$month ? "/" . $month : ""}}">--}}
                                    <a href="/{{$countryItem->url}}{{$month ? "/" . $month : ""}}">
                                        @if($countryItem->country->flag)
                                            <img width="15"
                                                 src="/uploads/countries/flags/{{$countryItem->country->flag}}"/>
                                        @endif
                                        Туры {{ morph($countryItem->country->country, 'В', $countryItem->country->country_cases) }}
                                    </a>
                                    <span>{{$countryItem->country->count_tours}}</span>
                                </li>
                                @if($loop->iteration == 5)
                                    @break
                                @endif
                            @endif
                        @else
                            <li class="with-flag">
                                @php
                                    $images = json_decode($countryItem->country->images);
                                @endphp

                                {{--<a href="/{{$country->url}}{{$tag ? "/" . $tag->value : ""}}{{$month ? "/" . $month : ""}}">--}}
                                <a href="/{{$countryItem->url}}{{$month ? "/" . $month : ""}}">
                                    @if($countryItem->country->flag)
                                        <img width="15" src="/uploads/countries/flags/{{$countryItem->country->flag}}"/>
                                    @endif
                                    Туры {{ morph($countryItem->country->country, 'В', $countryItem->country->country_cases) }}
                                </a>
                                <span>{{$countryItem->country->count_tours}}</span>
                            </li>
                            @if($loop->iteration == 5)
                                @break
                            @endif
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