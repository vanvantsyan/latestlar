<div class="tour-filter">
    <form method="POST">
        {{ csrf_field() }}
        <div class="tour-filter-item">
            <label>Город или достопримечательность</label>
            <input name="tourPoint" id="tourPoint" type="text" placeholder="Введите название"
                   value="{{$point->title or ''}}">
        </div>
        <div class="tour-filter-item" style="display: none">
            <label>Направление</label>
            <input name="tourWay" id="tourWay" type="text" placeholder="" value="{{$way->title or ''}}">
        </div>
        <div class="tour-filter-item" style="display: none">
            <label>Длительность</label>
            {{--<input name="duration" id="duration" type="text" placeholder="" value="{{$duration or ''}}">--}}
        </div>
        <div class="tour-filter-item date-mob">
            <label>Даты начала тура <span data-toggle="tooltip" title="Укажите желаемые даты выезда">?</span></label>
            <input name="tourDate" id="tourDate" class="date-pick dp-applied" value="" disabled>
            <label class="icon-calendar" for="tourDate"><img src="/img/icon-date.png" alt="date-icon" title="Выберите даты выезда" /></label>
        </div>
        <div class="tour-filter-item time-mob">
            <label>Длительность тура (дни)</label>

            <select name="durationFrom" id="durationFrom">

                @for($i=1; $i < 15; $i++)
                    @if(isset($postData['durationFrom']))
                        <option value="{{$i}}"
                                @if(isset($postData['durationFrom']) && $postData['durationFrom'] == $i) selected @endif>
                            от {{$i}}</option>
                    @else
                        @if($i == 1)
                            <option value="{{$i}}" selected>от {{$i}}</option>
                        @else
                            <option value="{{$i}}">от {{$i}}</option>
                        @endif
                    @endif
                @endfor
            </select>

            <select name="durationTo" id="durationTo">

                @for($i=1; $i < 15; $i++)
                    @if(isset($postData['durationTo']))
                        <option value="{{$i}}"
                                @if(isset($postData['durationTo']) && $postData['durationTo'] == $i) selected @endif>
                            до {{$i}}</option>
                    @else
                        @if($i == 8)
                            <option value="{{$i}}" selected>до {{$i}}</option>
                        @else
                            <option value="{{$i}}" selected>до {{$i}}</option>
                        @endif
                    @endif
                @endfor
                    <option value="more" selected>неограниченно</option>

            </select>
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
        <div class="tour-filter-item value">
            <label>Стоимость</label>
            <input name="priceFrom" type="text" placeholder="от 12000" @if(isset($postData['priceFrom'])) value="{{$postData['priceFrom']}}@endif">
            <input name="priceTo" type="text" placeholder="до 12000000" @if(isset($postData['priceTo'])) value="{{$postData['priceTo']}}@endif">
        </div>
        {{--<a href="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>--}}
        <input id="filterTours" type="submit" class="btn btn-blue" value="Подобрать варианты">
    </form>
</div>
