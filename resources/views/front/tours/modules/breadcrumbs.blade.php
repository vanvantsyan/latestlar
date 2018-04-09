<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                <a href="/" itemprop="url">
                    <span itemprop="title">Главная</span>
                </a>
            </div>

            <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                <a href="{{route('tour.list')}}" itemprop="url">
                    <span itemprop="title">Поиск тура</span>
                </a>
            </div>
            @if(Route::currentRouteName() == "countryMain")
                <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                    <a href="/{{$country->slug}}" itemprop="url">
                        @if($country->slug == 'russia')
                            <span itemprop="title">Туры по {{Gliss::case($country->country, "П")}}</span>
                        @else
                            <span itemprop="title">Туры {{Gliss::case($country->country, "куда")}}</span>
                        @endif
                    </a>
                </div>
            @else

                @if($country)
                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <a href="/{{$country->slug}}" itemprop="url">
                            @if($country->slug == 'russia')
                                <span itemprop="title">Туры по {{Gliss::case($country->country, "П")}}</span>
                            @else
                                <span itemprop="title">Туры {{Gliss::case($country->country, "куда")}}</span>
                            @endif
                        </a>
                    </div>
                @endif

                @if($month || $tag || $duration)

                    @isset($resort)
                        <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                            <a href="/{{$country->slug}}/tury-{{$resort->url}}" itemprop="url">
                                @if($resort->url == 'moskva')
                                    <span itemprop="title">Туры по {{Gliss::case($resort->title, "П")}}</span>
                                @else
                                    <span itemprop="title">Туры {{Gliss::case($resort->title, "куда")}}</span>
                                @endif
                            </a>
                        </div>
                    @endif

                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <span itemprop="title">{{$pTitle}}</span>
                    </div>

                @else

                    @isset($resort)
                        <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                            @if($resort->url == 'moskva')
                                <span itemprop="title">Туры по {{Gliss::case($resort->title, "П")}}</span>
                            @else
                                <span itemprop="title">Туры {{Gliss::case($resort->title, "где")}}</span>
                            @endif
                        </div>
                    @else

                        <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                            <span itemprop="title">{{$pTitle}}</span>
                        </div>

                    @endif

                @endif
            @endif
        </div>
    </div>
</div>