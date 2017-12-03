var gliss = gliss || {};

gliss.visa = (function($){

    this.addDocs = function(){

        var count = $('.step').length;

        $('.add_docs').append('' +
            '<div class="step"><div class="form-group m-form__group row">' +
            '<div class="col-md-6 col-xs-12">' +
            '<label for="seo_title">Название блока</label>' +
            '<input type="text" class="form-control m-input m-input--square" name="add_docs['+count+'][name]">' +
            '</div></div>' +
            '<div class="form-group m-form__group row">' +
            '<div class="col-md-6 col-xs-12">' +
            '<label for="">Описание</label>' +
            '<textarea class="summernote" name="add_docs['+count+'][text]"></textarea>' +
            '</div></div></div>' +
            '').find($('textarea')).last().summernote();

        return false;

    };

    return this;

}).call(gliss.visa || {}, jQuery);