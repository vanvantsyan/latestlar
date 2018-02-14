<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                <a href="/" itemprop="url">
                    <span itemprop="title">Главная страница</span>
                </a>
            </div>

            <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                <a href="{{route('tour.list')}}" itemprop="url">
                    <span itemprop="title">Поиск тура</span>
                </a>
            </div>

            <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                <span itemprop="title">{{$pTitle}}</span>
            </div>
        </div>
    </div>
</div>