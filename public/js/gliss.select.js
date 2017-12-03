var gliss = gliss || {};

gliss.select = (function($){

    this.getCities = function(elm){

        var cid = $(elm).val();

        $.ajax({
            url: '/admin/geo/get-cities',
            data: {
                'country_id': cid
            }
        })
            .done(function(response){
                $('.js__cities').html(response);
            });

    };

    return this;

}).call(gliss.select || {}, jQuery);