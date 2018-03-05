<div class="search-completed-item">
    <div class="search-completed-item-preview">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
            <div class="row">
                <div class="search-completed-preview-left">
                    <div class="search-completed-item-title">{{$tour['title']}}</div>
                    <ul>
                        <li>{{count($tour['par_points']) ?: 1}} {!! Gliss::numeralCase('город', count($tour['par_points']) ?: 1) !!}</li>
                        <li>14 экскурсий</li>
                        <li>Поездка на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5">
            <div class="row">
                <div class="search-completed-preview-right">
                    <div class="search-completed-item-price">
                        @if($tour['price'] > 0)
                            <b>от {{number_format($tour['price'], 0, '.',' ') }}
                                <span class="glyphicon glyphicon-rub"
                                      aria-hidden="true"></span>
                            </b>
                            <span>за человека</span>
                        @else
                            <b>Цена</b>
                            <span>не указана</span>
                        @endif
                    </div>
                    <a href="#" data-toggle="modal" data-target="#tourOrderModal" class="btn btn-orange">Заказать</a>
                    <a href="{{Gliss::tourLink($tour)}}" class="btn btn-blue">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
    <div class="search-completed-item-more">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="row">
                <a href="#" class="search-completed-item-img" data-images="{{ $tour['images'] }}"
                   data-tour-id="{{$tour['id']}}" data-toggle="modal"
                   data-target="#tourImagesModal">
                    @php
                        $images = (array) json_decode($tour['images']);
                    @endphp
                    @if(count($images))
                        <img src="{{ Gliss::tourThumb(array_shift($images), $tour['id']) }}" alt="">
                    @else
                        <img src="{{asset('/img/search-completed-item-1.jpg')}}" alt="">
                    @endif
                    @if(count($images))
                        <span class="tour-images-button">Все фото ({{count($images)}}
                            )</span>
                        <span class="mobile-visible">
                            @if($tour['price'] > 0)
                                <b>от {{number_format($tour['price'], 0, '.',' ') }} <i class="glyphicon glyphicon-rub"
                                                                                        aria-hidden="true"></i> за человека</b>
                            @else
                                <b>Цена не указана</b>
                            @endif
                        </span>
                    @endif
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <div class="tour-list-about">
                    <ul>
                        <li>{{count($tour['par_points']) ?: 1}} {!! Gliss::numeralCase('город', count($tour['par_points']) ?: 1) !!}</li>
                        <li>14 экскурсий</li>
                        <li>Поездка
                            на {{$tour['duration']}} {!! Gliss::numeralCase('день', $tour['duration']) !!}</li>
                    </ul>
                </div>
                <div class="search-completed-item-more-right">
                    <a href="{{Gliss::tourLink($tour)}}"><span>></span></a>
                    <div class="search-completed-preview-left">
                        <div class="search-completed-item-title">{{$tour['title']}}</div>
                    </div>
                    <div class="search-completed-item-route">
                        <span>Маршрут тура:</span>

                        @if(count($tour['par_points']))

                            @php
                                $i = 1;
                            @endphp

                            @foreach($tour['par_points'] as $point)
                                @if($i < count($tour['par_points']))
                                    <a href="#">{{array_get($point,'points_par.title')}}</a>
                                    ,
                                @else
                                    <a href="#">{{array_get($point,'points_par.title')}}</a>
                                @endif
                                @php $i++ @endphp
                            @endforeach

                        @else
                            @if(count($tour['par_ways']))
                                {{$tour['par_ways'][0]['ways_par']['title']}}
                            @endif
                        @endif

                        , <b class="btn-other-tours">еще 5</b>

                    </div>
                    <div class="search-completed-item-date">
                        <span>Ближайшая дата:</span>
                        @php $num = 0; @endphp
                        
                        @foreach($tour['dates'] as $date)
                            @if ($num > 5)
                                @break
                            @endif
                            <a href="#" class="green" data-date="{{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m.Y')}}" data-toggle="modal" data-target="#tourOrderModal">
                                {{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m')}}
                            </a>

                            @php $num++; @endphp
                        @endforeach

                        @if(count($tour['dates']) > 6)
                            <a href="{{Gliss::tourLink($tour)}}" class="all-dates">Все даты <b>>>></b></a>
                        @endif
                    </div>
                    <div class="search-completed-item-desc">
                        {!! Str::words($tour['description'], 17,'...') !!}
                        <a href="{{Gliss::tourLink($tour)}}">Подробнее</a>
                    </div>
                    <div class="search-completed-item-tags">
                        @php
                            $tourTypes = [];
                        @endphp
                        @foreach($tour['tour_tags'] as $tag)
                            @if(in_array($tag['tag_id'], [3,4,5]))
                                @php
                                    $tourTypes[] = array_get($tag, 'fix_value.alias');
                                @endphp
                            @endif
                        @endforeach
                        {!! implode(', ', $tourTypes) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>