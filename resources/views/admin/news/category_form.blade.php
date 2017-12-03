@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить категорию новости
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Новости', 'Добавить категорию'], 'metronic') !!}
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
                    $link = isset($category) ? url('admin/news/category-update') : url('admin/news/categories');
                @endphp
                <form action="{{ $link }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    @if(isset($category))
                        <input type="hidden" name="id" value="{{$category->id}}">
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="title">Загаловок категории</label>
                            <input type="text" class="form-control m-input m-input--square" id="title" name="title" value="{{$category->title or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            <label class="">
                                Загрузить изображение
                            </label>
                            <div class="m-dropzone dropzone dz-clickable" action="inc/api/dropzone/upload.php" id="m-dropzone-one">
                                <div class="m-dropzone__msg dz-message needsclick">
                                    <h3 class="m-dropzone__msg-title">
                                        Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Описание категории</label>
                            <textarea class="summernote" name="description">{{$category->description or ''}}</textarea>
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
                            <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" value="{{$category->seo_title or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_h1">SEO h1</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_h1" name="seo_h1" value="{{$category->seo_h1 or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">SEO Description</label>
                            <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" rows="5">{{$category->seo_desc or ''}}</textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keywords">SEO keywords</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_keywords" name="seo_keywords" value="{{$category->seo_keywords or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="slug">SLUG</label>
                            <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" value="{{$category->slug or ''}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/news/categories')}}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>
@endsection