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

// Expand tour programm
$('.card-schedule .btn-expand').on('click', function() {

    $(this).toggleClass('active');

    $('.card-schedule-day').toggleClass("active");
    $('.card-schedule-day').next().slideToggle();

    if($(this).hasClass('active')){
        $(this).text('Закрыть все')
    } else {
        $(this).text('Раскрыть все')
    }
});

$('.btn-more-dates').on('click', function () {

    $('.card-tour-dates-item').removeClass('hide');
    $(this).addClass('hide');

    return false;
});

// See all photos of the tour
$('#tourImagesModal').on('show.bs.modal', function (e) {

    var imgBlock = $(e.relatedTarget).closest('.card-tour-photo');

    if(!imgBlock.length) {
        imgBlock = $(e.relatedTarget);
    } else {

    }
    var imgActive = $(e.relatedTarget);

    var tourId = imgBlock.attr('data-tour-id');
    var images = imgBlock.attr('data-images');

    var slideBlock = '';

    var slideContainer = ".carousel-inner";
    var indicators = '';
    var active = '';

    $.each($.parseJSON(images), function (key, value) {
        if (imgActive.attr('data-image-id') && key == imgActive.attr('data-image-id')) active = "active"; else active = '';
        slideBlock += "<div class='item " + active + "'> <img src=\'/img/tours/full/" + tourId.substr(0, 2) + "/" + value + "'></div>";

        indicators += "<li data-target=\"#tourImagesCarousel\" data-slide-to='" + key + "' class='" + active + "'></li>";
    });

    $(slideContainer).html(slideBlock);
    $('.carousel-indicators').html(indicators);
});


$('.card-tour-dates-item-day a').on({

    mouseenter: function () {
        $(this).text('Заказать');
        $(this).addClass('order');
    },
    mouseleave: function () {
        $(this).text($(this).attr('data-date'));
        $(this).removeClass('order');
    },
    click: function (e) {

        var tourDate = $(this).attr('data-date');
        $('input[name=tourDate]').attr('value', tourDate);

        e.preventDefault();
        $('#tourOrderModal').modal('show');
    }

});