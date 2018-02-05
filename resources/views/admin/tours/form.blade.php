@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить тур
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Туры', 'Добавить тур'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                @if(Session::get('message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{Session::get('message')}}</strong>
                    </div>
                @endif

                @php
                    $link = isset($item) ? url('admin/tours/'.$item->id) : url('admin/tours') ;
                @endphp

                <form action="{{ $link }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if(isset($item))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    {{--<div class="form-group m-form__group row">--}}
                    {{--<div class="col-md-6 col-xs-12">--}}
                    {{--<select name="category_id" id="" class="form-control">--}}
                    {{--<option value="" selected disabled="">Выберите категорию</option>--}}
                    {{--@forelse($categories as $category)--}}
                    {{--<option value="{{$category->id}}" @if(isset($item) && $item->category_id == $category->id) selected @endif>{{$category->title}}</option>--}}
                    {{--@empty--}}
                    {{--@endforelse--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="title">Заголовок тура</label>
                            <input type="text" class="form-control m-input m-input--square" id="title" name="title"
                                   value="{{$item->title or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-6">
                            <label for="price">Цена тура</label>
                            <input type="text" class="form-control m-input m-input--square" id="price" name="price"
                                   value="{{$item->price or ''}}">
                        </div>

                        <div class="col-md-6 col-xs-6">
                            <label for="price">Количество дней тура</label>
                            <input type="text" class="form-control m-input m-input--square" id="price" name="price"
                                   value="{{$item->duration or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="">Краткое описание</label>
                            <textarea class="summernote" name="description">{{$item->description or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="">Полное описание</label>
                            <textarea class="summernote" name="text">{{$item->text or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-12 col-md-9 col-sm-12">
                            <label class="">
                                Загрузить изображение
                            </label>
                            <div class="m-dropzone dropzone dz-clickable" action="{{url('/tour/uploadImage')}}"
                                 id="tour-dropzone">

                                <div class="m-dropzone__msg dz-message needsclick"
                                     @if(isset($item) && !empty($item->image)) style="display: none;" @endif>
                                    <h3 class="m-dropzone__msg-title">
                                        Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                    </h3>
                                </div>
                                {{--@if(isset($item) && count($images))--}}


                                {{--@foreach($images as $img)--}}
                                {{--<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">--}}
                                {{--<div class="dz-image">--}}
                                {{--<img data-dz-thumbnail="{{asset('/img/tours/thumb/'. $imgFolder . "/".$img)}}"--}}
                                {{--alt="{{$img}}"--}}
                                {{--src="{{asset('/img/tours/full/'. $imgFolder . "/".$img)}}"--}}
                                {{--style="height:100px;">--}}
                                {{--</div>--}}
                                {{--<a class="dz-remove" href="javascript:undefined;"--}}
                                {{--data-dz-remove="">Удалить</a>--}}
                                {{--</div>--}}
                                {{--@endforeach--}}


                                {{--@endif--}}
                            </div>
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
                                   name="seo_title" value="{{$item->seo_title or ''}}">
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keywords">SEO keywords</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_keywords"
                                   name="seo_keywords" value="{{$item->seo_keywords or ''}}">
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="url">URL</label>
                            <input type="text" class="form-control m-input m-input--square" id="url" name="url"
                                   value="{{$item->url or ''}}">
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">SEO Description</label>
                            <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc"
                                      rows="5">{{$item->seo_desc or ''}}</textarea>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/tours')}}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent

    <script type="text/javascript"
            src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js')}}"></script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Dropzone.options.tourDropzone = {

            dictRemoveFile: "Удалить",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': $('meta[name="token"]').attr('content')
            },

            sending: function(file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("tourId", '{{$item->id}}');
            },

            init: function () {

                thisDropzone = this;

                $.ajax({
                    url: "/tour/getImage",
                    cache: false,
                    data: {id: '{{$item->id}}'},
                    type: "POST",
                }).done(function (data) {

                    $.each($.parseJSON(data), function (key, value) {
                        var mockFile = {name: value.name, size: value.size};

                        thisDropzone.emit('addedfile', mockFile);
                        thisDropzone.emit('thumbnail', mockFile, value.thumb);
                        thisDropzone.emit("complete", mockFile);
                    });
                });

                thisDropzone.on("thumbnail", function (file, dataUrl) {
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
                });

                thisDropzone.on("success", function (file, response) {
                    file.serverId = response;
                });

                thisDropzone.on("removedfile", function (file) {

                    if (!file.name) {
                        return;
                    }

                    $.ajax({
                        url: "/tour/removeImage",
                        cache: false,
                        data: {id: '{{$item->id}}', name: file.name},
                        type: "POST",
                    }).done(function (data) {

                        $.each($.parseJSON(data), function (key, value) {
                            var mockFile = {name: value.name, size: value.size};

                            thisDropzone.emit('addedfile', mockFile);
                            thisDropzone.emit('thumbnail', mockFile, value.thumb);
                            thisDropzone.emit("complete", mockFile);
                        });

                    });

                });
            },

        }
    </script>
@endsection
