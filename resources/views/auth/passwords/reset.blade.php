<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Metronic | Login Page - 4
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="{{asset('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="../../../assets/demo/default/media/img/logo/favicon.ico" />
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-2.jpg);">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <img src="{{asset('images/logo.png')}}">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Sign In
                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="{{ route('password.request') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group m-form__group {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <input class="form-control m-input"   type="text" placeholder="Email" name="email" autocomplete="off" value="{{old('email')}}">
                            @if ($errors->has('email'))
                                <div id="email-error" class="form-control-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group m-form__group {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                            @if ($errors->has('password'))
                                <div id="email-error" class="form-control-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group m-form__group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <div id="email-error" class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                        <div class="m-login__form-action">
                            <button id="" type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="{{asset('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<script src="{{asset('assets/snippets/pages/user/login.js')}}" type="text/javascript"></script>
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>
