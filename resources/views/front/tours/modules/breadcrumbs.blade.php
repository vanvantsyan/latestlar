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
                    <span itemprop="title">
                        Туры {{ morph($country->country, 'В', $country->country_cases) }}
                    </span>
                </div>
            @else

                @if($country)
                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <a href="/{{$country->slug}}" itemprop="url">
                            <span itemprop="title">
                                Туры {{ morph($country->country, 'В', $country->country_cases) }}
                            </span>
                        </a>
                    </div>
                @endif

                @if($month || $tag || $duration)

                    @isset($resort)
                        <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                            <a href="/{{optional($country)->slug ?? 'tury'}}/tury-{{$resort->url}}" itemprop="url">
                                <span itemprop="title">
                                    Туры {{ morph($resort->title, 'В', $resort->title_cases) }}
                                </span>
                            </a>
                        </div>
                    @endif

                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <span itemprop="title">{{$pTitle}}</span>
                    </div>

                @else

                    @isset($resort)
                        <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                            <span itemprop="title">
                                Туры {{ morph($resort->title, 'В', $resort->title_cases) }}
                            </span>
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