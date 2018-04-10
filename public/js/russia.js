
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.onload = function () {

    $.ajax({
        type: 'POST',
        url: '/modals/getAll',
        success: function (modals) {
            setTimeout(function () {
                $('#modalContainer').html(modals)
            }, 1000);
        }
    });
};

// Set hidden fields
$('#tourOrderModal').on('show.bs.modal', function (e) {

    var tourBlock = $(e.relatedTarget).closest('.burning-tours-item');
    if (tourBlock.length) {

        var tourName = tourBlock.find('.burning-tours-item-desc b').text();

        var href = tourBlock.find('.burning-tours-item-more').attr('href');
        var source = "magput";

        $('input[name=source]').attr('value', source);
        $('input[name=href]').attr('value', 'http://russia.startour.ru' + href);
        $('input[name=tourName]').attr('value', tourName);

        $('#tourName').html('"<strong>' + tourName + '</strong>"');
    } else {
        $('input[name=source]').attr('value', "");
        $('input[name=href]').attr('value', "");
        $('input[name=tourName]').attr('value', "");

        $('#tourName').html('');
    }
});

$('#toursTab a').click(function (e) {
    $('#toursTab a').removeClass('active');
    $(this).addClass('active');
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


$('#sendPhone input[type=submit]').on('click', function (e) {
    e.preventDefault();
    $('#sendPhone').html('<div class="popular-tours-item-title">Заявка отправлена</div><p>Благодарим за обращение</p>');
});

// Points title auto complete input
$("#tourPoint").autocomplete({
    source: "/search/autocomplete",
    minLength: 3,
    select: function (event, ui) {
        $('#tourPoint').val(ui.item.value);
    }
});