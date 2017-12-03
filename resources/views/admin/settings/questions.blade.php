@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Questions Settings
                </h3>
                {!! Breadcrumbs::generate(['Dashboards', 'Questions', 'Settings'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <div class="alert alert-primary m-alert--icon alert-dismissible fade show   m-alert m-alert--air m-alert--outline" role="alert">
                    <div class="m-alert__icon">
                        <i class="la la-warning"></i>
                    </div>
                    <div class="m-alert__text">
                        List the priorities in order of priority. Where Value 1 is the worst answer, Value 5 is the best. The percentages of the effect on the question are 0 to 100%. The% character is not needed
                    </div>
                </div>

                <form action="{{url('admin/questions')}}{{ isset($settings) ? '/'.$settings->id : '' }}" method="POST" class="m-form m-form--fit m-form--label-align-right">

                    {{csrf_field()}}

                    {{-- Переопределяем метод формы, если редактируется пользователь --}}
                    @if (isset($settings))
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_settings" value="0">
                    @else
                        <input type="hidden" name="_settings" value="1">
                    @endif

                    <div class="row form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="rate1">Value 1</label>
                            <input type="number" name="rate1" class="form-control" value="{{$options->rate1 or ''}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="rate2">Value 2</label>
                            <input type="number" name="rate2" class="form-control" value="{{$options->rate2 or ''}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="rate3">Value 3</label>
                            <input type="number" name="rate3" class="form-control" value="{{$options->rate3 or ''}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="rate4">Value 4</label>
                            <input type="number" name="rate4" class="form-control" value="{{$options->rate4 or ''}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="rate5">Value 5</label>
                            <input type="number" name="rate5" class="form-control" value="{{$options->rate5 or ''}}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <button class="btn btn-success" type="submit">Save</button>
                            <a href="{{url('admin/questions')}}" class="btn btn-danger" name="action">Cancel
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection