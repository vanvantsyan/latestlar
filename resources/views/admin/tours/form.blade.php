@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    @isset($item) Редактировать тур @else Добавить тур @endif
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
                    @else
                        <input type="hidden" name="source" value="manual">
                    @endif

                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_1" role="tab">
                                Данные тура
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_2" role="tab">
                                СЕО
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_3" role="tab">
                                Географическая пренадлежность
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_4" role="tab">
                                Детали тура
                            </a>
                        </li>
                    </ul>

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_1" role="tabpanel">


                            <div class="form-group m-form__group row">
                                <div class="col-md-12 col-xs-12">
                                    <label for="title">Заголовок тура</label>
                                    <input type="text" class="form-control m-input m-input--square" id="title"
                                           name="title"
                                           value="{{$item->title ?? old('title')}}">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-6 col-xs-6">
                                    <label for="price">Цена тура</label>
                                    <input type="text" class="form-control m-input m-input--square" id="price"
                                           name="price"
                                           value="{{$item->price ?? old('price')}}">
                                </div>

                                <div class="col-md-6 col-xs-6">
                                    <label for="duration">Количество дней тура</label>
                                    <input type="text" class="form-control m-input m-input--square" id="duration"
                                           name="duration"
                                           value="{{$item->duration or old('duration')}}">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-12 col-xs-12">
                                    <label for="">Краткое описание</label>
                                    <textarea class="summernote"
                                              name="description">{{$item->description ?? ''}}</textarea>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-md-12 col-xs-12">
                                    <label for="">Полное описание</label>
                                    <textarea class="summernote" name="text">{{$item->text ?? ''}}</textarea>
                                </div>
                            </div>
                            @isset($item)
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 col-md-9 col-sm-12">
                                        <label class="">
                                            Загрузить изображение
                                        </label>
                                        <div class="m-dropzone dropzone dz-clickable"
                                             action="{{url('/tour/uploadImage')}}"
                                             id="tour-dropzone">

                                            <div class="m-dropzone__msg dz-message needsclick"
                                                 @if(isset($item) && !empty($item->image)) style="display: none;" @endif>
                                                <h3 class="m-dropzone__msg-title">
                                                    Перетащите файл изображения сюда или кликните для загрузки с
                                                    компьютера
                                                </h3>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">Для загрузки изобравжений сохраните тур</div>
                            @endif

                            <div class="form-group m-form__group row">
                                <div class="col-md-12 col-xs-12">
                                    <label for="tourType">Тип тура</label>
                                    <div>
                                        @forelse($types as $type)
                                            @isset($item)
                                                <div class="tour-type-element">
                                                    <input type="checkbox" value="{{$type->id}}" name="tourType[]"
                                                           @if(in_array($type->id,$item->tourTags->pluck('value')->toArray())) checked @endif>
                                                    {{$type->alias}}
                                                </div>
                                            @else
                                                <div class="tour-type-element">
                                                    <input type="checkbox" value="{{$type->id}}" name="tourType[]">
                                                    {{$type->alias}}
                                                </div>
                                            @endif
                                        @empty
                                            <p class="danger">Типов не найдено</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-md-12 tour-date-picker">
                                    <label for="tourType">Даты тура</label>
                                    <div class="existDates">
                                        @isset($item)
                                            @foreach($item->dates as $date)
                                                <div class="alert-success">{{Carbon\Carbon::createFromTimestamp($date['value'])->format('d.m.Y')}}
                                                    <span data-tour-id="{{$item->id}}" data-date="{{$date->value}}"
                                                          class="flaticon-circle"></span>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">Для добавления дат сохраните тур</div>
                                        @endif
                                    </div>
                                    @isset($item)
                                        <div class="date-control-block">
                                            <input class="form-control form-control-inline input-medium datepickerInput"
                                                   size="16" value="" type="text">
                                            <span data-tour-id="{{$item->id or 0}}"
                                                  class="btn btn-info">Добавить дату</span>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_2" role="tabpanel">
                            <div class="col-md-12">
                                <h5>SEO</h5>
                            </div>
                            <hr>
                            <div class="form-group m-form__group row">

                                <div class="col-md-6 col-xs-12">

                                    <label for="seo_title">SEO title</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_title"
                                           name="seo_title" value="{{$item->seo_title ?? ''}}">
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_keywords">SEO keywords</label>
                                    <input type="text" class="form-control m-input m-input--square" id="seo_keywords"
                                           name="seo_keywords" value="{{$item->seo_keywords ?? ''}}">
                                </div>
                                {{--<div class="col-md-6 col-xs-12">--}}
                                {{--<label for="url">URL (Только английские буквы + )</label>--}}
                                {{--<input type="text" class="form-control m-input m-input--square" id="url" name="url"--}}
                                {{--value="{{$item->url or ''}}">--}}
                                {{--</div>--}}
                                <div class="col-md-6 col-xs-12">
                                    <label for="seo_desc">SEO Description</label>
                                    <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc"
                                              rows="5">{{$item->seo_desc ?? ''}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="m_tabs_3" role="tabpanel">
                            <div class="col-md-12">
                                <h5>Гео пренадлежность</h5>
                                <div class="form-group m-form__group row">
                                    <div class="col-md-6 col-xs-12 margTop15">
                                        <label for="seo_desc">Страна</label>

                                        <select class="bs-select form-control" name="country">
                                            <option value="0">Не указана</option>

                                            @foreach($countries as $country)
                                                @if(isset ($item) && $item->country && $item->country->id == $country->id)
                                                    <option value="{{$country->id}}"
                                                            selected="selected">{{$country->country}}</option>
                                                @else
                                                    <option value="{{$country->id}}">{{$country->country}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--<div class="col-md-6 col-xs-12 margTop15">--}}
                                        {{--<label for="seo_desc">Направление</label>--}}
                                        {{--@php--}}
                                            {{--if(count($item->parWays)) {--}}
                                                {{--$currentWay = array_get(head(head($item->parWays)),'waysPar');--}}
                                            {{--} else {--}}
                                                {{--$currentWay = 0;--}}
                                            {{--}--}}
                                        {{--@endphp--}}

                                        {{--<select class="bs-select form-control" name="way">--}}
                                            {{--<option value="0">Не указано</option>--}}
                                            {{--@foreach($ways as $way)--}}
                                                {{--@if(isset($curentWay) && $curentWay->id = $way->id)--}}
                                                    {{--<option value="{{$way->id}}">{{$way->title}}</option>--}}
                                                {{--@else--}}
                                                    {{--<option value="{{$way->id}}">{{$way->title}}</option>--}}
                                                {{--@endif--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-6 col-xs-12 margTop15">--}}
                                        {{--<label for="cities">Города (маршрут)</label>--}}
                                        {{--@isset($item)--}}
                                            {{--<div class="routeList">--}}
                                                {{--@if(count($item['parPoints']))--}}
                                                    {{--@foreach($item->parPoints as $point)--}}
                                                        {{--<span class="alert-success">--}}
                                                            {{--<input type="hidden"--}}
                                                                   {{--value="{{array_get($point,'pointsPar.id')}}"--}}
                                                                   {{--name="cities"/>{{array_get($point,'pointsPar.title')}}--}}
                                                            {{--<i data-tour-id="{{$item->id}}" data-date="{{$date->value}}"--}}
                                                               {{--class="flaticon-circle"></i>--}}
                                                        {{--</span>--}}
                                                    {{--@endforeach--}}
                                                {{--@else--}}
                                                    {{--<div>Нет городов</div>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                        {{--<select class="bs-select form-control">--}}
                                            {{--<option value="0">Не указано</option>--}}
                                            {{--@foreach($cities as $city)--}}
                                                {{--<option value="{{$city->id}}">{{$city->title}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--<span class="btn btn-info">Добавить</span>--}}
                                    {{--</div>--}}
                                    <div class="col-md-6 col-xs-12"></div>
                                    <div class="col-md-6 col-xs-12"></div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="tab-pane" id="m_tabs_4" role="tabpanel">
                            <div class="col-md-12">
                                <h5>Детали тура</h5>
                                <div class="form-group m-form__group row">

                                    <div class="col-md-6 col-xs-12"></div>
                                    <div class="col-md-6 col-xs-12"></div>
                                    <div class="col-md-6 col-xs-12"></div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                            <a href="{{url('admin/tours')}}" class="btn btn-danger">Отмена</a>
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

        window.onload = function () {
            $('.datepickerInput').datepicker({
                format: 'dd.mm.yyyy',
                defaultDate: new Date(),
            }).datepicker("setDate", 'now');

            $('.existDates div span').on('click', function () {

                var spanblock = $(this);
                $.ajax({
                    url: '{{route('dates.remove')}}',
                    type: 'POST',
                    data: {
                        tour_id: spanblock.attr('data-tour-id'),
                        date: spanblock.attr('data-date'),
                    },
                    success: function () {
                        console.log(spanblock);

                        spanblock.closest('div').fadeOut(1000, function () {
                            spanblock.closest('div').remove();
                        });
                    }
                });
            });

        };

        $('.date-control-block span').on('click', function () {

            var date = $('.date-control-block input').val();
            var timeStamp = moment(date, 'dd.mm.yyyy').add(1, 'days').unix();
            ;

            $.ajax({
                url: '{{route('dates.add')}}',
                type: 'POST',
                data: {
                    tour_id: $(this).attr('data-tour-id'),
                    date: timeStamp,
                },
                success: function () {
                    $('.existDates').prepend('<div class="alert-success">' + date + '<span data-tour-id="87" data-date="1544313600" class="flaticon-circle"></span></div>').fadeIn(1000);
                }
            });
        });

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

            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("tourId", '{{$item->id ?? ""}}');
            },

            init: function () {

                thisDropzone = this;

                $.ajax({
                    url: "/tour/getImage",
                    cache: false,
                    data: {id: '{{$item->id ?? ""}}'},
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
                        data: {id: '{{$item->id ?? ""}}', name: file.name},
                        type: "POST",
                    });

                });
            },

        }
    </script>
@endsection
