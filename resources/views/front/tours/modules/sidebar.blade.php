<div class="sidebar-wrap">
    <div class="sidebar">
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Туры по России</div>
            <ul>
                @if($layer == 3)
                    <li><a href="/{{$level}}/novyy-god/" class="new-year-icon">Новогодние туры</a></li>
                    <li><a href="/{{$level}}/23-fevralya">Туры на 23 февраля</a></li>
                    <li><a href="/{{$level}}/8-marta">Туры на 8 марта</a></li>
                    <li><a href="/{{$level}}/vip">ВИП туры</a></li>
                @else
                    <li>
                        <a href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}novyy-god{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/"
                           class="new-year-icon">Новогодние туры</a></li>
                    <li>
                        <a href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}23-fevralya{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">Туры
                            на 23 февраля</a></li>
                    <li>
                        <a href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}8-marta{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">Туры
                            на 8 марта</a></li>
                    <li>
                        <a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}vip{{($tag && in_array($tag->tag->title, ["holiday", "tour_type"])) ? "/" . $tag->value : ''}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">ВИП
                            туры</a></li>
                @endif

                <li><a href="/{{$level}}/na-1-den">Однодневные туры</a></li>
                <li><a href="/{{$level}}/">Многодневные туры</a></li>
                <li><a href="/{{$level}}/tury-zolotoe-kolczo">Золотое кольцо</a></li>
            </ul>
        </div>

        <div class="sidebar-city-tour">
            <div class="sidebar-tour-subtitle">Города России</div>
            <ul>
                @forelse($cities as $city)
                    @if($layer == 3)
                        <li><a href="/russia/tury-{{$city->url}}">Туры в {{Gliss::case($city->title, "П")}}</a></li>
                    @else
                        <li>
                            <a href="/russia/tury-{{$city->url}}{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                                в {{Gliss::case($city->title, "П")}}</a>
                        </li>
                    @endif
                    @if($loop->iteration == 4)
                        @break
                    @endif
                @empty
                    <li><a href="#">Города не выбраны</a></li>
                @endforelse

                <li><a href="#">Другие города</a></li>
            </ul>
        </div>
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-subtitle">Туры по золотому кольцу</div>
            <ul>
                @forelse($citiesGolden as $city)
                    @if($layer == 3)
                        <li><a href="/russia/tury-{{$city->url}}">Туры в {{Gliss::case($city->title, "П")}}</a></li>
                    @else
                        <li>
                            <a href="/russia/tury-{{$city->url}}{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                                в {{Gliss::case($city->title, "П")}}</a>
                        </li>
                    @endif

                    @if($loop->iteration == 4)
                        @break
                    @endif
                @empty
                    <li><a href="#">Города не выбраны</a></li>
                @endforelse

                <li><a href="#">Другие города</a></li>
            </ul>
        </div>
        @if($tag or $way or $point or !$country or $duration)
            <div class="sidebar-city-tour">
                <div class="sidebar-tour-subtitle">Туры по месяцам</div>
                <ul>
                    @forelse(config('main.month') as $key => $value)
                        @if($layer == 3)
                            <li>
                                <a href="/{{$level}}/{{$key}}">{{$value}}</a>
                            </li>
                            @else
                            <li>
                                <a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}{{($tag) ? $tag->value . "/" : ""}}{{$key}}{{$duration ? "/". $duration : ""}}">{{$value}}</a>
                            </li>
                            @endif

                        @if($loop->iteration == 6)
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
                        <li>
                            @if($layer == 3)
                                <a href="/{{$level}}/na-{{$key}}">{{$value}}</a>
                            @else
                                <a href="/{{$level}}/{{$month ? $month . "/": ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}{{$tag ? $tag->value . "/" : ""}}na-{{$key}}">{{$value}}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Виды отдыха</div>
            <ul>
                @forelse($tourTypes as $type)
                    @if($layer == 3)
                        <li>
                            <a href="/{{$level}}/{{$type->value}}">{{$type->alias}}</a>
                        </li>
                    @else
                        <li>
                            <a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}{{($tag && in_array($tag->tag->title, ['holiday','status'])) ? $tag->value . "/" : ""}}{{$type->value}}">{{$type->alias}}</a>
                        </li>
                    @endif

                    @if($loop->iteration == 5)
                        @break
                    @endif
                @empty
                    <li><a href="#">Нет видов отдыха</a></li>
                @endforelse

                @if(count($tourTypes) > 5)
                    <li><a href="#">Все типы</a></li>
                @endif
            </ul>
        </div>
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Типы туров</div>
            <ul>
                @forelse($tourTypes as $type)

                    @if($loop->iteration == 11)
                        @break
                    @endif

                    @if($loop->iteration > 5)
                        @if($layer == 3)
                            <li>
                                <a href="/{{$level}}/{{$type->value}}">{{$type->alias}}</a>
                            </li>
                        @else
                            <li>
                                <a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}{{($tag && in_array($tag->tag->title, ['holiday','status'])) ? $tag->value . "/" : ""}}{{$type->value}}">{{$type->alias}}</a>
                            </li>
                        @endif
                    @endif
                @empty
                    <li><a href="#">Нет видов отдыха</a></li>
                @endforelse
            </ul>
            @if(count($tourTypes) > 5)
                <a class="btn-rest-tours" href="#">Показать остальные типы</a>
            @endif
        </div>
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Другие страны</div>
            <ul>
                @forelse($countries as $country)
                    <li class="with-flag"><a
                                href="/{{$country->url}}{{$tag ? "/" . $tag->value : ""}}{{$month ? "/" . $month : ""}}">Туры
                            в {{Gliss::case($country->title, "П")}}</a>
                    </li>
                    @if($loop->iteration == 5)
                        @break
                    @endif
                @empty
                    <li><a href="#">Нет стран</a></li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="sidebar-notice">{{$subText}}</div>
</div>