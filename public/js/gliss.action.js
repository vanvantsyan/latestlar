var gliss = gliss || {};

gliss.action = (function($){

    this.entryVerify = function(elm, id){

        $.ajax({
            url: '/admin/entries/verify',
            data: {
                'id': id
            }
        })
            .done(function(response){
                var res = JSON.parse(response);
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.success(res.message);
                $('.close__modal').click();
            });

    };


    this.saveSortable = function(elm, id){

        var ids = '';
        $('.m-portlet--sortable').each(function(i,e){

            ids += $(e).data('id')+',';

        });

        $.ajax({
            url: '/admin/surveys/save-sortable',
            data: {
                'sort': ids,
                'id': id
            }
        })
            .done(function(response){
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                toastr.success("Sort successfully saved. You will now be redirected to the survey page");
                setTimeout(function(){
                    window.location.href = "/admin/surveys"
                }, 3000)
            });

    };

    return this;

}).call(gliss.action || {}, jQuery);