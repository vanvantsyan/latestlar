@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Точки назначения
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Точки назначения'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Точки назначения
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
                                        <input type="text" class="form-control m-input m-input--solid" placeholder="Поиск..." id="pointsSearch" @isset($text) value="{{$text}}@endif">
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
                            <a href="{{url('admin/points/create')}}"
                               class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                <span>
                                    <i class="la la-cart-plus"></i>
                                    <span>
                                        Добавить точку назначения
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
                            <th data-field="title" class="m-datatable__cell m-datatable__cell--sort"><span
                                        style="width: 488px;">URL</span></th>
                            <th data-field="Actions" class="m-datatable__cell m-datatable__cell--sort"><span
                                        style="width: 110px;">Действие</span></th>
                        </tr>
                        </thead>
                        <tbody class="m-datatable__body" style="">
                        @foreach($points as $point)
                            <tr data-row="0" class="m-datatable__row m-datatable__row--even">
                                <td data-field="id" class="m-datatable__cell--center m-datatable__cell">
                                    <span style="width: 50px;">{{$point->id}}</span>
                                </td>
                                <td data-field="title" class="m-datatable__cell">
                                    <span style="width: 488px;">{{$point->title}}</span>
                                </td>
                                <td data-field="url" class="m-datatable__cell">
                                    <span style="width: 488px;">{{$point->url}}</span>
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
                                            <a class="dropdown-item" href="/admin/points/{{$point->id}}/edit">
                                                <i class="la la-edit"></i> Редактировать
                                            </a>
                                            <a class="dropdown-item" href="#" data-target="#m_modal" data-toggle="modal"
                                               onclick="$('#m_modal form').attr('action', '/admin/points/' + '{{$point->id}}')">
                                                <i class="la la-trash"></i> Удалить
                                            </a>
                                        </div>
                                    </div>
                                    <a href="/admin/points/{{$point->id}}/edit"
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
                        {{$points->appends(['text' => $text ?? ""])->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                {{ csrf_field() }}

                <input type="hidden" name="_method" value="delete">
           
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удаление точки назначения</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно желаете удалить точку назначения?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Отмена
                    </button>
                    <input type="submit" class="btn btn-primary" value="Удалить">
                </div>
            </div>
            </form>
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
    
    <script>
        $(function () {
            
            function debounce(callback, time) {
                let timeout;
                
                return function () {
                    let context = this;
                    let args = arguments;
                    
                    let later = function () {
                        timeout = null;
                        callback.apply(context, args);
                    }
                    clearTimeout(timeout);
                    timeout = setTimeout(later, time);
                }
            }
            
            $('#pointsSearch').on('keyup', debounce(function (e) {
                var text = $(this).val();
                // Request on server
                $.ajax({
                    url: "/admin/points/search",
                    cache: false,
                    data: {text: text},
                    type: "POST",

                }).done(function (data) {

                    $('#local_data').html(data);

                });
                
            }, 500));
        })
    </script>

@endsection
