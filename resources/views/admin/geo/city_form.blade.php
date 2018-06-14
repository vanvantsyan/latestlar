@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Редактирование города
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'GEO', 'Редактирование города'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/geo/city/'.$city->id)}}" method="POST" class="m-form m-form--fit m-form--label-align-right">

                    {{csrf_field()}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group">
                                <label for="city">Название города</label>
                                <input id="city" class="form-control" name="city" required value="{{$city->city or ''}}">
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label class="">
                                        Загрузить изображение
                                    </label>
                                    <div class="m-dropzone dropzone dz-clickable" action="{{url('images/upload')}}" id="m-dropzone-one">
                                        <div class="m-dropzone__msg dz-message needsclick" @if(isset($city) && !empty($city->image)) style="display: none;" @endif>
                                            <h3 class="m-dropzone__msg-title">
                                                Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                            </h3>
                                        </div>
                                        @if(isset($city) && !empty($city->image))
                                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                                <div class="dz-image">
                                                    <img data-dz-thumbnail="" alt="" src="{{asset('uploads/news/'.$city->image)}}" style="height:100px;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="">Описание</label>
                                    <textarea class="rich-editor" name="description">{{$city->description or ''}}</textarea>
                                </div>
                            </div>

                            <br>
                            <div class="col-md-12">
                                <h5>SEO</h5>
                            </div>
                            <hr>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_title">SEO title</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" value="{{$city->seo_title or ''}}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_h1">SEO h1</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_h1" name="seo_h1" value="{{$city->seo_h1 or ''}}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_desc">SEO Description</label>
                                    <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" rows="5">{{$city->seo_desc or ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_keywords">SEO keywords</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_keywords" name="seo_keywords" value="{{$city->seo_keywords or ''}}">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="slug">SLUG</label>
                                    <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" value="{{$city->slug or ''}}">
                                </div>
                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button class="btn btn-success" type="submit">Save</button>
                                    <a href="{{url('admin/geo')}}" class="btn btn-danger" name="action">Cancel</a>
                                </div>
                            </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Confirm city deletion
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Do you really want to delete the city of <span class="city__title"></span> from the list of cities?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <a href="#" class="btn btn-primary del__city">
                        Delete
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

    <script type="text/javascript" src="{{asset('js/gliss.geo.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>
@endsection