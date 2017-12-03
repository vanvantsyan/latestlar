@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить отзыв
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Отзывы', 'Добавить отзыв'], 'metronic') !!}
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
                    $link = isset($review) ? url('admin/reviews/'.$review->id) : url('admin/reviews');
                @endphp

                <form action="{{ $link }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    @if(isset($review))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="title">Имя (Фамилия)</label>
                            <input type="text" class="form-control m-input m-input--square" id="title" name="user_name" value="{{$review->user_name or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Текст отзыва</label>
                            <textarea class="form-control" name="text" rows="5">{!! $review->text or '' !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Дата публикации</label>
                            <div class="input-group date" id="m_datepicker_2">
                                @php
                                    $date = isset($review) ? date('m/d/Y', strtotime($review->created_at)) : '';
                                @endphp
                                <input type="text" name="date_pub" class="form-control m-input" readonly="" placeholder="Select date" value="{{$date or ''}}">
                                <span class="input-group-addon">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label class="col-form-label">
                                Опубликовать отзыв?
                            </label>
                            <span class="m-switch m-switch--icon">
                                <label class="col-form-label">
                                    <input type="checkbox" name="moderation" class="sw_accepted" @if(isset($review) && $review->moderation == 1) checked @endif>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/reviews')}}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js')}}"></script>
@endsection