@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    {{ isset($point) ? 'Создание точки маршрута' : 'Создание периода' }}
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Точки маршрута', isset($point) ? 'Создание точки марштура' : 'Редактирование точки маршрута'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                @if (Session::get('message'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{Session::get('message')}}</strong>
                    </div>
                @endif

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @php
                    $link = isset($point) ? url('admin/points/'.$point->id) : url('admin/points') ;
                @endphp

                <form action="{{ $link }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if(isset($point))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_1" role="tab">
                                Данные точки маршура
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2" role="tab">
                                Отношения
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_1" role="tabpanel">
                            <div class="form-group m-form__group row">
                                <div class="col-md-12 col-xs-12">
                                    <label for="title">Заголовок точки маршрута</label>
                                    <input type="text" class="form-control m-input m-input--square" id="title" name="title" value="{{old('title', $point->title ?? '') }}">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-12 col-xs-12">
                                    <label for="slug">URL</label>
                                    <input type="text" class="form-control m-input m-input--square" id="url" name="url"
                                           value="{{old('url', $point->url ?? '')}}">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_2" role="tabpanel">
              
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                            <a href="{{url('admin/points')}}" class="btn btn-danger">Отмена</a>
                        </div>

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

        $(function () {
            $('.datepicker-input').datepicker({
                format: 'yyyy-mm-dd',
                defaultDate: new Date(),
            });
        });

        Dropzone.options.wayDropzone = {

            dictRemoveFile: "Удалить",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': $('meta[name="token"]').attr('content')
            },

            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("id", '{{$point->id or ""}}');
                formData.append("ess", 'ToursTagsValues');
            },

            init: function () {

                thisDropzone = this;

                $.ajax({
                    url: "{{route('image.get')}}",
                    cache: false,
                    data: {
                        id: '{{$point->id or ""}}',
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
                        data: {id: '{{$point->id or ""}}', name: file.name, ess: 'ToursTagsValues'},
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
