<footer id="back-footer" class="back-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 md-mb-30">
                    <div class="footer-widget footer-widget-1">
                        <div class="footer-logo white">
                            <a href="index.html" class="logo-text"> <img
                                    src="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo'), '220x0') : url('/') . '/themes/' . $theme->path . '/img/logo-footer.png' }}"
                                    alt="logo"></a>
                        </div>
                        <h5 class="footer-subtitle">{{ $settings['footer_text'] }}</h5>
                        <h6 class="back-follow-us text-capitalize">{{ __('Follow us') }}</h6>
                        <ul class="social-links">
                            @if (isset(config('settings.socials')->facebook))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->facebook }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-facebook"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->twitter))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->twitter }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->instagram))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->instagram }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->youtube))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->youtube }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-youtube"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->pinterest))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->pinterest }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-pinterest"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->linkedin))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->linkedin }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->vk))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->vk }}" rel="nofollow" target="_blank"><i
                                            class="fa-brands fa-vk"></i></a>
                                </li>
                            @endif

                            @if (isset(config('settings.socials')->telegram))
                                <li class="mb-2">
                                    <a href="{{ config('settings.socials')->telegram }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-telegram"></i></a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 md-mb-30">
                    <div class="footer-widget footer-widget-2">
                        <h3 class="footer-title">{{ __('Categories') }}</h3>
                        <div class="footer-menu">
                            <ul>
                                @foreach ($footer as $foot)
                                    <li><a href="{{ uri('category', $foot->slug) }}">{{ $foot->category_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 md-mb-30">
                    <div class="footer-widget footer-widget-2">
                        <h3 class="footer-title">{{ __('Other Links') }}</h3>
                        <div class="footer-menu">
                            <ul>
                                @foreach ($footer_pages as $foot)
                                    <li><a href="{{ uri('page', $foot->slug) }}">{{ $foot->title }}</a></li>
                                @endforeach
                                <li><a href="{{ uri('contact-us') }}">{{ __('Contact Us') }}</a></li>
                                <li><a href="{{ uri('rss-feeds') }}"><i class="fa fa-rss"></i>
                                        {{ __('RSS') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-widget footer-widget-3">
                        <h3 class="footer-title">{{ __('Newsletter') }}</h3>
                        <h5 class="footer-subtitle">{{ __('Subscribe to our mailing list to get the new updates!') }}
                        </h5>
                        <form class="back-newsletter" method="post" action="{{ route('frontend.newsletter') }}">
                            {{ csrf_field() }}
                            <input type="email" placeholder="{{ __('Enter your email') }}" name="email"
                                id="newsletter-email">
                            @if (config('settings.recaptcha') && isset(config('settings.recaptcha')->secret))
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="form-group d-none newsletter-recaptcha mt-2">
                                    <div class="g-recaptcha" data-sitekey="{{ config('settings.recaptcha')->key }}">
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                </div>
                            @endif
                            <div class="newsletter_form_response text-primary"></div>
                            <button type="submit"
                                class="btn-primary btn mt-3 btn-sm float-right">{{ __('Subscribe now!') }}</button>
                            <div class="clear"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <p class=" text-center">{{ $settings['footer_subtitle'] }}</p>

    </div>
</footer>
@if (!session()->has('cookie_alert')  && config('settings.cookie_alert') == '1')
    <div class="cookie-alert transition">
        <i class="fa fa-cookie bg-cookie"></i>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <p> {{ config('settings.cookie_text') }}</p>
            </div>
            <div class="col-lg-4 col-md-4 ml-auto text-right">
                <a href="javascript:;" class="accept-cookie btn btn-primary"><i class="fa fa-cookie"></i> {{ __('Accept Cookies') }}</a>
            </div>
        </div>
    </div>
@endif
<div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                            aria-controls="login" aria-selected="true"><i data-feather="log-in"></i>
                            {{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                            aria-controls="register" aria-selected="false"><i data-feather="user-plus"></i>
                            {{ __('Register') }}</a>
                    </li>
                    <li class="nav-item d-none">
                        <a class="nav-link forgot-password" id="forgot-password-tab" data-toggle="tab"
                            href="#forgot-password" role="tab" aria-controls="forgot-password"
                            aria-selected="false"><i data-feather="user-plus"></i>
                            {{ __('Forgot Password') }}</a>
                    </li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel"
                        aria-labelledby="login-tab">
                        <div class="modal-desc text-center p-3">
                            <h3>{{ __('Welcome Back') }}</h3>
                            <p class="o-1">{{ __('Don\'t have an account?') }} <a href="javascript:;"
                                    data-toggle="clicker" data-target="#register-tab">{{ __('Sign Up!') }}</a></p>
                        </div>
                        <form action="{{ route('frontend.login.authenticate') }}" id="login-form" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="redirect_url" class="form-control"
                                value="{{ url()->current() }}">
                            <div class="col-auto">
                                <div class="error-handler"></div>
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="login-email">{{ __('Email Address') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="login-email"
                                        placeholder="{{ __('Email Address') }}" name="email">
                                </div>
                            </div>
                            <div class="col-auto" style="margin-top: 20px">
                                <label class="sr-only" for="login-password">{{ __('Password') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="login-password"
                                        placeholder="{{ __('Password') }}" name="password">
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:;" data-toggle="clicker"
                                    data-target=".forgot-password"><small>{{ __('Forgot Password') }}</small></a>
                            </div>
                            <div class="col-auto mt-3">
                                <button type="submit"
                                    class="btn btn-primary btn-rounded primary-bg btn-block mb-3 submit-button">{{ __('Login') }}</button>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <div class="modal-desc text-center p-3">
                            <h3>{{ __('Let\'s create your account!') }}</h3>
                            <p class="o-1">{{ __('Do you already have an account?') }} <a href="javascript:;"
                                    data-toggle="clicker" data-target="#login-tab">{{ __('Login') }}</a></p>
                        </div>
                        <form action="{{ route('frontend.login.register') }}" method="post" id="register-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="redirect_url" class="form-control"
                                value="{{ url()->current() }}">
                            <div class="col-auto">
                                <div class="error-handler"></div>
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="register-name">{{ __('Your Name') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="register-name"
                                        placeholder="{{ __('Your Name') }}" name="name" required>
                                </div>
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="register-email">{{ __('Email Address') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="register-email"
                                        placeholder="{{ __('Email Address') }}" name="email" required>
                                </div>
                            </div>
                            <div class="col-auto" style="margin-top: 20px">
                                <label class="sr-only" for="register-password">{{ __('Password') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="register-password"
                                        placeholder="{{ __('Password') }}" name="password"
                                        required>
                                </div>
                            </div>
                            <div class="col-auto" style="margin-top: 20px">
                                <label class="sr-only"
                                    for="register-password-confirm">{{ __('Confirm Password') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="register-password-confirm"
                                        placeholder="{{ __('Confirm Password') }}" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="col-auto mt-3">
                                <button type="submit"
                                    class="btn btn-primary btn-rounded primary-bg btn-block mb-3 submit-button"
                                    data-form="#register-form">{{ __('Register') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="forgot-password" role="tabpanel"
                        aria-labelledby="forgot-password-tab">
                        <div class="modal-desc text-center p-3">
                            <h3>{{ __('Forgot your password?') }}</h3>
                            <p class="o-1">{{ __('Do you already have an account?') }} <a href="javascript:;"
                                    data-toggle="clicker" data-target="#login-tab">{{ __('Login') }}</a></p>
                        </div>
                        <form action="{{ route('frontend.login.reset') }}" method="post" id="reset-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="redirect_url" class="form-control"
                                value="{{ url()->current() }}">
                            <div class="col-auto">
                                <div class="error-handler"></div>
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="reset-email">{{ __('Email Address') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="reset-email"
                                        placeholder="{{ __('Email Address') }}" name="email">
                                </div>
                            </div>
                            <div class="col-auto mt-3">
                                <button type="submit"
                                    class="btn btn-primary btn-rounded primary-bg btn-block mb-3">{{ __('Login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer login-modal-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <button type="button" class="btn btn-outline-primary btn-sm btn-block btn-rounded"><i class="fab fa-facebook"></i> {{ __('Log In via Facebook') }}</button>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-block btn-rounded"><i class="fab fa-google"></i> {{ __('Log In via Google') }}</button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@if (!session()->has('newsletter_modal') && config('settings.newsletter_modal') == '1')
@php
    session()->push('newsletter_modal', 'close');
@endphp
    <div class="modal fade" id="newsletter-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="modal-newsletter" method="post" action="{{ route('frontend.newsletter') }}">
                        <h3>{{ __('Join Newsletter') }}</h3>
                        <div class="newsletter-information">
                            <i class="fa fa-envelope"></i>
                            <p>{{ __('Join our subscribers list to get the latest news, updates and special offers directly in your inbox') }}</p>
                        </div>
                        <div class="newsletter_form_response text-primary mb-2"></div>
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="{{ __('Email Address') }}"
                                name="email" id="newsletter-email-modal">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">{{ __('Subscribe now!') }}</button>
                            </div>
                        </div>
                        @if (config('settings.recaptcha') && isset(config('settings.recaptcha')->secret))
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="form-group newsletter-recaptcha-modal d-none mt-2">
                                <div class="g-recaptcha" data-sitekey="{{ config('settings.recaptcha')->key }}">
                                </div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>
                        @endif
                        <div class="text-center">
                            <a href="javascript:;" class="text-dark text-decoration-underline close-newsletter">{{ __('No, Thanks') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top"><span class="fa fa-chevron-up"></span></a>
<script>
    var base_url = '{{ url('/') }}';
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ url('/') }}/themes/{{ $theme->path }}/js/jquery.min.js?version?<?=VERSION;?>"></script>
<script src="{{ url('/') }}/themes/{{ $theme->path }}/plugin/bootstrap/bootstrap.bundle.min.js?version?<?=VERSION;?>"></script>
<script src="{{ url('/') }}/themes/{{ $theme->path }}/plugin/swiper/swiper-bundle.min.js?version?<?=VERSION;?>"></script>
@if (isset($post) && $post->type == 'gallery')
    <link href="{{ url('/') }}/themes/{{ $theme->path }}/plugin/fancybox/jquery.fancybox.min.css?version?<?=VERSION;?>"
        rel="stylesheet">
    <script src="{{ url('/') }}/themes/{{ $theme->path }}/plugin/fancybox/jquery.fancybox.min.js?version?<?=VERSION;?>"></script>
@endif
@if(config('settings.footer_html'))
    {!! config('settings.footer_html') !!}
@endif
<script src="{{ url('/') }}/themes/{{ $theme->path }}/js/jquery.lazyload.js?version?<?=VERSION;?>"></script>
<script src="{{ url('/') }}/themes/{{ $theme->path }}/js/ahtaport.min.js?version?<?=VERSION;?>"></script>
