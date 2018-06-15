@foreach($tours as $tour)
    @include('front.tours.snippets.list-block', $tour)
@endforeach

<script>
    $(".search-completed-item-preview > div:first-child").unbind('click');
    $(".search-completed-item-preview > div:first-child").click(function () {
        $(this).closest('.search-completed-item').find('.search-completed-item-more').slideToggle();
        return false;
    });

    //Insert dates
    // $('.search-completed-item-date a:not(.all-dates)').on('click', function (e) {
    //     e.preventDefault();
    //     var date = $(this).attr('data-date');
    //
    //     $('#tourDate').data('daterangepicker').setStartDate(date);
    //     $('#tourDate').data('daterangepicker').setEndDate(date);
    //
    //     $('#filterTours').trigger('click');
    // });

    // Insert point
    $('.search-completed-item-route a').on('click', function (e) {
        e.preventDefault();
        var point = $(this).text();

        $('#tourPoint').attr('value', point.trim(','));

        $('#filterTours').trigger('click');
    });
</script>