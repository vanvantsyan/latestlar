@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Редактировать страну
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'ГЕО', 'Редактировать страну'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/geo/'.$country->id)}}" method="POST"
                      class="m-form m-form--fit m-form--label-align-right">

                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">

                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_1" role="tab">
                                Страна
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2" role="tab">
                                Описание и СЕО
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_1" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group {{ $errors->has('country') ? ' has-danger' : '' }}">
                                        <label for="country">Название страны</label>
                                        <input id="country" class="form-control" name="country" required
                                               value="{{$country->country}}">
                                        @if($errors->has('country'))
                                            <div class="form-control-feedback">{{$errors->first('country')}}</div>
                                        @endif
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label class="">
                                                Флаг
                                            </label>
                                            <div class="m-dropzone dropzone dz-clickable"
                                                 action="{{route('geo.upload.flag')}}" id="flag-dropzone">
                                                <div class="m-dropzone__msg dz-message needsclick"
                                                     @if(isset($country) && !empty($country->flag)) style="display: none;" @endif>
                                                    <h3 class="m-dropzone__msg-title">
                                                        Перетащите файл изображения сюда или кликните для загрузки с
                                                        компьютера
                                                    </h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label class="">
                                                Статичное изображение вверху страницы
                                            </label>
                                            <div class="m-dropzone dropzone dz-clickable"
                                                 action="{{route('geo.upload.banner')}}" id="banner-dropzone">
                                                <div class="m-dropzone__msg dz-message needsclick"
                                                     @if(isset($country) && !empty($country->banner)) style="display: none;" @endif>
                                                    <h3 class="m-dropzone__msg-title">
                                                        Перетащите файл изображения сюда или кликните для загрузки с
                                                        компьютера
                                                    </h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="form-group m-form__group">--}}
                                    {{--<label for="country">Добавленные города</label><br>--}}
                                    {{--@forelse($country->cities as $city)--}}
                                    {{--<span class="m-badge m-badge--info m-badge--wide" style="margin-top:5px;">--}}
                                    {{--<a style="color:#fff;"--}}
                                    {{--href="{{url('admin/geo/city/'.$city['id'])}}">{{$city['city']}}</a>--}}
                                    {{--<span data-toggle="modal"--}}
                                    {{--onclick="return gliss.geo.setDataCity('{{$city['id']}}', '{{$city['city']}}');"--}}
                                    {{--data-target="#m_modal_1"--}}
                                    {{--style="font-size:14pt;padding-left:10px;cursor:pointer;">&times;</span>--}}
                                    {{--</span>--}}
                                    {{--@empty--}}

                                    {{--@endforelse--}}
                                    {{--</div>--}}

                                    {{--<div class="form-group m-form__group {{ $errors->has('cities') ? ' has-danger' : '' }}">--}}
                                    {{--<label for="cities">Добавить города - {{$country->country}}</label>--}}
                                    {{--<textarea id="cities" class="form-control" name="cities" rows="5"></textarea>--}}
                                    {{--@if($errors->has('cities'))--}}
                                    {{--<div class="form-control-feedback">{{$errors->first('cities')}}</div>--}}
                                    {{--@endif--}}
                                    {{--<span class="m-form__help">--}}
                                    {{--Введите названия городов. Каждый новый город с новой строки--}}
                                    {{--</span>--}}
                                    {{--</div>--}}

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_2" role="tabpanel">

                            <div class="form-group m-form__group row">
                                <div class="col-lg-6 col-md-6 col-sm-9">
                                    <label class="">
                                        Изображения страны
                                    </label>
                                    <div class="m-dropzone dropzone dz-clickable" action="{{route('image.upload')}}"
                                         id="way-dropzone">
                                        <div class="m-dropzone__msg dz-message needsclick"
                                             @if(isset($country) && !empty($country->image)) style="display: none;" @endif>
                                            <h3 class="m-dropzone__msg-title">
                                                Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="">Описание</label>
                                    <textarea class="summernote"
                                              name="description">{{$country->description or ''}}</textarea>
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
                                    <input type="text" class="form-control m-input m-input--square" id="seo_title"
                                           name="seo_title" value="{{$country->seo_title or ''}}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_h1">SEO h1</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_h1"
                                           name="seo_h1" value="{{$country->seo_h1 or ''}}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_desc">SEO Description</label>
                                    <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc"
                                              rows="5">{{$country->seo_desc or ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_keywords">SEO keywords</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_keywords"
                                           name="seo_keywords" value="{{$country->seo_keywords or ''}}">
                                </div>
                            </div>

                            <div class="form-group m-form__group row {{ $errors->has('slug') ? ' has-danger' : '' }}">
                                <div class="col-md-6 col-xs-12">
                                    <label for="slug">SLUG</label>
                                    <input type="text" class="form-control m-input m-input--square" id="slug"
                                           name="slug" value="{{$country->slug or ''}}">
                                    @if($errors->has('slug'))
                                        <div class="form-control-feedback">{{$errors->first('slug')}}</div>
                                    @endif
                                </div>
                            </div>

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

    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Подтвердите удаление города
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Вы действительно жедаете удалить город <span class="city__title"></span> Из списка городов?<br>
                        Восстановить его будет невозможно
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Отмена
                    </button>
                    <a href="#" class="btn btn-primary del__city">
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

    <script type="text/javascript" src="{{asset('js/gliss.geo.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Dropzone.options.wayDropzone = {

            dictRemoveFile: "Удалить",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': $('meta[name="token"]').attr('content')
            },

            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                {{--formData.append("id", '{{$item->id}}');--}}
                {{--formData.append("ess", 'ToursTagsValues');--}}
            },

            init: function () {

                thisDropzone = this;

                        @php
                            $images = json_decode($country->images);

                        @endphp

                        @if(count($images))

                        @php
                            $size = filesize(public_path("uploads/tmp/$images"));
                        @endphp

                var mockFile = {name: '{{$images}}', 'size': '{{$size}}'};

                thisDropzone.emit('addedfile', mockFile);
                thisDropzone.emit('thumbnail', mockFile, '/uploads/tmp/{{$images}}');
                thisDropzone.emit("complete", mockFile);

                @endif

                thisDropzone.on("thumbnail", function (file, dataUrl) {
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
                });

                thisDropzone.on("success", function (file, response) {
                    data = $.parseJSON(response);
                    file.serverId = response;

                    if (data.filename) {
                        $.ajax({
                            url: "{{route('geo.set.image')}}",
                            cache: false,
                            data: {id: '{{$country->id}}', image: data.filename},
                            type: "POST",
                        }).done(function () {
                        });
                    }

                });

                thisDropzone.on("removedfile", function (file) {

                    if (!file.name) {
                        return;
                    }

                    $.ajax({
                        url: "{{route('geo.remove.image')}}",
                        cache: false,
                        data: {id: '{{$country->id}}', name: file.name},
                        type: "POST",
                    }).done(function () {
                    });

                });
            },

        }

        Dropzone.options.flagDropzone = {

            thumbnailWidth: 250,
            // maxFiles: 1,
            dictRemoveFile: "Удалить",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': $('meta[name="token"]').attr('content')
            },

            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                {{--formData.append("id", '{{$item->id}}');--}}
                {{--formData.append("ess", 'ToursTagsValues');--}}
            },

            init: function () {

                thisDropzone = this;

                        @php
                            $image = $country->flag;
                        @endphp

                        @if($image)

                        @php
                            $size = filesize(public_path("uploads/countries/flags/$image"));
                        @endphp

                var mockFile = {name: '{{$image}}', 'size': '{{$size}}'};

                thisDropzone.emit('addedfile', mockFile);
                thisDropzone.emit('thumbnail', mockFile, '/uploads/countries/flags/{{$image}}');
                thisDropzone.emit("complete", mockFile);

                thisDropzone.files.push(mockFile);

                @endif

                thisDropzone.on("thumbnail", function (file, dataUrl) {
                });

                thisDropzone.on("success", function (file, response) {


                    data = $.parseJSON(response);
                    file.serverId = response;

                    if (data.filename) {
                        $.ajax({
                            url: "{{route('geo.set.flag')}}",
                            cache: false,
                            data: {id: '{{$country->id}}', image: data.filename},
                            type: "POST",
                        }).done(function () {
                        });
                    }
                });

                thisDropzone.on("sending", function (file, xhr, formData) {
                    console.log(this.files);
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                });

                thisDropzone.on("removedfile", function (file) {

                    if (!file.name) {
                        return;
                    }

                    $.ajax({
                        url: "{{route('geo.remove.flag')}}",
                        cache: false,
                        data: {id: '{{$country->id}}'},
                        type: "POST",
                    }).done(function () {
                    });

                });
            },

        }

        Dropzone.options.bannerDropzone = {

            thumbnailWidth: 250,
            // maxFiles: 1,
            dictRemoveFile: "Удалить",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': $('meta[name="token"]').attr('content')
            },

            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                {{--formData.append("id", '{{$item->id}}');--}}
                {{--formData.append("ess", 'ToursTagsValues');--}}
            },

            init: function () {

                thisDropzone = this;

                        @php
                            $image = $country->banner;
                        @endphp

                        @if($image)

                        @php
                            $size = filesize(public_path("uploads/countries/banners/$image"));
                        @endphp

                var mockFile = {name: '{{$image}}', 'size': '{{$size}}'};

                thisDropzone.emit('addedfile', mockFile);
                thisDropzone.emit('thumbnail', mockFile, '/uploads/countries/banners/{{$image}}');
                thisDropzone.emit("complete", mockFile);

                thisDropzone.files.push(mockFile);

                @endif

                thisDropzone.on("thumbnail", function (file, dataUrl) {
                });

                thisDropzone.on("success", function (file, response) {


                    data = $.parseJSON(response);
                    file.serverId = response;

                    if (data.filename) {
                        $.ajax({
                            url: "{{route('geo.set.banner')}}",
                            cache: false,
                            data: {id: '{{$country->id}}', image: data.filename},
                            type: "POST",
                        }).done(function () {
                        });
                    }
                });

                thisDropzone.on("sending", function (file, xhr, formData) {
                    console.log(this.files);
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                    }
                });

                thisDropzone.on("removedfile", function (file) {

                    if (!file.name) {
                        return;
                    }

                    $.ajax({
                        url: "{{route('geo.remove.banner')}}",
                        cache: false,
                        data: {id: '{{$country->id}}'},
                        type: "POST",
                    }).done(function () {
                    });

                });
            },

        }
    </script>

@endsection