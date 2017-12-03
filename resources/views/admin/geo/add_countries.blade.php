@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить страны
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'ГЕО', 'Добавление стран'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/geo')}}" method="POST" class="m-form">

                    {{csrf_field()}}

                    <div class="row form-group {{ $errors->has('countries') ? ' has-danger' : '' }}">
                        <div class="col-md-6">
                            <label for="countries">Страны *</label>
                            <textarea id="countries" class="form-control" name="countries" rows="5"></textarea>
                            @if($errors->has('countries'))
                                <div class="form-control-feedback">{{$errors->first('countries')}}</div>
                            @endif
                            <span class="m-form__help">
                                Введите названия стран. Каждая страна с новой строки
                            </span>
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col-md-6">
                            <button class="btn btn-success" type="submit">Сохранить
                            </button>
                            <a href="{{url('admin/geo')}}" class="btn btn-danger" name="action">Отмена
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection