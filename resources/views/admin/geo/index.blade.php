@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Страны
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'ГЕО'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Список стран
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">

                @if(Session::get('message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{Session::get('message')}}</strong>
                    </div>
                @endif

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
                            <a href="{{ url('admin/geo/create') }}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Добавить страны
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

    <script type="text/javascript">
        let countries = @json($countries);
        var DatatableMenu = function() {
            var e = function() {
                var e = countries
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
                        field: "country",
                        title: "Страна"
                    }, {
                        field: "website",
                        title: "Website",
                        responsive: {
                            visible: "lg"
                        }
                    }, {
                        field: "phone",
                        title: "Phone"
                    }, {
                        field: "Actions",
                        width: 110,
                        title: "Действия",
                        sortable: !1,
                        overflow: "visible",
                        template: function(e) {
                            return '<div class="dropdown ' + (e.getDatatable().getPageSize() - e.getIndex() <= 4 ? "dropup" : "") + '">' +
                                '<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                ' +
                                '<i class="la la-ellipsis-h"></i>' +
                                '</a><div class="dropdown-menu dropdown-menu-right">' +
                                '<a class="dropdown-item" href="/admin/geo/'+e.id+'/edit"><i class="la la-edit"></i> Редактировать / Добавить города</a>' +
                                '<a class="dropdown-item" href="/admin/geo/delete?id='+e.id+'"><i class="la la-trash"></i> Удалить' +
                                '</a></div></div>' +
                                '<a href="/admin/geo/'+e.id+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">' +
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