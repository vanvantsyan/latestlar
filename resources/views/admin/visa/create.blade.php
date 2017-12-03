@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создание новой визы
                </h3>
                {!! Breadcrumbs::generate(['Рабочий стол', 'Визы', 'Создание визы'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                @php
                    $link = isset($visa) ? url('admin/visa/'.$visa->id) : url('admin/visa');
                @endphp

                <form action="{{ $link }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    @if(isset($visa))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    @if($countries->isNotEmpty())
                        <div class="form-group m-form__group row">
                            <div class="col-md-6 col-xs-12">
                                <label for="country">Выберите страну *</label>
                                <select name="country_id" id="country" class="form-control" required>
                                    <option value="" selected disabled=""></option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if(isset($visa) && $visa->country_id == $country->id) selected @endif>{{$country->country}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="form-group m-form__group row">
                            <div class="col-md-6 col-xs-12">
                                <a href="{{url('admin/geo')}}">Сперва необходимо добавить хотя бы одну страну</a>
                            </div>
                        </div>
                    @endif

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="time">Срок оформления в рабочих днях *</label>
                            <input type="text" class="form-control m-input m-input--square" id="time" name="time" value="{{$visa->time or ''}}">
                            <small>Формат заполнения: 5-7, или просто число 9</small>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-4 col-xs-6">
                            <label for="amount">Стоимость ОТ *</label>
                            <input type="number" class="form-control m-input m-input--square" id="amount" name="amount" value="{{$visa->amount or ''}}">
                            <small>Введите целое число.</small>
                        </div>
                        <div class="col-md-2 col-xs-6">
                            <label for="currency">Валюта</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value="rur">руб.</option>
                                <option value="usd">$</option>
                                <option value="eur">&euro;</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="amount_desc">Дополнительно к платежу</label>
                            <input type="text" class="form-control m-input m-input--square" id="amount_desc" name="amount_desc" value="{{$visa->amount_desc or ''}}">
                            <small>Дополнительная информация к платежу (Опционально)</small>
                        </div>
                    </div>


                    <br>
                    <h5>Необходимые документы</h5>
                    <hr>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Необходимые документы</label>
                            <textarea class="summernote" name="docs">{{$visa->docs or ''}}</textarea>
                        </div>
                    </div>

                    @if(isset($visa))
                        @php $i=0; @endphp
                        @forelse($visa->add_docs as $docs)
                            <div class="step">
                                <div class="form-group m-form__group row">
                                    <div class="col-md-6 col-xs-12">
                                        <label for="seo_title">Название блока</label>
                                        <input type="text" class="form-control m-input m-input--square" name="add_docs[{{$i}}][name]" value="{{$docs->name or ''}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-md-6 col-xs-12">
                                        <label for="">Описание</label>
                                        <textarea class="summernote" name="add_docs[{{$i}}][text]">{{$docs->text or ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @empty
                        @endforelse
                    @endif

                    <div class="add_docs"></div>

                    <a href="#" onclick="return gliss.visa.addDocs()">Дополнительно</a>
                    <br><br>


                    <br>
                        <div class="col-md-12">
                            <h5>SEO</h5>
                        </div>
                    <hr>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_title">SEO title</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" value="{{$visa->seo_title or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_h1">SEO h1</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_h1" name="seo_h1" value="{{$visa->seo_h1 or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_desc">SEO Description</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" value="{{$visa->seo_desc or ''}}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keywords">SEO keywords</label>
                            <input type="text" class="form-control m-input m-input--square" id="seo_keywords" name="seo_keywords" value="{{$visa->seo_keywords or ''}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="slug">SLUG</label>
                            <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" value="{{$visa->slug or ''}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/visa')}}" class="btn btn-danger">Отмена</a>
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
    <script type="text/javascript" src="{{asset('js/gliss.visa.js')}}"></script>
@endsection
