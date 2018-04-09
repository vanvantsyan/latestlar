@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Изменить склонение {{$key}}
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Склонения', 'Изменить склонение'], 'metronic') !!}
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


                <form action="/admin/cases/store" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if(isset($item))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="word" value="{{$key}}">

                    @foreach($word as $key => $case)
                        @if(!is_array($case))
                        <div class="form-group m-form__group row">
                            <div class="col-md-4 col-xs-6">
                                <label for="{{$key}}">{{$key}}</label>
                                <input type="text" class="form-control m-input m-input--square" id="{{$key}}" name="{{$key}}"
                                       value="{{$case or ''}}">
                            </div>
                        </div>
                        @endif
                    @endforeach

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/tours')}}" class="btn btn-danger">Отмена</a>
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

    </script>
@endsection
