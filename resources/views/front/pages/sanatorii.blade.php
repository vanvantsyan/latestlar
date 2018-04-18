@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <style>
        .preloader {
            background-image: url("/img/preloader.svg");
            background-color: rgb(66, 176, 235);
            background-repeat: repeat;
        }

        .poular-category-item-img {
            overflow: hidden;
        }

        .subscription form {
            color: #0f0f0f;
        }

        form span {
            float: right;
            color: red;
            margin-left: 10px;
        }

        @if(isset($country) && $country->banner)
        .page-{{$country->slug}}{
            background: url(/uploads/countries/banners/{{$country->banner}}) 50% 0 no-repeat;
        }
        @endif
    </style>
@endsection

@section('title', "Санатории и пансионаты")
@section('description', "Санатории и пансионаты")
@section('keywords',"Санатории и пансионаты")

@section('breadcrumbs')
    <div class="breadcrumbs">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">
                        <a href="/" itemprop="url">
                            <span itemprop="title">Главная</span>
                        </a>
                    </div>

                    <div itemscope itemtype="http://star.glissmedia.ru/Breadcrumb">

                        <span itemprop="title">Санатории и пансионаты</span>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper page-russia">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <div class="row">
                    @include('front.tours.modules.sidebar', [
                         'level' => 'tury',
                            'tag' => "",
                            'way' => '',
                            'point' => "",
                    'country' => '',
                    'month' => '',
                    'tourTypes' => [],
                    'countries' => [],
                    'subText' => '',
                         'layer' => 3,
                      ])
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="row">
                    <div class="tour-preview">
                        <h1 class="stroke-h">
                            Санатории и пансионаты
                        </h1>
                        <div class="tour-preview-desc">
                            <div class="stroke-desc">
                            </div>
                        </div>
                        <a href="#" class="btn btn-yellow" data-toggle="modal" data-target="#tourOrderModal">Отправить
                            заявку на подбор тура</a>
                    </div>
                    <div class="background-white">
                        <div id="ihbooking-content">
                            <script type="text/javascript"
                                    src="//ext.ihbooking.ru/loader.php?key=d636722eef8aa63ea467797a9c4f0fcd&default=true&scrolltop4=true&customcss=startour&hide_step3_paymentinfo_preset=true"></script>
                        </div>
                    </div>
                    {{--@include('front.tours.modules.articles')--}}
                    {{--@include('front.tours.modules.popularTypes')--}}
                </div>
            </div>
            <div class="clear"></div>
        </div>
        {{--@include('front.modules.subscription')--}}
        {{--@include('front.modules.infoCompany')--}}
        @include('front.modules.partners')
        @include('front.modules.bigFooter')
    </div>
    @include('front.tours.modal.images')
    @include('front.tours.modal.order')
    @include('front.tours.modal.types')
    @include('front.tours.modal.cities')
    @include('front.tours.modal.countries')
    @include('front.tours.modal.goldens')
@endsection

@section('js')

    @include('front.tours.modules.list-scripts')
    <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{asset('/js/moment.js')}}"></script>
    <script src="{{asset('/js/daterangepicker.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Send order
        $('#tourOrderModal .modal-footer a:last-child').on('click', function (e) {

            e.preventDefault();

            var data = {};
            $.each($('#tourOrderModal form').serializeArray(), function (i, field) {
                if (field.value) data[field.name] = field.value;
            });

            // Request on server
            $.ajax({
                url: "{{route('mail.order')}}",
                cache: false,
                data: data,
                type: "POST",

            }).done(function (data) {

                $('#tourOrderModal form span').text("");

                if (!data.ok && data.errors) {
                    $.each(data.errors, function (key, value) {
                        // console.log(key+ ' - ' + value + '\n');
                        $('#' + key + ' span').addClass("red");
                        $('#' + key + ' span').text(value);
                    })
                } else {
                    $('#tourOrderModal .modal-footer').remove();
                    $('#tourOrderModal .modal-body').html("<p style='text-align: center' class=\"alert alert-success\">" + data.message + "</p>");
                    setTimeout(function () {
                        $('#tourOrderModal').modal('hide')
                    }, 3000);
                }

            }).error(function () {
                // If errors
            });
        });
    </script>
@endsection