@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создание / Редактирование категории блога
                </h3>
                {!! Breadcrumbs::render([
                    '/admin' => 'Админ панель',
                    '/blog' => 'Блог',
                    '/categories' => 'Категории',
                    '/' => 'Создание / редактирование категории'
                ], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--tab">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
            <!--begin::Form-->
                @php
                    $link = isset($category) ? url('admin/blog/categories/'.$category->id.'/update') : url('admin/blog/categories');
                @endphp
                <form class="m-form m-form--fit m-form--label-align-right" action="{{$link}}" method="post">
                    <div class="m-portlet__body">

                        {{csrf_field()}}

                        <div class="form-group m-form__group row">
                            <div class="col-md-6 col-xs-12">
                                <label for="name">Название категории</label>
                                <input type="text" class="form-control m-input m-input--square" id="name" name="title" placeholder="Название категории" value="{{$category->title or ''}}">
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-md-6 col-xs-12">
                                <label for="name">Описание категории</label>
                                <textarea name="description" class="rich-editor">{{$category->description or ''}}</textarea>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-md-6 col-xs-12">
                                <div class="row">
                                    <label class="col-3 col-form-label">Приватная категория?</label>
                                    <div class="col-3">
                                        <span class="m-switch m-switch--icon">
                                            <label>
                                                <input type="checkbox" name="private" @if(isset($category) && $category->private == 1) checked @endif>
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-md-12">
                                <br>
                                <h5>SEO параметры</h5>
                                <hr>
                            </div>
                        </div>

                        @if(isset($category))
                            @include('admin.blog.seo', ['data' => $category])
                        @else
                            @include('admin.blog.seo')
                        @endif

                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <button type="submit" class="btn btn-success">
                                Сохранить
                            </button>
                            <a href="{{url('admin/menu')}}" class="btn btn-danger">
                                Отмена
                            </a>
                        </div>
                    </div>
                </form>
            <!--end::Form-->
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>
@endsection