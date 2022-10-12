<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ url('/') }}/backend/img/icon.ico" type="image/x-icon" />
    <script src="{{ url('/') }}/backend/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['{{ url(' / ') }}/assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/backend/css/azzara.min.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <form method="POST" action="{{ route('admin.login.login') }}">
                @csrf
                <h3 class="text-center">{{ __('Signin to Admin Panel') }}</h3>
                @if($errors->any())
                    <div class="alert alert-danger">{{$errors->first()}}</div>
                    @endif
                <div class="login-form">
                    <div class="form-group form-floating-label">
                        <input id="username" type="email" name="email" value="{{ old('email') }}" class="form-control input-border-bottom" required>
                        <label for="username" class="placeholder">{{ __('Email') }}</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" type="password" name="password" value="{{ old('password') }}" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder">{{ __('Password') }}</label>
                        <div class="show-password">
                            <i class="flaticon-interface"></i>
                        </div>
                    </div>
                    <div class="row form-sub m-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme" name="remember">
                            <label class="custom-control-label" for="rememberme">{{ __('Remember me') }}</label>
                        </div>

                        <a href="{{ route('frontend.login') }}" class="link float-right">{{ __('Forgot your password?') }}</a>
                    </div>
                    <div class="form-action">
                        <button class="btn btn-primary btn-block">
                            <span class="btn-label">
                                <i class="fa fa-sign-in"></i>
                            </span>
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ url('/') }}/backend/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ url('/') }}/backend/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ url('/') }}/backend/js/core/popper.min.js"></script>
    <script src="{{ url('/') }}/backend/js/core/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/backend/js/ready.js"></script>
</body>

</html>