<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{asset('/js/moment.js')}}"></script>
<script src="{{asset('/js/daterangepicker.js')}}"></script>
<script src="{{asset('/js/jquery-ui.js')}}"></script>
<script src="{{asset('/js/shared.js')}}"></script>
<script>
    $('#tourDate').daterangepicker({
        locale: {
            format: 'DD.MM.YY',
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
        minDate: moment().format('DD.MM.YY'),
        @if(isset($month) && $month)

        startDate: '{!! date('d.m.y', strtotime("1 " . $month)) !!}',
        endDate: '{!! date('d.m.y', strtotime("last day of " . $month)) !!}',
        @elseif(isset($tourDate) && !empty($tourDate))
                @php
                    $datesArr = explode('-', $tourDate);
                @endphp
        startDate: '{{trim(head($datesArr))}}',
        endDate: '{{trim(last($datesArr))}}',
        @else
        //startDate: moment().format('DD.MM.YY'),
        //endDate: moment().add(30, 'day').format('DD.MM.YY'),
        @endif
        "autoApply": true,
    });
    
    // Если нет данных по фильтру, то делаем поле пустым
    @if (!(isset($month) && $month) && !(isset($tourDate) && $tourDate))
        $('#tourDate').val(null);
    @endif
</script>
