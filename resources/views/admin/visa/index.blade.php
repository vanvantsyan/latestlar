@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Визы
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Визы'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Список виз
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
                            <a href="{{url('admin/visa/create')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-cart-plus"></i>
                                    <span>
                                        Добавить визу
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

    @php $visas = json_encode($visas, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) @endphp
    <script type="text/javascript">
        var DatatableMenu = function() {
            var e = function() {
                var e = JSON.parse('<?php echo $visas; ?>')
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
                        title: "Страна",
                        template: function(e){
                            return e.countries.country;
                        }
                    }, {
                        field: "time",
                        title: "Срок оформления",
                    }, {
                        field: "amount",
                        title: "Стоимость",
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
                                '<a class="dropdown-item" href="/admin/visa/'+e.id+'"><i class="la la-edit"></i> Редактировать</a>' +
                                '<a class="dropdown-item" href="/admin/visa/delete?id='+e.id+'" onclick="confirm(\'Вы уверены что желаете удалить визу\')"><i class="la la-trash"></i> Удалить' +
                                '</a></div></div>' +
                                '<a href="/admin/visa/'+e.id+'/edit" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View ">' +
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