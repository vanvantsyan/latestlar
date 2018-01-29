@foreach($tours as $tour)
    <div class="search-completed-item">
        <div class="search-completed-item-preview">
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                <div class="row">
                    <div class="search-completed-preview-left">
                        <div class="search-completed-item-title">{{$tour->title}}</div>
                        <ul>
                            @php
                                $cityCount = $tour->cityCount;
                            @endphp

                            <li>{{$cityCount ?: 1}} {!! Gliss::numeralCase('город', $cityCount ?: 1) !!}</li>
                            <li>14 экскурсий</li>
                            <li>Поездка
                                на {{$tour->duration}} {!! Gliss::numeralCase('день', $tour->duration) !!}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                <div class="row">
                    <div class="search-completed-preview-right">
                        <div class="search-completed-item-price">
                            @if($tour->price > 0)
                                <b>от {{number_format($tour->price, 0, '.',' ') }}
                                    <span class="glyphicon glyphicon-rub"
                                          aria-hidden="true"></span>
                                </b>
                                <span>за человека</span>
                            @else
                                <b>Цена</b>
                                <span>не указана</span>
                            @endif

                        </div>
                        <a href="#" class="btn btn-orange">Заказать</a>
                        <a href="#" class="btn btn-blue">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-completed-item-more">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="row">
                    <div class="search-completed-item-img">
                        @php
                            $images = json_decode($tour->images);
                        @endphp
                        @if(count($images))
                            <img src="/img/tours/full/{!! substr($tour->id, 0,2) !!}/{{$images[0]}}"
                                 alt="">
                        @else
                            <img src="img/search-completed-item-1.jpg" alt="">
                        @endif
                        @if(count($images))
                            <span class="tour-images-button" data-images="{{$tour->images}}"
                                  data-tour-id="{{$tour->id}}" data-toggle="modal"
                                  data-target="#tourImagesModal">Все фото ({{count($images)}}
                                )</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <div class="row">
                    <div class="search-completed-item-more-right">
                        <div class="search-completed-item-route">
                            <span>Маршрут тура:</span>
                            @php
                                $toursCount = $tour->points->count();
                            @endphp
                            @if($toursCount)

                                @php
                                    $i = 1;
                                @endphp
                                @foreach($tour->points as $point)
                                    {{$i < $toursCount ? $point->point->title . ', ' : $point->point->title}}
                                    @php $i++ @endphp
                                @endforeach

                            @else
                                {{$tour->ways[0]->waysPar->title}}
                            @endif
                        </div>
                        <div class="search-completed-item-date">
                            @php $num = 0; @endphp

                            @foreach($tour->dates as $date)
                                @if ($num > 5)
                                    @break
                                @endif
                                <a href="#" class="green">
                                    {{Carbon\Carbon::createFromTimestamp($date->value)->format('d.m')}}
                                </a>

                                @php $num++; @endphp
                            @endforeach

                            @if($tour->dates->count() > 6)
                                <a href="#" class="all-dates">Все даты <b>>>></b></a>
                            @endif
                        </div>

                        <div class="search-completed-item-desc">
                            {!! Str::words($tour->description, 17,'...') !!}
                            <a href="#">Подробнее</a>
                        </div>

                        <div class="search-completed-item-tags">Для детей, Золотое кольцо,
                            Новогодние туры
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach