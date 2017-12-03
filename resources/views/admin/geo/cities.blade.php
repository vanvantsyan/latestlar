<label for="city">City *</label>
<select id="city" class="form-control " name="city_id" required>
    <option value=""></option>
    @forelse($cities as $city)
        <option value="{{$city->id}}" @if(isset($hotel) && $hotel->city_id == $city->id) selected @endif>{{$city->city}}</option>
    @empty
    @endforelse
</select>