@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавление новой услуги
                </h3>
                {!! Breadcrumbs::render([
                    '/admin' => 'Рабочий стол',
                    '/menu' => 'Страницы',
                    '/' => 'Добавление новой услуги'
                ], 'metronic') !!}
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
                    $link = isset($service) ? url('admin/services/'.$service->id) : url('admin/services');
                @endphp
                <form action="{{ $link }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    @if(isset($service))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="title">Название услуги</label>
                            <input type="text" class="form-control m-input m-input--square" id="title" name="title" value="{{$service->title or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            <label class="">
                                Загрузить изображение
                            </label>
                            <div class="m-dropzone dropzone dz-clickable" action="{{url('/images/upload')}}" id="m-dropzone-one">
                                <div class="m-dropzone__msg dz-message needsclick" @if(isset($service) && !empty($service->image)) style="display: none;" @endif>
                                    <h3 class="m-dropzone__msg-title">
                                        Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                    </h3>
                                </div>
                                @if(isset($service) && !empty($service->image))
                                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                        <div class="dz-image">
                                            <img data-dz-thumbnail="" alt="" src="{{asset('uploads/news/'.$service->image)}}" style="height:100px;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Краткое описание</label>
                            <textarea class="rich-editor" name="description">{{$service->description or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Полное описание</label>
                            <textarea class="rich-editor" name="content">{{$service->content or ''}}</textarea>
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
                            <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" value="{{$service->seo_title or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_h1">SEO h1</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_h1" name="seo_h1" value="{{$service->seo_h1 or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">SEO Description</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" value="{{$service->seo_desc or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keywords">SEO keywords</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_keywords" name="seo_keywords" value="{{$service->seo_keywords or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="slug">SLUG</label>
                            <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" value="{{$service->slug or ''}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/services')}}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js')}}"></script>
@endsection
