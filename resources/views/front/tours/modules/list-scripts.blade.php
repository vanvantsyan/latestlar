<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{asset('/js/moment.js')}}"></script>
<script src="{{asset('/js/daterangepicker.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $('#sendPhone input[type=submit]').on('click', function (e) {
        e.preventDefault();
        $('#sendPhone').html('<div class="popular-tours-item-title">Заявка отправлена</div><p>Благодарим за обращение</p>');
    });
</script>

<script>
    $('.tours-sorting a span').on('click', function (e) {
        e.preventDefault();
        $('.tours-sorting-items').toggleClass('active');
    })
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    moment.locale('ru');

    $('#tourDate').daterangepicker({
        locale: {
            format: 'DD.MM.YYYY',
            "daysOfWeek": [
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб",
                "Вс"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
        },
        @if($month)
        startDate: '{!! date('d.m.Y', strtotime("1 " . $month)) !!}',
        endDate: '{!! date('d.m.Y', strtotime("last day of " . $month)) !!}',
        @elseif($tourDate)
                @php
                    $datesArr = explode('-', $tourDate);
                @endphp
        startDate: '{{trim(head($datesArr))}}',
        endDate: '{{trim(last($datesArr))}}',
        @else
        startDate: moment().format('DD.MM.YYYY'),
        endDate: moment().add(30, 'day').format('DD.MM.YYYY'),
        @endif
        "autoApply": true,
    });
</script>