@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создать роль
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Роли', 'Создать роль'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/roles')}}{{ isset($role) ? '/'.$role->id : '' }}" method="POST">
            
                    {{csrf_field()}}

                    {{-- Переопределяем метод формы, если редактируется роль пользователей --}}
                    @if (isset($role))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="system_name">Системное имя *</label>
                                <input class="form-control" id="system_name" type="text" name="name" value="{{$role->name or ''}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="display_name">Название *</label>
                                <input class="form-control" id="display_name" type="text" name="display_name" value="{{$role->display_name or ''}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="description">Описание</label>
                            <textarea class="form-control" id="description" name="description" class="role_desc" cols="30" rows="5">{{$role->description or ''}}</textarea>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="permission">Права</label>
                                <select id="permission" class="js-permission form-control" multiple="multiple" name="permissions[]">
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}" @if (!empty($role_perms_ids) && in_array($permission->id, $role_perms_ids)) selected @endif>{{$permission->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit" name="action">Сохранить
                            </button>
                            <a href="{{url('admin/roles')}}" class="btn btn-danger" name="action">Отмена
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection