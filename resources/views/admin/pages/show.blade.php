@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Редактирование страницы
                </h3>
                {!! Breadcrumbs::render(['Рабочий стол', 'Страницы', 'Редактирование страницы'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{ url('admin/pages/'.$page->id) }}" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="title">Загаловок страницы</label>
                            <input type="text" class="form-control m-input m-input--square" id="title" name="title" value="{{$page->title}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Краткое описание</label>
                            <textarea class="rich-editor" name="description">{!! $page->description !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Полное описание</label>
                            <textarea class="rich-editor" name="content">{!! $page->content !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Дата публикации</label>
                            <div class="input-group date" id="m_datepicker_2">
                                <input type="text" name="date_pub" class="form-control m-input" readonly="" placeholder="Select date">
                                <span class="input-group-addon">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
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
                            <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" value="{{$page->seo_title}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_h1">SEO h1</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_h1" name="seo_h1" value="{{$page->seo_h1}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">SEO Description</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" value="{{$page->seo_desc}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keywords">SEO keywords</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_keywords" name="seo_keywords" value="{{$page->seo_keywords}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="slug">SLUG</label>
                            <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" value="{{$page->slug}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/pages')}}" class="btn btn-danger">Отмена</a>
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
