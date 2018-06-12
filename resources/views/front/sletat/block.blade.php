<div class="search-completed-item">
    <div class="search-completed-item-preview">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-7">
            <div class="row">
                <div class="search-completed-preview-left">
                    <div class="search-completed-item-title" onclick="window.open('{{Sletat::tourLink($tour[0])}}','_blank')">{{$tour[6]}}</div>
                    <ul>
                        {{--<li>{{count($tour['par_points']) ?: 1}} {!! Gliss::numeralCase('город', count($tour['par_points']) ?: 1) !!}</li>--}}
                        <li>Поездка на {{$tour[14]}} {!! Gliss::numeralCase('ночь', $tour[14]) !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5">
            <div class="row">
                <div class="search-completed-preview-right">
                    <div class="search-completed-item-price">
                        @if($tour[15])
                            <b>от {{$tour[15]}}
                                {{--<span class="glyphicon glyphicon-rub" aria-hidden="true"></span>--}}
                            </b>
                            <span>за человека</span>
                        @else
                            <b>Цена</b>
                            <span>не указана</span>
                        @endif
                    </div>
                    <a href="#" data-toggle="modal" data-target="#tourOrderModal" class="btn btn-orange">Заказать</a>
                    <a href="{{Sletat::tourLink($tour[0])}}" class="btn btn-blue" target="_blank">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
    <div class="search-completed-item-more">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="row">
                <div class="search-completed-item-img">

                    @if($tour[29])
                        <img onclick="window.open('{{Sletat::tourLink($tour[0])}}','_blank')" src="{{$tour[29]}}" alt="">
                    @else
                        <img onclick="window.open('{{Sletat::tourLink($tour[0])}}','_blank')" src="{{asset('/img/search-completed-item-1.jpg')}}" alt="">
                    @endif
                    {{--@if(count($images))--}}
                        {{--<span class="tour-images-button" data-images="{{ $tour['images'] }}" data-image-id="0"--}}
                              {{--data-tour-id="{{$tour['id']}}" data-toggle="modal"--}}
                              {{--data-target="#tourImagesModal">Все фото ({{count($images)}})</span>--}}
                        {{--<span class="mobile-visible">--}}
                            {{--@if($tour['price'] > 0)--}}
                                {{--<b>от {{number_format($tour['price'], 0, '.',' ') }} <i class="glyphicon glyphicon-rub"--}}
                                                                                        {{--aria-hidden="true"></i> за человека</b>--}}
                            {{--@else--}}
                                {{--<b>Цена не указана</b>--}}
                            {{--@endif--}}
                        {{--</span>--}}
                    {{--@endif--}}
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <div class="tour-list-about">
                    <ul>
                        {{--<li>{{count($tour['par_points']) ?: 1}} {!! Gliss::numeralCase('город', count($tour['par_points']) ?: 1) !!}</li>--}}
                        <li>Поездка на {{$tour[14]}} {!! Gliss::numeralCase('ночь', $tour[14]) !!}</li>
                    </ul>
                </div>
                <div class="search-completed-item-more-right">
                    <a href="{{Sletat::tourLink($tour[0])}}"><span>></span></a>
                    <div class="search-completed-preview-left">
                        <div class="search-completed-item-title">{{$tour[6]}}</div>
                    </div>
                    <div class="search-completed-item-route">
                        <span>Маршрут тура:</span>

                        {{--@if(count($tour['par_points']))--}}

                            {{--@php--}}
                                {{--$i = 1;--}}
                            {{--@endphp--}}

                            {{--@foreach($tour['par_points'] as $point)--}}
                                {{--@if($i < count($tour['par_points']))--}}
                                    {{--<a href="#">{{array_get($point,'points_par.title')}}</a>--}}
                                    {{--,--}}
                                {{--@else--}}
                                    {{--<a href="#">{{array_get($point,'points_par.title')}}</a>--}}
                                {{--@endif--}}
                                {{--@php $i++ @endphp--}}
                            {{--@endforeach--}}

                        {{--@else--}}
                            {{--@if(count($tour['par_ways']))--}}
                                {{--{{$tour['par_ways'][0]['ways_par']['title']}}--}}
                            {{--@endif--}}
                        {{--@endif--}}

                        {{--, <b class="btn-other-tours">еще 5</b>--}}

                    </div>
                    <div class="search-completed-item-date">
                        <span>Ближайшая дата: </span>
                        <a href="#" class="green"
                           data-date="{{$tour[28]}}"
                           data-toggle="modal" data-target="#tourOrderModal">
                           {{$tour[28]}}
                        </a>
                        {{--@php--}}
                            {{--$num = 0;--}}
                            {{--$dateTime = new \DateTime('now');--}}
                        {{--@endphp--}}

                        {{--@foreach($tour['dates'] as $date)--}}

                            {{--@if(Carbon\Carbon::createFromTimestamp($date['value'])->format('m') >= $dateTime->format('m') && time() < $date['value'])--}}

                                {{--@if ($num > 4)--}}
                                    {{--@break--}}
                                {{--@endif--}}
                                {{--<a href="#" class="green"--}}
                                   {{--data-date="{{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m.Y')}}"--}}
                                   {{--data-toggle="modal" data-target="#tourOrderModal">--}}
                                    {{--{{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m.y')}}--}}
                                {{--</a>--}}

                                {{--@php $num++; @endphp--}}

                            {{--@endif--}}
                        {{--@endforeach--}}

                        {{--@if(count($tour['dates']) > 5)--}}
                            {{--<a href="{{Sletat::tourLink($tour)}}" class="all-dates">Все даты <b>>>></b></a>--}}
                        {{--@endif--}}
                    </div>
                    <div class="search-completed-item-desc">
                        @if($tour[38])
                        {!! Str::words($tour[38], 17,'...') !!}
                        @endif
                        {{--<a href="{{Sletat::tourLink($tour)}}" target="_blank">Подробнее</a>--}}
                    </div>
                    <div class="search-completed-item-tags">
                        {{--@php--}}
                            {{--$tourTypes = [];--}}
                        {{--@endphp--}}
                        {{--@foreach($tour['tour_tags'] as $tag)--}}
                            {{--@if(in_array($tag['tag_id'], [3,4,5]))--}}
                                {{--@php--}}
                                    {{--$tourTypes[] = array_get($tag, 'fix_value.alias');--}}
                                {{--@endphp--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                        {{--{!! implode(', ', $tourTypes) !!}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>