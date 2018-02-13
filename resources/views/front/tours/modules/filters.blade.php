<div class="tour-filter">
    <form method="POST">
        <div class="tour-filter-item">
            <label>Город или достопримечательность</label>
            <input name="tourPoint" id="tourPoint" type="text" placeholder="Красная поляна" value="{{$point->title or ''}}">
        </div>
        <div class="tour-filter-item" style="display: none">
            <label>Город или достопримечательность</label>
            <input name="tourWay" id="tourWay" type="text" placeholder="" value="{{$way->title or ''}}">
        </div>
        <div class="tour-filter-item date-mob">
            <label>Даты поездки <span>?</span></label>
            <input name="tourDate" id="tourDate" class="date-pick dp-applied" value="">
        </div>
        <div class="tour-filter-item time-mob">
            <label>Срок поездки (дни)</label>
            <select name="durationFrom" id="durationFrom">
                <option value="1">от 1</option>
                <option value="2">от 2</option>
                <option value="3">от 3</option>
                <option value="4">от 4</option>
                <option value="5">от 5</option>
                <option value="6">от 6</option>
                <option value="7">от 7</option>
                <option value="8">от 8</option>
                <option value="9">от 9</option>
                <option value="10">от 10</option>
            </select>
            <select name="durationTo" id="durationTo">
                <option value="2">до 2</option>
                <option value="3">до 3</option>
                <option value="4">до 4</option>
                <option value="5">до 5</option>
                <option value="6">до 6</option>
                <option value="7">до 7</option>
                <option value="8" selected>до 8</option>
                <option value="9">до 9</option>
                <option value="10">до 10</option>
            </select>
        </div>
        <div class="tour-filter-item category">
            <label>Категория тура</label>
            <select name="tourType">
                <option value="0">Все варианты</option>
                @isset($tourTypes)
                    @forelse($tourTypes as $tourType)
                        <option value="{{$tourType->id}}" @if(is_object($tag) && $tourType->id == $tag->id)selected="selected"@endif>{{$tourType->alias}}</option>
                    @empty
                    @endforelse
                @endisset
            </select>
        </div>
        <div class="tour-filter-item value">
            <label>Стоимость</label>
            <input name="priceFrom" type="text" placeholder="от 12000">
            <input name="priceTo" type="text" placeholder="до 12000000">
        </div>
        <a href="#" class="tour-filter-more"><span>Расширенный поиск</span> &#9660;</a>
        <input id="filterTours" type="submit" class="btn btn-blue" value="Подобрать варианты">
    </form>
</div>