<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Reset Password') }}</li>
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
                        <h3>{{ __('Reset Your Password') }}</h3>
                        <p class="o-1">{{ __('Do you already have an account?') }} <a href="javascript:;" data-toggle="modal" data-target="#login-modal"><span data-toggle="clicker" data-target="#login-tab">{{ __('Log In!') }}</span></a></p>

                    </div>
                    <form method="post" action="{{ route('frontend.login.reset_password') }}" id="resetting-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        @if(isset($_GET['redirect_url']))
                            <input type="hidden" name="redirect_url" value="{{ $_GET['redirect_url'] }}">
                        @endif
                        <div class="col-auto">
                            <div class="error-handler"></div>
                          </div>
                        <div class="col-auto" style="margin-top: 20px">
                            <label class="sr-only" for="reset-page-password">{{ __('New Password') }}</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control" id="reset-page-password"
                                    placeholder="{{ __('New Password') }}" name="password" required>
                            </div>
                        </div>
                        <div class="col-auto" style="margin-top: 20px">
                            <label class="sr-only" for="reset-page-password2">{{ __('Confirm New Password') }}</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control" id="reset-page-password2"
                                    placeholder="{{ __('Confirm New Password') }}" name="confirm_password" required>
                            </div>
                        </div>
                        <div class="col-auto mt-3">
                            <button type="submit"
                                class="btn btn-primary btn-rounded primary-bg btn-block mb-3">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
