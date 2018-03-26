/* Admin artisans script */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#tourSearch').on('keyup', function (e) {
    var text = $(this).val();


    // Request on server
    $.ajax({
        url: "/admin/tours/search",
        cache: false,
        data: {text: text},
        type: "POST",

    }).done(function (data) {

        $('#local_data').html(data);

    });


})