var gliss = gliss || {};

gliss.geo = (function($){

    this.setDataCity = function(city_id, city_name){

        $('.city__title').html('"'+city_name+'"');
        $('.del__city').attr('href', '/admin/geo/city/'+city_id+'/delete');

    };

    return this;

}).call(gliss.geo || {}, jQuery);