@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить вопрос
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Вопросы', 'Добавить вопрос'], 'metronic') !!}
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
                    $link = isset($question) ? url('admin/questions/'.$question->id) : url('admin/questions');
                @endphp
                <form action="{{ $link }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    @if(isset($question))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="question">Вопрос *</label>
                            <input type="text" class="form-control m-input m-input--square" id="question" name="question" value="{{$question->question or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Ответ</label>
                            <textarea class="rich-editor" name="answer">{{$question->answer or ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="name">Имя пользователя *</label>
                            <input type="text" class="form-control m-input m-input--square" id="name" name="name" value="{{$question->name or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="phone">Номер телефона</label>
                            <input type="text" class="form-control m-input m-input--square" id="phone" name="phone" value="{{$question->phone or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">Email</label>
                            <input type="email" class="form-control m-input m-input--square" id="email" name="email" value="{{$question->email or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label class="col-form-label">
                                Опубликовать вопрос?
                            </label>
                            <span class="m-switch m-switch--icon">
                                <label class="col-form-label">
                                    <input type="checkbox" name="show" class="sw_accepted" @if($question->show == 1) checked @endif>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/questions')}}" class="btn btn-danger">Отмена</a>
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
