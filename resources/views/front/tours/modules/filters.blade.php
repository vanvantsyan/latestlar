<div class="tour-filter">
    <form method="POST">
        {{ csrf_field() }}
        <div class="tour-filter-item filterCountry">
            <label>Страна</label>
            <select name="tourCountry" id="tourCountry" class="selectFirstLine">
                <option value="">Любая</option>
                @foreach($countries as $tourCountry)
                    <option title="{{$tourCountry->title}}" value="{{$tourCountry->url}}"
                            @if(isset($country) && $country->magput == $tourCountry->id) selected @endif>{{Str::words($tourCountry->title, 2, '...',' ')}}</option>
                @endforeach
            </select>
        </div>
        <div class="tour-filter-item" class="filterPoint">
            <label>Город или достопримечательность</label>
            <input name="place" id="tourPoint" type="text" placeholder="Введите название"
                   value="{{$point->title ?? $way->title ?? ''}}">
        </div>
        <div class="tour-filter-item" style="display: none">
            <label>Направление</label>
            <input name="tourWay" id="tourWay" type="text" placeholder="" value="{{$way->title or ''}}">
        </div>
        <div class="tour-filter-item" style="display: none">
            <label>Длительность</label>
            <input name="duration" id="duration" type="text" placeholder="" value="{{$duration or ''}}">
        </div>
        <div class="tour-filter-item time-mob" class="filterDuration">
            <label>Длительность тура (дни)</label>
            @if(isset($postData['durationFrom']) or isset($durationFrom))
                @php
                    $currentFrom = isset($postData['durationFrom']) ? $postData['durationFrom'] : $durationFrom;
                @endphp
            @else
                @php
                    $currentFrom = '';
                @endphp
            @endif
            <select name="durationFrom" id="durationFrom">
                @for($i=1; $i < 16; $i++)

                    @if($currentFrom)
                        <option value="{{$i}}" @if($currentFrom == $i) selected @endif>от {{$i}}</option>
                    @else

                        @if($i == 1)
                            <option value="{{$i}}" selected>от {{$i}}</option>
                        @else
                            <option value="{{$i}}">от {{$i}}</option>
                        @endif
                    @endif
                @endfor
            </select>
            @if((isset($postData['durationTo']) && $postData['durationTo'] != "more") or isset($durationTo))
                @php
                    $currentTo = isset($postData['durationTo']) ? $postData['durationTo'] : $durationTo;
                @endphp
            @else
                @php
                    $currentTo = '';
                @endphp
            @endif
            <select name="durationTo" id="durationTo">
                @for($i=1; $i < 15; $i++)

                    @if($currentTo && $currentTo != "more")
                        <option value="{{$i}}" @if($currentTo == $i) selected @endif>до {{$i}}</option>
                    @else
                        @if($i == 8)
                            <option value="{{$i}}" selected>до {{$i}}</option>
                        @else
                            <option value="{{$i}}">до {{$i}}</option>
                        @endif
                    @endif
                @endfor
                <option value="more"
                        @if(!$currentTo || (isset($postData['durationTo']) && $postData['durationTo'] == "more")) selected @endif>
                    неограниченно
                </option>
            </select>
        </div>
        @if($tag && $tag->tag_id == 3)
            <input name="tourType" type="hidden" value="{{$tag->id}}"/>
        @endif
        <div class="tour-filter-item value">
            <label>Стоимость</label>
            <input name="priceFrom" type="text" placeholder="от 12000"
                   @if(isset($postData['priceFrom'])) value="{{$postData['priceFrom']}}@endif">
            <input name="priceTo" type="text" placeholder="до 12000000"
                   @if(isset($postData['priceTo'])) value="{{$postData['priceTo']}}@endif">
        </div>
        <div class="tour-filter-item date-mob filterDate">
            <label>Даты начала тура <span data-toggle="tooltip" title="Укажите желаемые даты выезда">?</span>
                <div id="dateFilterToggle" class="on">очистить</div>
            </label>
            <input name="tourDate" id="tourDate" class="date-pick dp-applied" value="" placeholder="Любая">
            <input name="expandedTourDate" id="expandedTourDate" type="hidden">
            <label class="icon-calendar" for="tourDate">
                <img src="/img/icon-date.png" alt="date-icon" title="Выберите даты выезда"/>
            </label>
        </div>
        <div class="tour-filter-item category">
            <label>Категория тура</label>
            <select name="tourType">
                <option value="0">Все варианты</option>
                @isset($tourTypes)
                    @forelse($tourTypes as $tourType)
                        @if(isset($postData['tourType']))
                            <option value="{{$tourType->id}}"
                                    @if($tourType->id == $postData['tourType'])selected="selected"@endif>{{$tourType->alias}}</option>
                        @else
                            <option value="{{$tourType->id}}"
                                    @if(is_object($tag) && $tourType->id == $tag->id)selected="selected"@endif>{{$tourType->alias}}</option>
                        @endif
                    @empty
                    @endforelse
                @endisset
            </select>
        </div>
        {{-- 
        <a href="#" class="tour-filter-more"><span>Расширенный поиск</span>
            <div> &#9660;</div>
        </a>
        --}}
        <input id="filterTours" type="submit" class="btn btn-blue" value="Подобрать варианты">
        <div class="clearfix"></div>
    </form>
</div>
