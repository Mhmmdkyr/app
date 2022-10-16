<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Contact Us') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1 class="mb-0 mt-0">{{ __('Contact Us') }}</h1>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="contact-item">
                                <i class="fa fa-envelope"></i>
                                <h4>{{ __('Email Address') }}</h4>
                                <p>{{ config('settings.contact')->email }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="contact-item">
                                <i class="fa fa-phone"></i>
                                <h4>{{ __('Phone Number') }}</h4>
                                <p>{{ config('settings.contact')->phone }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="contact-item">
                                <i class="fa fa-map-marker"></i>
                                <h4>{{ __('Address') }}</h4>
                                <p>{{ config('settings.contact')->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="card mt-4">
                        <h4 class="card-header">{{ __('Contact Form') }}</h4>
                        <div class="card-body">
                            <form action="{{ route('frontend.contact.send') }}" id="send-message" method="post">
                                {{ csrf_field() }}
                                <div class="error-handler"></div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Your Name') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ __('Your Phone Number') }}</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('Your Email Address') }} <b class="text-danger">*</b></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="subject">{{ __('Subject') }}</label>
                                        <input type="text" class="form-control" id="subject" name="subject">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="message">{{ __('Message') }} <b class="text-danger">*</b></label>
                                        <textarea class="form-control" id="message" name="message" required></textarea>
                                    </div>
                                </div>
                                @if (config('settings.recaptcha') && isset(config('settings.recaptcha')->secret))
                                    <script src='https://www.google.com/recaptcha/api.js'></script>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <div class="g-recaptcha"
                                                data-sitekey="{{ config('settings.recaptcha')->key }}">
                                            </div>
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span
                                                    class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-6 col-md-6 text-right mt-4">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>
                                        {{ __('Send Message') }}</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="sidebar mt-4">
                        <div class="sidebar-title text-uppercase">{{ __('Follow us') }}</div>
                        <div class="row">
                            @if (isset(config('settings.socials')->facebook))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->facebook }}" rel="nofollow" target="_blank"
                                        class="btn btn-facebook btn-block btn-social text-left"><i
                                            class="fa-brands fa-facebook"></i> Facebook</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->twitter))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->twitter }}" rel="nofollow" target="_blank"
                                        class="btn btn-twitter btn-block btn-social text-left"><i
                                            class="fa-brands fa-twitter"></i> Twitter</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->instagram))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->instagram }}" rel="nofollow"
                                        target="_blank" class="btn btn-instagram btn-block btn-social text-left"><i
                                            class="fa-brands fa-instagram"></i> Instagram</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->youtube))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->youtube }}" rel="nofollow" target="_blank"
                                        class="btn btn-youtube btn-block btn-social text-left"><i
                                            class="fa-brands fa-youtube"></i> Youtube</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->pinterest))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->pinterest }}" rel="nofollow"
                                        target="_blank" class="btn btn-youtube btn-block btn-social text-left"><i
                                            class="fa-brands fa-pinterest"></i> Pinterest</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->linkedin))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->linkedin }}" rel="nofollow"
                                        target="_blank" class="btn btn-linkedin btn-block btn-social text-left"><i
                                            class="fa-brands fa-linkedin"></i> Linkedin</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->vk))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->vk }}" rel="nofollow" target="_blank"
                                        class="btn btn-vk btn-block btn-social text-left"><i
                                            class="fa-brands fa-vk"></i> VK</a>
                                </div>
                            @endif

                            @if (isset(config('settings.socials')->telegram))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->telegram }}" rel="nofollow"
                                        target="_blank" class="btn btn-facebook btn-block btn-social text-left"><i
                                            class="fa-brands fa-telegram"></i> Telegram</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <hr>
                    <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q={{ explode(',', config('settings.contact')->coordinates)[0] }},{{ explode(',', config('settings.contact')->coordinates)[1] }}&hl=es&z=14&amp;output=embed">
                    </iframe>

                </div>
            </div>
        </div>
    </div>
