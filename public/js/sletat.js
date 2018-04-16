$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#sletatForm form').submit(function(e){
    e.preventDefault();

    var data = $(this).serializeArray();
    console.log(data);

    return false;
});

$('select').styler({
    selectSearch: true
});

$('.search-completed-item-date a:not(.all-dates)').on({

    mouseenter: function () {
        $(this).text('Заказать');
        $(this).addClass('order');
    },
    mouseleave: function () {

        var tourDate = $(this).attr('data-date');

        $(this).text(moment(tourDate, 'D.M.Y').format('DD.MM'));
        $(this).removeClass('order');
    },
    click: function (e) {

        var tourDate = $(this).attr('data-date');

        $('input[name=tourDate]').attr('value', moment(tourDate, 'D.M.Y').format('DD.MM'));

        e.preventDefault();
        // $('#tourOrderModal').modal('show');
    }

});

// Set hidden fields
$('#tourOrderModal').on('show.bs.modal', function (e) {

    var tourBlock = $(e.relatedTarget).closest('.search-completed-item');
    if (tourBlock.length) {
        var tourName = tourBlock.find('.search-completed-item-preview .search-completed-item-title').text();

        var route = (tourBlock.find('.search-completed-item-route').html()).trim();
        var href = tourBlock.find('.btn-blue').attr('href');
        var source = "magput";

        $('input[name=source]').attr('value', source);
        $('input[name=href]').attr('value', 'http://russia.startour.ru' + href);
        $('input[name=tourName]').attr('value', tourName);
        $('input[name=route]').attr('value', route);

        $('#tourName').html('"<strong>' + tourName + '</strong>"');
    }
});