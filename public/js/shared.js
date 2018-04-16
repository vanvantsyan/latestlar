function autoKeyboardLang(str) {
    var s = [
        "й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ",
        "ф", "ы", "в", "а", "п", "р", "о", "л", "д", "ж", "э",
        "я", "ч", "с", "м", "и", "т", "ь", "б", "ю"
    ];

    var r = [
        "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "\\[", "\\]",
        "a", "s", "d", "f", "g", "h", "j", "k", "l", ";", "'",
        "z", "x", "c", "v", "b", "n", "m", ",", "\\."
    ];

    for (var i = 0; i < r.length; i++) {
        var reg = new RegExp(r[i], 'mig');
        str = str.replace(reg, function (a) {
            return a == a.toLowerCase() ? s[i] : s[i].toUpperCase();
        });
    }

    return str;
}


$("#sendPhone input[type=text]").mask("+7 (999) 999-99-99"); //+7 (095) 322-44-54


$('#sendPhone input[type=submit]').on('click', function (e) {

    e.preventDefault();

    var data = {};
    $.each($('#sendPhone form').serializeArray(), function (i, field) {
        if (field.value) data[field.name] = field.value;
    });

    // Request on server
    $.ajax({
        url: "/tour/phone",
        cache: false,
        data: data,
        type: "POST",
    }).done(function (data) {


        if (!data.ok && data.errors) {

            $.each(data.errors, function (key, value) {
                console.info(key);
                $('#' + key + '').addClass("has-error");
                setTimeout(function () {
                    $('#' + key + '').removeClass("has-error")
                }, 3000);
                // $('#' + key + '').text(value);
            });

        } else {
            $('#sendPhone').html('<div class="popular-tours-item-title">Заявка отправлена</div><p>Благодарим за обращение</p>');
        }
    }).error(function () {
        // If errors
    });

    return false;
});

function closeSortList() {
    $('.tours-sorting-items').toggleClass('active');
    $('body').toggleClass('sort-open');
};


$('.tours-sorting a span').on('click', function (e) {

    e.preventDefault();
    $('.tours-sorting-items').toggleClass('active');

    $('body').toggleClass('sort-open');

    if ($('body').hasClass('sort-open')) {
        e.stopPropagation();

        $('body.sort-open').on('click', function () {
            $('.tours-sorting span')[0].click();
        });
    } else {
        $('body').off();
    }


});

$('.tours-sorting a b').on('click', function (e) {

    e.preventDefault();
    $('.tours-sorting-items').toggleClass('active');

    $('body').toggleClass('sort-open');

    if ($('body').hasClass('sort-open')) {
        e.stopPropagation();

        $('body.sort-open').on('click', function () {
            $('.tours-sorting span').trigger('click');
        });
    } else {
        $('body').off();
    }

});


$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

moment.locale('ru');

$('#durationFrom').on('change', function (e) {
    var opt = $(this).val();
    $('#durationTo-styler li').show();
    while (opt--) {
        $('#durationTo-styler li:eq(' + opt + ')').hide();
    }
});
$('#durationTo').on('change', function (e) {

    var opt = $(this).val() - 2;
    $('#durationFrom-styler li').show();

    while ((opt++) < 15) {
        $('#durationFrom-styler li:eq(' + opt + ')').hide();
    }
});


$(document).ready(function () {
    var opt = $('#durationFrom').val();
    $('#durationTo-styler li').show();
    while (opt--) {
        $('#durationTo-styler li:eq(' + opt + ')').hide();
    }

    var opt = $('#durationTo').val() - 2;
    $('#durationFrom-styler li').show();

    while ((opt++) < 15) {
        $('#durationFrom-styler li:eq(' + opt + ')').hide();
    }
});


$('#dateFilterToggle').on('click', function () {

    if ($(this).hasClass('off')) {
        $(this).text('выключить')
    }

    if ($(this).hasClass('on')) {
        $(this).text('включить')
    }

    $(this).toggleClass("on", "off");
    $('#tourDate').prop('disabled', function (i, v) {
        return !v;
    });
});
