<div class="popular-category">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="title">Популярные категории</div>
            <div class="popular-category-items">
                @foreach($tourCategories as $category)
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                        <div class="row">
                            <a href="/tury/{{$category->value}}" class="poular-category-item">
                                @php
                                    $images = json_decode($category->images);
                                @endphp
                                <div class="poular-category-item-img">
                                    @if(count($images))
                                        <img src="/img/tourstagsvalues/full/{{last($images)}}"
                                             alt="">
                                    @endif
                                </div>
                                <span>{{$category->alias}}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>