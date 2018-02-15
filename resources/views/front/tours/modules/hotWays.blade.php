<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
    <div class="row">
        <div class="sitemap-item">
            <div class="title">Горящие туры</div>
            <ul>
                @foreach($hotWays as $hotway)
                    <li><a href="/{{$hotway->url}}">{{Str::words($hotway->title, 2, '...')}} от {{$hotway->minPrice}} Р</a></li>
                @endforeach

                <li><a class="link-blue" href="http://startour.ru/goryashhie-turyi/">Все варианты</a></li>
            </ul>
        </div>
    </div>
</div>