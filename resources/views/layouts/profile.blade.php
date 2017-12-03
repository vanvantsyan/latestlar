<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>
        Hotel award | My Profile
    </title>
    <meta name="description" content="User profile view and edit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="{{asset('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
    @yield('css')
    <link rel="shortcut icon" href="assets/demo/demo5/media/img/logo/favicon.ico" />
</head>
<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<div class="m-grid m-grid--hor m-grid--root m-page">

    @include('front.profile.modules.header')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver	m-container m-container--responsive m-container--xxl m-page__container">

            <!-- BEGIN: Left Aside -->
            <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn">
                <i class="la la-close"></i>
            </button>

            <div id="m_aside_left" class="m-grid__item m-aside-left ">
                <!-- BEGIN: Aside Menu -->
                @include('front.profile.modules.sidebar')
                <!-- END: Aside Menu -->
            </div>
            <!-- END: Left Aside -->

            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- end::Body -->
    <!-- begin::Footer -->
    <footer class="m-grid__item m-footer ">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-footer__wrapper">
                <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                    <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
								<span class="m-footer__copyright">
									2017 &copy; Hotel Awards
								</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end::Footer -->
</div>

<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<!--begin::Base Scripts -->
<script src="{{asset('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/demo/demo5/base/scripts.bundle.js')}}" type="text/javascript"></script>

@if (session('status'))
    <script>
        $(document).ready(function(){
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("Password changed successfully");
        })
    </script>
@endif

@yield('js')
<!--end::Base Scripts -->
</body>
<!-- end::Body -->
</html>
