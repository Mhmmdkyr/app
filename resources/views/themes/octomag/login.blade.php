<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="post-area">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-6 col-md-6 col-offset-lg-3">

                    <div class="modal-desc text-center p-3">
                        <h3>{{ __('Welcome Back') }}</h3>
                        <p class="o-1">{{ __('Don\'t have an account?') }} <a href="javascript:;" data-toggle="modal" data-target="#login-modal"><span data-toggle="clicker" data-target="#register-tab">{{ __('Sign Up!') }}</span></a></p>

                    </div>
                    @if (Session::has('danger'))
                    <div class="col-lg-12">
                        <p class="alert alert-danger">{{ Session::get('danger') }}</p>
                    </div>
                    @endif
                    @if (Session::has('success'))
                    <div class="col-lg-12">
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
                    </div>
                    @endif
                    <form method="post" action="{{ route('frontend.login.authenticate') }}" id="login-page-form">
                        {{ csrf_field() }}
                        @if(isset($_GET['redirect_url']))
                            <input type="hidden" name="redirect_url" value="{{ $_GET['redirect_url'] }}">
                        @endif
                        <div class="col-auto">
                            <div class="error-handler"></div>
                          </div>
                        <div class="col-auto">
                            <label class="sr-only" for="login-page-email">{{ __('Email Address') }}</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control" id="login-page-email"
                                    placeholder="{{ __('Email Address') }}" name="email" required>
                            </div>
                        </div>
                        <div class="col-auto" style="margin-top: 20px">
                            <label class="sr-only" for="login-page-password">{{ __('Password') }}</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control" id="login-page-password"
                                    placeholder="{{ __('Password') }}" name="password" required>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="javascript:;" data-toggle="modal" data-target="#login-modal"
                                class="text-muted"><small data-toggle="clicker" data-target=".forgot-password">{{ __('Forgot Password') }}</small></a>
                        </div>
                        <div class="col-auto mt-3">
                            <button type="submit"
                                class="btn btn-primary btn-rounded primary-bg btn-block mb-3">{{ __('Login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
