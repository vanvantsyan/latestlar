<div class="subscription">
    <div class="container">
        <div class="subscription-title">Получайте лучшие предложения по цене на почту!</div>
        <form>
            <select>
                <option>Все страны</option>
                @foreach($countries as $country)
                    <option>{!! $country->title !!}</option>
                @endforeach
            </select>
            <input type="email" placeholder="Ваша электронная почта" required>
            <input class="btn btn-yellow" type="submit" value="Подписаться">
        </form>
    </div>
</div>