@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить сео
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Сео', 'Добавить сео'], 'metronic') !!}
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
                    $link = isset($item) ? url('admin/seo/'.$item->id) : url('admin/seo') ;
                @endphp

                <form action="{{ $link }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if(isset($item))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="url">Ссылка</label>
                            <input type="text" class="form-control m-input m-input--square" id="url" name="url"
                                   value="{{$item->url or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="pTitle">Заголовок h1 на странице</label>
                            <input type="text" class="form-control m-input m-input--square" id="pTitle" name="pTitle" value="{{$item->pTitle or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="bTitle">Title (Заголовок в браузере)</label>
                            <input type="text" class="form-control m-input m-input--square" id="bTitle" name="bTitle" value="{{$item->bTitle or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="metaKey">Ключевые слова</label>
                            <textarea class="form-control m-input m-input--square" name="metaKey">{{$item->metaKey or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="metaDesc">Описание для поисковиков</label>
                            <textarea class="form-control m-input m-input--square" name="metaDesc">{{$item->metaDesc or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-12 col-xs-12">
                            <label for="subText">Текст сбоку</label>
                            <textarea class="summernote" class="form-control m-input m-input--square" name="subText">{{$item->subText or ''}}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/seo')}}" class="btn btn-danger">Отмена</a>
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

        Dropzone.options.wayDropzone = {

            dictRemoveFile: "Удалить",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': $('meta[name="token"]').attr('content')
            },

            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("id", '{{$item->id or ""}}');
                formData.append("ess", 'ToursTagsValues');
            },

            init: function () {

                thisDropzone = this;

                $.ajax({
                    url: "{{route('image.get')}}",
                    cache: false,
                    data: {
                        id: '{{$item->id or ""}}',
                        ess: 'ToursTagsValues'
                    },
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
                        url: "{{route('image.remove')}}",
                        cache: false,
                        data: {id: '{{$item->id or ""}}', name: file.name, ess: 'ToursTagsValues'},
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
