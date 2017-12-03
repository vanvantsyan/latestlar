@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создание нового меню
                </h3>
                {!! Breadcrumbs::generate(['Админ панель', 'Управление меню', 'Создание нового меню'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                    <h3 class="m-portlet__head-text">
                        Форма создания меню
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" action="{{url('admin/menu')}}" method="post">
            <div class="m-portlet__body">

                {{csrf_field()}}

                <div class="form-group m-form__group row">
                    <div class="col-md-6 col-xs-12">
                        <label for="sys_name">Системное имя</label>
                        <input type="text" class="form-control m-input m-input--square" id="sys_name" name="name" placeholder="Введите системное имя">
                        <span class="m-form__help">
                            Только строчные английские буквы и символы "-", "_". Системное имя НЕ ИЗМЕНЯТЬ
                        </span>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-md-6 col-xs-12">
                        <label for="title">Название меню</label>
                        <input type="text" class="form-control m-input m-input--square" id="title" name="title" placeholder="Введите название меню">
                    </div>
                </div>
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

@endsection