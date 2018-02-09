<div class="sidebar-wrap">
    <div class="sidebar">
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Туры по России</div>
            <ul>
                <li><a href="/tury/novyy-god/" class="new-year-icon">Новогодние туры</a></li>
                <li><a href="/tury/mayskie-prazdniki/">На майские праздники</a></li>
                <li><a href="/tury/na-1-den">Однодневные туры</a></li>
                <li><a href="/tury/">Многодневные туры</a></li>
                <li><a href="/russia/tury-zolotoe-kolczo">Золотое кольцо</a></li>
                <li><a href="/tury/dlya-vseh-vozrastov">Для детей и взрослых</a></li>
                {{--<li><a href="/">Туры выходного дня</a></li>--}}
                {{--<li><a href="#">Индивидуальные туры</a></li>--}}
                <li><a href="/tury/vip">ВИП туры</a></li>
            </ul>
        </div>
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-subtitle">Города России</div>
            <ul>
                @forelse($cities as $city)
                    <li><a href="#">Туры в {{Gliss::case($city->title, "П")}}</a></li>
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
                    <li><a href="#">Туры в {{Gliss::case($city->title, "П")}}</a></li>
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
            <div class="sidebar-tour-title">Виды отдыха</div>
            <ul>
                @forelse($tourTypes as $type)
                    <li><a href="#">{{$type->alias}}</a></li>
                    @if($loop->iteration == 5)
                        @break
                    @endif
                @empty
                    <li><a href="#">Нет видов отдыха</a></li>
                @endforelse
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
                        <li><a href="#">{{$type->alias}}</a></li>
                    @endif
                @empty
                    <li><a href="#">Нет видов отдыха</a></li>
                @endforelse
            </ul>
            <a class="btn-rest-tours" href="#">Показать остальные туры</a>
        </div>
        <div class="sidebar-city-tour">
            <div class="sidebar-tour-title">Другие страны</div>
            <ul>
                @forelse($countries as $country)
                    <li class="with-flag"><a href="#">Туры в {{Gliss::case($country->title, "П")}}</a></li>
                    @if($loop->iteration == 5)
                        @break
                     @endif
                @empty
                    <li><a href="#">Нет стран</a></li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="sidebar-notice">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat
        voluptatum eos harum officiis laborum reiciendis architecto ad iste eligendi, corrupti
        porro, similique perferendis facilis! Excepturi odit quas repellendus tempora, repellat.
    </div>
</div>