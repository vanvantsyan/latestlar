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

// See all photos of the tour

$('#tourImagesModal').on('show.bs.modal', function (e) {

    var tourId = $(e.relatedTarget).attr('data-tour-id');

    var images = $(e.relatedTarget).attr('data-images');
    var slideBlock = '';

    var slideContainer = ".carousel-inner";
    var indicators = '';

    $.each($.parseJSON(images), function (key, value) {

        if (key == 0) active = "active"; else active = '';
        slideBlock += "<div class='item " + active + "'> <img src=\'/img/tours/full/" + tourId.substr(0, 2) + "/" + value + "'></div>";

        indicators += "<li data-target=\"#tourImagesCarousel\" data-slide-to='" + key + "' class='" + active + "'></li>";
    });

    $(slideContainer).html(slideBlock);
    $('.carousel-indicators').html(indicators);
});


$("#tourPoint").on('keyup', function (event) {

    var s = $("#tourPoint").val();
    //String.fromCharCode(event.keyCode || event.charCode);

    if (!/^[а-яё ]*$/i.test(s)) {
        $("#tourPoint").val(autoKeyboardLang(s));
    }
});

// Points title auto complete input
$("#tourPoint").autocomplete({
    source: "/search/autocomplete",
    minLength: 3,
    select: function (event, ui) {

        $('#tourPoint').val(ui.item.value);
    }
});

// Insert point
$('.search-completed-item-route a').on('click', function (e) {
    e.preventDefault();
    var point = $(this).text();

    $('#tourPoint').attr('value', point.trim(','));

    $('#filterTours').trigger('click');
});


// Set hidden fields
$('#tourOrderModal').on('show.bs.modal', function (e) {
    var target = $(e.relatedTarget);
    var tourBlock = target.closest('.search-completed-item');
    if (tourBlock.length) {
        var tourName = tourBlock.find('.search-completed-item-preview .search-completed-item-title').text();

        var route = (tourBlock.find('.search-completed-item-route').html()).trim();
        var href = tourBlock.find('.btn-blue').attr('href');
        var source = "magput";
        var date = target.data('date');

        $('input[name=source]').attr('value', source);
        $('input[name=href]').attr('value', 'http://russia.startour.ru' + href);
        $('input[name=tourName]').attr('value', tourName);
        $('input[name=route]').attr('value', route);

        $('#tourName').html('"<strong>' + tourName + '</strong>"');
        if (date)
            $('#tourDateOrder').text('на ' + date);
    }
    else {
        $('input[name=source]').attr('value', '');
        $('input[name=href]').attr('value', '');
        $('input[name=tourName]').attr('value', '');
        $('input[name=route]').attr('value', '');
        $('#tourName').html('');
        $('#tourDateOrder').html('');
    }
});

// Send order
$('#tourOrderModal .modal-footer a:last-child').on('click', function (e) {

    e.preventDefault();

    var data = {};
    $.each($('#tourOrderModal form').serializeArray(), function (i, field) {
        if (field.value) data[field.name] = field.value;
    });

    // Request on server
    $.ajax({
        url: "/tour/order",
        cache: false,
        data: data,
        type: "POST",

    }).done(function (data) {

        $('#tourOrderModal form span').text("");

        if (!data.ok && data.errors) {

            $.each(data.errors, function (key, value) {

                $('#' + key + ' span').addClass("red");
                $('#' + key + ' span').text(value);
            })
        } else {
            $('#tourOrderModal .modal-footer').remove();
            $('#tourOrderModal .modal-body').html("<p style='text-align: center' class=\"alert alert-success\">" + data.message + "</p>");
            setTimeout(function () {
                $('#tourOrderModal').modal('hide')
            }, 3000);
        }

    }).error(function () {
        // If errors
    });
});

$('.search-completed-item-date a:not(.all-dates)').on({

    mouseenter: function () {
        $(this).text('Заказать');
        $(this).addClass('order');
    },
    mouseleave: function () {

        var tourDate = $(this).attr('data-date');

        $(this).text(moment(tourDate, 'D.M.Y').format('DD.MM.YY'));
        $(this).removeClass('order');
    },
    click: function (e) {
        e.preventDefault();

        var tourDate = $(this).attr('data-date');
        $('input[name=tourDate]').attr('value', moment(tourDate, 'D.M.Y').format('DD.MM'));

        // $('#tourOrderModal').modal('show');
    }

});
