@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Добавить новый пункт меню - {{$menu->title}}
                </h3>
                {!! Breadcrumbs::render([
                    '/admin' => 'Админ панель',
                    '/menu' => 'Управление меню',
                    '/item?id='.$menu->id => 'Список пунктов меню - ' .$menu->title,
                    '/' => 'Новый пункт меню'
                ], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Форма добавления нового пункта меню
                    </h3>
                </div>
            </div>
        </div>

        @php
            $link = isset($menu->item) ? 'admin/menu/update-item' : 'admin/menu/save-item' ;
        @endphp

        <form class="m-form m-form--fit m-form--label-align-right" action="{{url($link)}}" method="post">
            <div class="m-portlet__body">

                {{csrf_field()}}
                <input type="hidden" name="menu_id" value="{{$menu->id}}">
                @if(isset($menu->item))
                    <input type="hidden" name="id" value="{{$menu->item->id}}">
                @endif

                <div class="form-group m-form__group row @if($errors->has('title')) has-danger @endif">
                    <div class="col-md-6 col-xs-12">
                        <label for="title">Название</label>
                        <input type="text" class="form-control m-input m-input--square" id="title" name="title" placeholder="Название пункта меню" value="{{$menu->item->title or ''}}">
                        @if($errors->has('title'))
                            <div class="form-control-feedback">
                                {{ $errors->first('title')}}
                            </div>
                        @endif
                        <span class="m-form__help">
                            Название будет отображаться на сайте
                        </span>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-md-6 col-xs-12">
                        <label for="a_title">Атрибут title</label>
                        <input type="text" class="form-control m-input m-input--square" id="a_title" name="a_title" placeholder="Текст атрибута title" value="{{$menu->item->a_title or ''}}">
                    </div>
                </div>

                <div class="form-group m-form__group row @if($errors->has('slug')) has-danger @endif">
                    <div class="col-md-6 col-xs-12">
                        <label for="slug">Укажите урл</label>
                        <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" placeholder="Ссылка пункта меню" value="{{$menu->item->slug or ''}}">
                        @if($errors->has('slug'))
                            <div class="form-control-feedback">
                                {{ $errors->first('slug')}}
                            </div>
                        @endif
                        <span class="m-form__help">Внешняя ссылка должна начинаться с http:// или https://</span>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="col-md-6 col-xs-12">
                        <label class="m-checkbox m-checkbox--air">
                            <input type="checkbox" name="out" @if((isset($menu->item->out) && $menu->item->out) == 1 || !isset($menu)) checked @endif>
                            Внутренняя ссылка
                            <span></span>
                        </label><br>
                        <span class="m-form__help">Снимите флаг если вы указываете внешнюю ссылку</span>
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
    </div>

@endsection