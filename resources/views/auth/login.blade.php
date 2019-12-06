<!doctype html>
<html lang="en">

<head>
    <title>WW | Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Oculux Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
    <meta name="author" content="GetBootstrap, design by: puffintheme.com">

    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/animate-css/vivify.min.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/site.min.css') }}">

    <style>
        .auth-main .auth_brand .navbar-brand {
            color: #17191c;
            margin-left: -1%;
        }
    </style>
</head>
<body class="theme-cyan font-montserrat light_version">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
    </div>
</div>

<div class="pattern">
    <span class="red"></span>
    <span class="indigo"></span>
    <span class="blue"></span>
    <span class="green"></span>
    <span class="orange"></span>
</div>

<div class="auth-main particles_js">
    <div class="auth_div vivify popIn">
        <div class="auth_brand">
            <a class="navbar-brand" href="javascript:void(0);"><img src="{{ URL::asset('assets/images/ww_logo.png') }}" height="30" class="d-inline-block align-top mr-2" alt=""></a>
        </div>
        @error('email')
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <i class="fa fa-times-circle"></i> {{ $message }}
        </div>
        @enderror

        <div class="card">
            <div class="body">
                <p class="lead">{{ __('Login') }} to your account</p>
                <form class="form-auth-small m-t-20" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="control-label sr-only">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control round" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        {{--                        @error('email')--}}
                        {{--                        <span class="invalid-feedback" role="alert">--}}
                        {{--                                    <strong>{{ $message }}</strong>--}}
                        {{--                                </span>--}}
                        {{--                        @enderror--}}
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label sr-only">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control round" name="password" required autocomplete="current-password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-group clearfix">
                        <label class="fancy-checkbox element-left">
                            <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span>{{ __('Remember Me') }}</span>
                        </label>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-round btn-block">{{ __('Login') }}</button>
                            @if (Route::has('password.request'))
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i>  <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>
</div>
<!-- END WRAPPER -->

<script src="{{ URL::asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/bundles/mainscripts.bundle.js') }}"></script>
</body>
</html>
