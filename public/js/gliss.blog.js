var gliss = gliss || {};

gliss.blog = ( function($) {

    this.addStep = function(){

        var step = $('.step').last().clone();
        $(step).find('.note-editor').remove();
        $(step).find('textarea').val('').summernote();
        $(step).find('input').val('');

        var attr_id = $(step).find('.m-dropzone').attr('id');
        attr_id = Number(attr_id.replace('m-dropzone-', ''));

        if(attr_id === 5){
            $(step).find('a.btn').remove();
            return false;
        }else{
            attr_id++;
        }

        $(step).find('.m-dropzone').removeAttr('id').attr('id', 'm-dropzone-'+attr_id);

        $('.blog_step').append(step);

        $('#m-dropzone-'+attr_id).dropzone();

    };

    return this;

}).call(gliss.blog || {}, jQuery);