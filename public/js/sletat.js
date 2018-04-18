$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#sletatForm form').submit(function (e) {
    e.preventDefault();

    var data = $(this).serializeArray();

    console.info('Request on server');

    // Request on server
    $.ajax({
        url: "/sletat/getTours",
        cache: false,
        data: data,
        type: "POST",
        dataType: "json"

    }).done(function (response) {


        var requestId = response.GetToursResult.Data.requestId;

        console.info('get response id = ' + requestId);

        var end;
        for (var i = 0, end = false; i < 30; i++) {

            if (end) break;

            (function (i, end) {
                var requestCycle = setTimeout(function () {

                    // Request on server
                    $.ajax({
                        url: "/sletat/getStatus",
                        cache: false,
                        data: {'requestId': requestId},
                        type: "POST",
                        dataType: "json"

                    }).done(function (processed) {

                        console.info('processed: ' + processed * 100 + ' % iteration — ' + i);

                        // If 100% processed
                        if (processed == 1) {

                            end = true;

                            clearTimeout(requestCycle);

                            data.push({
                                'requestId': requestId,
                                'updateResult': 1
                            });
                            console.info(" — finish — ");
                            console.log(data);

                            // Request on server
                            $.ajax({
                                url: "/sletat/getTours",
                                cache: false,
                                data: data,
                                type: "POST",
                                dataType: "json"

                            }).done(function (data) {
                                // console.log(data)
                            });
                            console.log('finish end - ' + end);
                            this.end = end;
                        }

                    }).error(function () {
                        // If errors
                    });

                    console.log(end);
                    if (end) return false;
                }, i * 2000)
            })(i, end);
        }

        // This code get result data aa[]

    }).error(function () {
        // If errors
    });

    return false;
});

// If change element checkbox, change checkbox selectAll
$('.allChecked input').on('change', function () {

    if ($(this).is(':checked')) {
        var block = $(this).closest('.tour-filter-item');
        block.find('input[type=checkbox]:not([data-check=all])').removeAttr("checked");
    }

});

// If change checkbox remove checked for selectAll
$('input[type=checkbox]:not([data-check=all])').on('change', function () {

    var block = $(this).closest('.tour-filter-item');

    if ($(this).is(':checked')) {
        block.find('.allChecked input').removeAttr('checked');
    } else {

        if (!block.find('input[type=checkbox]:checked').length) {
            console.log(block.find('.allChecked input'));
            block.find('.allChecked input').prop('checked', true);
        }
    }
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