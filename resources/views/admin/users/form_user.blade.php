@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создать пользователя
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Пользователи', 'Создать пользователя'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                <form action="{{url('admin/users')}}{{ isset($user) ? '/'.$user->id : '' }}" method="POST">

                    {{csrf_field()}}

                    {{-- Переопределяем метод формы, если редактируется пользователь --}}
                    @if (isset($user))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="row form-group">
                        <div class="col-md-6">
                                <label for="name">Имя *</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{$user->name or ''}}" required>
                        </div>
                    </div>

                    <br>
                    <h5>Контактная информация</h5>
                    <hr>
                    <br>

                    <div class="row form-group">
                        <div class="col-md-6">
                                <label for="email">Email *</label>
                                <input id="email" type="text" name="email" class="form-control" value="{{$user->email or ''}}" required>
                        </div>
                    </div>

                    <br>
                    <h5>Role and pass</h5>
                    <hr>
                    <br>

                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role *</label>
                                {{--<input id="role" type="text" name="group" value="{{$user->group or ''}}" required>--}}
                                <select id="role" class="js-role form-control " multiple="multiple" name="roles[]" required>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if (!empty($user_roles_ids) && in_array($role->id, $user_roles_ids)) selected @endif>{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @if(isset($user))
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="password">Change password</label>
                                <input id="password" type="text" name="password" class="form-control" value="">
                            </div>
                        </div>
                    @endif

                    <div class="row form-group">
                        <div class="col-md-6">
                            <button class="btn btn-success" type="submit" name="action">Save
                            </button>
                            <a href="{{url('admin/users')}}" class="btn btn-danger" name="action">Cancel
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Подключаем библиотеку select2 --}}
    <link href="{{ asset('css/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        $('#role').select2();
//        $(document).ready(function() {
//            $('#role').select2();
//        });
    </script>

@endsection

@section('js')
    @parent
    <script src="{{asset('js/gliss.select.js')}}"></script>
@endsection