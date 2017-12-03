@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создать право
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Права', 'Создать право'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/permissions')}}{{ isset($permission) ? '/'.$permission->id : '' }}" method="POST">
            
                    {{csrf_field()}}

                    {{-- Переопределяем метод формы, если редактируется пользовательское разрешение --}}
                    @if (isset($permission))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="system_name">Системное имя *</label>
                                <input class="form-control" id="system_name" type="text" name="name" value="{{$permission->name or ''}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="display_name">Название *</label>
                                <input class="form-control" id="display_name" type="text" name="display_name" value="{{$permission->display_name or ''}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="description">Описание</label>
                            <textarea id="description" name="description" class="permission_desc form-control" cols="30" rows="5">{{$permission->description or ''}}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button class="btn btn-success" type="submit" name="action">
                                Сохранить
                            </button>
                            <a href="{{url('admin/permissions')}}" class="btn btn-danger" name="action">
                                Отмена
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection