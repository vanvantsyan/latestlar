<div class="sidebar-wrap">
    <div class="sidebar">
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Туры по России</div>
            <ul>
                @if($layer == 3)
                    <li><a class="march-icon" href="/{{$level}}/8-marta">Туры на 8 марта</a></li>
                    <li><a href="/{{$level}}/mayskie-prazdniki">Туры на майские праздники</a></li>
                    {{--<li><a href="/{{$level}}/vip">ВИП туры</a></li>--}}
                @else

                    <li><a class="march-icon"
                           href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}8-marta{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">Туры
                            на 8 марта</a></li>
                    <li>
                        <a href="/{{$level}}/{{($tag && $tag->tag->title == "status") ? $tag->value . "/" : ""}}{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}mayskie-prazdniki{{($tag && in_array($tag->tag->title, ["tour_type"])) ? "/" . $tag->value : ''}}{{$duration ? "/". $duration : ""}}/">Туры
                            на майские праздники</a></li>
                    {{--<li><a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}vip{{($tag && in_array($tag->tag->title, ["holiday", "tour_type"])) ? "/" . $tag->value : ''}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">ВИП туры</a></li>--}}
                @endif

                <li><a href="/russia/tury-zolotoe-kolczo">Золотое кольцо</a></li>
                <li><a href="/russia/tury-sankt-peterburg-i-leningradskaya-oblast">Санкт-Петербург</a></li>
                <li><a href="/russia/tury-altaj">Алтай</a></li>
                <li><a href="/russia/tury-bajkal">Байкал</a></li>
                <li><a href="/russia/tury-kamchatka">Камчатка</a></li>
                <li><a href="/russia/tury-sochi-i-krasnodarskij-kraj">Сочи и Кавказ</a></li>
                <li><a href="/russia/tury-kryim">Крым</a></li>

                <li><a href="/{{$level}}/na-1-den">Однодневные туры</a></li>
                <li><a href="/{{$level}}/">Многодневные туры</a></li>
            </ul>
        </div>

        <div class="sidebar-city-tour">
            <div class="sidebar-tour-subtitle">Города России</div>
            <ul>
                {{--@forelse($cities as $city)--}}
                {{--@if($layer == 3)--}}
                {{--<li><a href="/russia/tury-{{$city->url}}">Туры в {{Gliss::case($city->title, "П")}}</a></li>--}}
                {{--@else--}}
                {{--<li>--}}
                {{--<a href="/russia/tury-{{$city->url}}{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры--}}
                {{--в {{Gliss::case($city->title, "П")}}</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--@if($loop->iteration == 4)--}}
                {{--@break--}}
                {{--@endif--}}
                {{--@empty--}}
                @if($layer == 3)
                    <li><a href="/russia/tury-moskva">Туры в Москве</a></li>
                    <li><a href="/russia/tury-sankt-peterburg">Туры в Санкт-Петербурге</a></li>
                    <li><a href="/russia/tury-ekaterinburg">Туры в Екатеринбурге</a></li>
                    <li><a href="/russia/tury-kazani">Туры в Казани</a></li>
                    <li><a href="/russia/tury-sochi">Туры в Сочи</a></li>
                @else
                    <li>
                        <a href="/russia/tury-moskva{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Москве</a></li>
                    <li>
                        <a href="/russia/tury-sankt-peterburg{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Санкт-Петербурге</a></li>
                    <li>
                        <a href="/russia/tury-ekaterinburg{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Екатеринбурге</a></li>
                    <li>
                        <a href="/russia/tury-kazani{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Казани</a></li>
                    <li>
                        <a href="/russia/tury-sochi{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Сочи</a></li>
                @endif
                {{--<li><a href="#">Города не выбраны</a></li>--}}
                {{--@endforelse--}}
            </ul>
            <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourCitiesModal">Другие города</a>
        </div>
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-subtitle">Туры по золотому кольцу</div>
            <ul>
                {{--@forelse($citiesGolden as $city)--}}
                {{--@if($layer == 3)--}}
                {{--<li><a href="/russia/tury-{{$city->url}}">Туры в {{Gliss::case($city->title, "П")}}</a></li>--}}
                {{--@else--}}
                {{--<li>--}}
                {{--<a href="/russia/tury-{{$city->url}}{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры--}}
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
                    <li><a href="/russia/tury-vladimir">Туры в Владимире</a></li>
                    <li><a href="/russia/tury-rostov-velikiy">Туры в Ростове Великом</a></li>
                    <li><a href="/russia/tury-sergiev-posad">Туры в Сергиевом Посаде</a></li>
                    <li><a href="/russia/tury-suzdal">Туры в Суздале</a></li>
                    <li><a href="/russia/tury-yaroslavl">Туры в Ярославле</a></li>
                @else
                    <li>
                        <a href="/russia/tury-vladimir{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Владимире</a></li>
                    <li>
                        <a href="/russia/tury-rostov-velikiy{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Ростове Великом</a></li>
                    <li>
                        <a href="/russia/tury-sergiev-posad{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Сергиевом Посаде</a></li>
                    <li>
                        <a href="/russia/tury-suzdal{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Суздале</a></li>
                    <li>
                        <a href="/russia/tury-yaroslavl{{($tag) ? "/" . $tag->value  : ""}}{{$month ? "/" . $month : ""}}{{$duration ? "/". $duration : ""}}">Туры
                            в Ярославле</a></li>

                @endif
            </ul>
            <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourGoldensModal">Другие города</a>
        </div>
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
                            </li>
                        @else
                            <li>
                                <a href="/{{$level}}/{{$way ? "tury-" . $way->url ."/" : ""}}{{($point) ? "tury-" . $point->url ."/" : ""}}{{($tag) ? $tag->value . "/" : ""}}{{$key}}{{$duration ? "/". $duration : ""}}">{{$value}}</a>
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
            </ul>

            @if(count($tourTypes) > 5)
                <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourTypesModal">Все типы</a>
            @endif
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
                <a class="btn-rest-tours" href="#" data-toggle="modal" data-target="#tourTypesModal">Показать остальные
                    типы</a>
            @endif
        </div>
        {{--<div class="sidebar-city-tour">--}}
        {{--<div class="sidebar-tour-title">Другие страны</div>--}}
        {{--<ul>--}}
        {{--@forelse($countries as $country)--}}
        {{--<li class="with-flag">--}}
        {{--@php--}}
        {{--$images = json_decode($country->country->images);--}}
        {{--@endphp--}}

        {{--<a href="/{{$country->url}}{{$tag ? "/" . $tag->value : ""}}{{$month ? "/" . $month : ""}}">--}}
        {{--@if($images)--}}
        {{--<img width="15" src="/uploads/tmp/{{$images}}"/>--}}
        {{--@endif--}}
        {{--Туры в {{Gliss::case($country->title, "П")}}--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--@if($loop->iteration == 5)--}}
        {{--@break--}}
        {{--@endif--}}
        {{--@empty--}}
        {{--<li><a href="#">Нет стран</a></li>--}}
        {{--@endforelse--}}
        {{--</ul>--}}
        {{--</div>--}}
    </div>
    <div class="sidebar-notice">{{$subText}}</div>
</div>