@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить новость
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Новости', 'Добавить новость'], 'metronic') !!}
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
                    $link = isset($item) ? url('admin/news/'.$item->id) : url('admin/news') ;
                @endphp

                <form action="{{ $link }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if(isset($item))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <select name="category_id" id="" class="form-control">
                                <option value="" selected disabled="">Выберите категорию</option>
                                @forelse($categories as $category)
                                    <option value="{{$category->id}}" @if(isset($item) && $item->category_id == $category->id) selected @endif>{{$category->title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="title">Загаловок новости</label>
                            <input type="text" class="form-control m-input m-input--square" id="title" name="title" value="{{$item->title or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            <label class="">
                                Загрузить изображение
                            </label>
                            <div class="m-dropzone dropzone dz-clickable" action="{{url('/images/upload')}}" id="m-dropzone-one">
                                <div class="m-dropzone__msg dz-message needsclick" @if(isset($item) && !empty($item->image)) style="display: none;" @endif>
                                    <h3 class="m-dropzone__msg-title">
                                        Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                    </h3>
                                </div>
                                @if(isset($item) && !empty($item->image))
                                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                        <div class="dz-image">
                                            <img data-dz-thumbnail="" alt="" src="{{asset('uploads/news/'.$item->image)}}" style="height:100px;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Краткое описание</label>
                            <textarea class="summernote" name="description">{{$item->description or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Полное описание</label>
                            <textarea class="summernote" name="content">{{$item->content or ''}}</textarea>
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
                            <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" value="{{$item->seo_title or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_h1">SEO h1</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_h1" name="seo_h1" value="{{$item->seo_h1 or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">SEO Description</label>
                            <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" rows="5">{{$item->seo_desc or ''}}</textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keywords">SEO keywords</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_keywords" name="seo_keywords" value="{{$item->seo_keywords or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="slug">SLUG</label>
                            <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" value="{{$item->slug or ''}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/news')}}" class="btn btn-danger">Отмена</a>
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
