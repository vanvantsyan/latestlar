@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Туры
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Туры'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Список туров
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
                                        <input type="text" class="form-control m-input m-input--solid"
                                               placeholder="Search..." id="m_form_search">
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
                            {{--<a href="{{url('admin/tours/categories')}}"--}}
                            {{--class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">--}}
                            {{--<span>--}}
                            {{--<i class="la la-list"></i>--}}
                            {{--<span>--}}
                            {{--Категории--}}
                            {{--</span>--}}
                            {{--</span>--}}
                            {{--</a>--}}
                            <a href="{{url('admin/tours/create')}}"
                               class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-cart-plus"></i>
                                    <span>
                                        Добавить Тур
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>

                <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded" id="local_data" style="">
                    <table class="m-datatable__table" style="display: block; height: auto; overflow-x: auto;"
                           id="m-datatable--387278780463">
                        <thead class="m-datatable__head">
                        <tr class="m-datatable__row">
                            <th data-field="id"
                                class="m-datatable__cell--center m-datatable__cell m-datatable__cell--sort"><span
                                        style="width: 50px;">#ID</span></th>
                            <th data-field="title" class="m-datatable__cell m-datatable__cell--sort"><span
                                        style="width: 488px;">Заголовок</span></th>
                            <th data-field="Actions" class="m-datatable__cell m-datatable__cell--sort"><span
                                        style="width: 110px;">Действие</span></th>
                        </tr>
                        </thead>
                        <tbody class="m-datatable__body" style="">
                        @foreach($tours as $tour)
                            <tr data-row="0" class="m-datatable__row m-datatable__row--even">
                                <td data-field="id" class="m-datatable__cell--center m-datatable__cell">
                                    <span style="width: 50px;">{{$tour->id}}</span>
                                </td>
                                <td data-field="title" class="m-datatable__cell">
                                    <span style="width: 488px;">{{$tour->title}}</span>
                                </td>
                                <td data-field="Actions" class="m-datatable__cell">
                                <span style="overflow: visible; width: 110px;">
                                    <div class="dropdown ">
                                        <a href="#"
                                           class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                           data-toggle="dropdown">
                                            <i class="la la-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="/admin/tours/{{$tour->id}}/edit">
                                                <i class="la la-edit"></i> Редактировать
                                            </a>
                                            <a class="dropdown-item" href="#" data-target="#m_modal" data-toggle="modal"
                                               onclick="return $('#m_modal .attr__delete').attr('href', '/admin/tours/delete?id={{$tour->id}}')">
                                                <i class="la la-trash"></i> Удалить
                                            </a>
                                        </div>
                                    </div>
                                    <a href="/admin/tours/{{$tour->id}}/edit"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="View ">
                                        <i class="la la-edit"></i>
                                    </a>
                                </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                        <ul class="m-datatable__pager-nav">
                            <li><a title="First"
                                   class="m-datatable__pager-link m-datatable__pager-link--first m-datatable__pager-link--disabled"
                                   data-page="1" disabled="disabled"><i class="la la-angle-double-left"></i></a></li>
                            <li><a title="Previous"
                                   class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled"
                                   data-page="1" disabled="disabled"><i class="la la-angle-left"></i></a></li>
                            <li style="display: none;"><a title="More pages"
                                                          class="m-datatable__pager-link m-datatable__pager-link--more-prev"
                                                          data-page="1"><i class="la la-ellipsis-h"></i></a></li>
                            <li style="display: none;"><input class="m-pager-input form-control" title="Page number"
                                                              type="text"></li>
                            <li>
                                <a class="m-datatable__pager-link m-datatable__pager-link-number m-datatable__pager-link--active"
                                   data-page="1" title="1">1</a></li>
                            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="2"
                                   title="2">2</a></li>
                            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="3"
                                   title="3">3</a></li>
                            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="4"
                                   title="4">4</a></li>
                            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="5"
                                   title="5">5</a></li>
                            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="6"
                                   title="6">6</a></li>
                            <li><a title="More pages" class="m-datatable__pager-link m-datatable__pager-link--more-next"
                                   data-page="7"><i class="la la-ellipsis-h"></i></a></li>
                            <li><a title="Next" class="m-datatable__pager-link m-datatable__pager-link--next"
                                   data-page="2"><i class="la la-angle-right"></i></a></li>
                            <li><a title="Last" class="m-datatable__pager-link m-datatable__pager-link--last"
                                   data-page="306"><i class="la la-angle-double-right"></i></a></li>
                        </ul>
                        <div class="m-datatable__pager-info">
                            <div class="btn-group bootstrap-select m-datatable__pager-size" style="width: 70px;">
                                <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown"
                                        role="button" title="Select page size"><span
                                            class="filter-option pull-left">10</span>&nbsp;<span class="bs-caret"><span
                                                class="caret"></span></span></button>
                                <div class="dropdown-menu open" role="combobox">
                                    <ul class="dropdown-menu inner" role="listbox" aria-expanded="false">
                                        <li data-original-index="1" class="selected"><a tabindex="0" class=""
                                                                                        data-tokens="null" role="option"
                                                                                        aria-disabled="false"
                                                                                        aria-selected="true"><span
                                                        class="text">10</span><span
                                                        class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                        <li data-original-index="2"><a tabindex="0" class="" data-tokens="null"
                                                                       role="option" aria-disabled="false"
                                                                       aria-selected="false"><span
                                                        class="text">20</span><span
                                                        class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                        <li data-original-index="3"><a tabindex="0" class="" data-tokens="null"
                                                                       role="option" aria-disabled="false"
                                                                       aria-selected="false"><span
                                                        class="text">30</span><span
                                                        class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                        <li data-original-index="4"><a tabindex="0" class="" data-tokens="null"
                                                                       role="option" aria-disabled="false"
                                                                       aria-selected="false"><span
                                                        class="text">50</span><span
                                                        class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                        <li data-original-index="5"><a tabindex="0" class="" data-tokens="null"
                                                                       role="option" aria-disabled="false"
                                                                       aria-selected="false"><span
                                                        class="text">100</span><span
                                                        class="glyphicon glyphicon-ok check-mark"></span></a></li>
                                    </ul>
                                </div>
                                <select class="selectpicker m-datatable__pager-size" title="Select page size"
                                        data-width="70px" data-selected="10" tabindex="-98">
                                    <option class="bs-title-option" value="">Select page size</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select></div>
                            <span class="m-datatable__pager-detail">Displaying 1 - 10 of 3058 records</span></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Удаление тура
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Вы действительно желаете удалить тур?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Отмена
                    </button>
                    <a href="#" class="btn btn-primary attr__delete">
                        Удалить
                    </a>
                </div>
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


@endsection
