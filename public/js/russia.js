
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
}

$('#toursTab a').click(function (e) {
    $('#toursTab a').removeClass('active');
    $(this).addClass('active');
})

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


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