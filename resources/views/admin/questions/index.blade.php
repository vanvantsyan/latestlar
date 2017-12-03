@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Вопросы
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Вопросы'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Список вопросов
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="m_form_search">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="{{url('admin/questions/create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-cart-plus"></i>
                                    <span>
                                        Добавить вопрос
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <div class="m_datatable" id="local_data"></div>

            </div>
        </div>
    </div>

@endsection


@section('js')
    @parent

    @if(Session::get('message'))
        <script>
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

            toastr.success("{{Session::get('message')}}");
        </script>
    @endif

    <script type="text/javascript">
        var DatatableMenu = function() {
            var e = function() {
                var e = JSON.parse('<?php echo $questions ?>')
                    , a = $(".m_datatable").mDatatable({
                    data: {
                        type: "local",
                        source: e,
                        pageSize: 10
                    },
                    layout: {
                        theme: "default",
                        class: "",
                        scroll: !1,
                        height: 450,
                        footer: !1
                    },
                    sortable: !0,
                    filterable: !1,
                    pagination: !0,
                    columns: [{
                        field: "id",
                        title: "#ID",
                        width: 50,
                        sortable: !1,
                        selector: !1,
                        textAlign: "center"
                    }, {
                        field: "question",
                        title: "Вопрос"
                    }, {
                        field: "name",
                        title: "Имя"
                    }, {
                        field: "answer",
                        title: "Ответ",
                        template: function(e){
                            if(e.answer === null){
                                return '<span class="m-badge  m-badge--danger m-badge--wide">Нет</span>';
                            }else{
                                return '<span class="m-badge  m-badge--success m-badge--wide">Да</span>';
                            }
                        }
                    }, {
                        field: "show",
                        title: "Опубликован",
                        template: function(e){
                            if(e.show === 0){
                                return '<span class="m-badge  m-badge--danger m-badge--wide">Нет</span>';
                            }else{
                                return '<span class="m-badge  m-badge--success m-badge--wide">Да</span>';
                            }
                        }
                    }, {
                        field: "created_at",
                        title: "Дата публикации",
                    }, {
                        field: "Actions",
                        width: 110,
                        title: "Actions",
                        sortable: !1,
                        overflow: "visible",
                        template: function(e) {
                            return '<div class="dropdown ' + (e.getDatatable().getPageSize() - e.getIndex() <= 4 ? "dropup" : "") + '">' +
                                '<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                ' +
                                '<i class="la la-ellipsis-h"></i>' +
                                '</a><div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item" href="/admin/questions/'+e.id+'/edit"><i class="la la-edit"></i> Редактировать</a>' +
                                '<a class="dropdown-item" href="/admin/questions/delete?id='+e.id+'"><i class="la la-print"></i> Удалить' +
                                '</a></div></div>' +
                                '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">' +
                                '<i class="la la-edit"></i></a>'
                        }
                    }]
                })
                    , i = a.getDataSourceQuery();
                $("#m_form_search").on("keyup", function(e) {
                    a.search($(this).val().toLowerCase())
                }).val(i.generalSearch),
                    $("#m_form_status").on("change", function() {
                        a.search($(this).val(), "Status")
                    }).val(void 0 !== i.Status ? i.Status : ""),
                    $("#m_form_type").on("change", function() {
                        a.search($(this).val(), "Type")
                    }).val(void 0 !== i.Type ? i.Type : ""),
                    $("#m_form_status, #m_form_type").selectpicker()
            };
            return {
                init: function() {
                    e()
                }
            }
        }();
        jQuery(document).ready(function() {
            DatatableMenu.init()
        });
    </script>

@endsection
