<div class="page-inner">
    <form action="{{ route('admin.settings.save') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="language_id"
            value="{{ Request::has('lang') ? Request::get('lang') : config('app.default_lang.id') }}">
        <div class="row mb-2">
            <div class="col-lg-10 col-md-10">
                <div class="page-header">
                    <h4 class="page-title">{{ __('Settings') }}</h4>
                </div>
            </div>
            <div class="col-lg-2 col-md-2">
                <select name="" id="" class="form-control form-control-sm dynamic_select">
                    @foreach ($languages as $language)
                        <option
                            value="{{ set_querystring('lang', $language->id) }}"{{ isset($lang) && $lang == $language->id ? ' selected' : '' }}>
                            {{ $language->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="clear"></div>
        @if (Session::has('status'))
            <p class="alert alert-success">{{ Session::get('status') }}</p>
        @endif
        @if (Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($lang != config('app.default_lang.id'))
            <p class="alert alert-warning">
                {{ __('To see all the settings, change the language to :lang', ['lang' => config('app.default_lang.title')]) }}
            </p>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general"
                                            role="tab" aria-controls="general"
                                            aria-selected="true">{{ __('General Settings') }}</a>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="theme-tab" data-toggle="tab" href="#theme" role="tab"
                                        aria-controls="theme" aria-selected="false">Theme
                                        Settings</a>
                                </li> --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact"
                                            role="tab" aria-controls="contact"
                                            aria-selected="false">{{ __('Contact Page') }}</a>
                                    </li>
                                    @if ($lang == config('app.default_lang.id'))
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="custom-html-tab" data-toggle="tab"
                                            href="#custom-html" role="tab" aria-controls="custom-html"
                                            aria-selected="false">{{ __('Custom HTML') }}</a>
                                    </li>
                                    @endif
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social"
                                            role="tab" aria-controls="social"
                                            aria-selected="false">{{ __('Social Links') }}</a>
                                    </li>
                                    @if ($lang == config('app.default_lang.id'))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="email-tab" data-toggle="tab" href="#email"
                                                role="tab" aria-controls="email"
                                                aria-selected="false">{{ __('Email Settings') }}</a>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="url-shortener-tab" data-toggle="tab"
                                                href="#url-shortener" role="tab" aria-controls="url-shortener"
                                                aria-selected="false">{{ __('URL Shortener') }}</a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content mt-4" id="myTabContent">
                                    <div class="tab-pane fade show active" id="general" role="tabpanel"
                                        aria-labelledby="general-tab">
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7">
                                                <div class="form-group row">
                                                    <label for="title"
                                                        class="col-sm-2 col-form-label">{{ __('Site Title') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="title"
                                                            name="settings[title]"
                                                            value="{{ isset($settings['title']) ? $settings['title'] : config('settings.title') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="short_title"
                                                        class="col-sm-2 col-form-label">{{ __('Site Short Title') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="short_title"
                                                            name="settings[short_title]"
                                                            value="{{ isset($settings['short_title']) ? $settings['short_title'] : config('settings.short_title') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="description"
                                                        class="col-sm-2 col-form-label">{{ __('Site Description') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="settings[description]" id="description" class="form-control">{{ isset($settings['description']) ? $settings['description'] : config('settings.description') }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keywords"
                                                        class="col-sm-2 col-form-label">{{ __('Site Keywords') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="settings[keywords]" id="keywords" class="form-control">{{ isset($settings['keywords']) ? $settings['keywords'] : config('settings.keywords') }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="footer_text"
                                                        class="col-sm-2 col-form-label">{{ __('Footer Text') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="settings[footer_text]" id="footer_text" class="form-control">{{ isset($settings['footer_text']) ? $settings['footer_text'] : config('settings.footer_text') }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="footer_subtitle"
                                                        class="col-sm-2 col-form-label">{{ __('Copyright Text') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="settings[footer_subtitle]" id="footer_subtitle" class="form-control">{{ isset($settings['footer_subtitle']) ? $settings['footer_subtitle'] : config('settings.footer_subtitle') }} </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="cookie_text"
                                                        class="col-sm-2 col-form-label">{{ __('Cookie Alert Text') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="settings[cookie_text]" id="cookie_text" class="form-control">{{ isset($settings['cookie_text']) ? $settings['cookie_text'] : config('settings.cookie_text') }} </textarea>
                                                    </div>
                                                </div>
                                                @if ($lang == config('app.default_lang.id'))
                                                    <div class="form-group row">
                                                        <label for="timezone"
                                                            class="col-sm-2 col-form-label">{{ __('Timezone') }}</label>
                                                        <div class="col-sm-10">
                                                            <select name="settings[timezone]" class="form-control"
                                                                id="timezone">
                                                                @foreach ($timezones as $timezone)
                                                                    <optgroup for="{{ $timezone->group }}">
                                                                        @foreach ($timezone->zones as $utc)
                                                                            <option
                                                                                value="{{ $utc->value }}"{{ isset($settings['timezone']) && $settings['timezone'] == $utc->value ? ' selected' : (isset($settings['timezone']) ? $settings['timezone'] : config('settings.timezone')) }}>
                                                                                {{ $utc->value }}</option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>{{ __('Visual Settings') }}</h4>
                                                    <div class="form-group row">
                                                        <label for="color"
                                                            class="col-sm-2 col-form-label">{{ __('Primary Color') }}</label>
                                                        <div class="col-sm-10 square">
                                                            <input type="text" class="form-control" data-coloris
                                                                placeholder="{{ __('Select Primary Color') }}"
                                                                name="settings[color]" id="color"
                                                                value="{{ isset($settings['color']) ? $settings['color'] : config('settings.color') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="title"
                                                            class="col-sm-2 col-form-label">{{ __('Cookie Alert') }}</label>
                                                        <div class="col-sm-10">
                                                            <select name="settings[cookie_alert]" id="cookie_alert" class="form-control">
                                                                <option value="0"{{ isset($settings['cookie_alert']) && $settings["cookie_alert"] == 0 ? ' selected' : '' }}>{{ __('Inactive') }}</option>
                                                                <option value="1"{{ isset($settings['cookie_alert']) && $settings["cookie_alert"] == 1 ? ' selected' : '' }}>{{ __('Active') }}</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="title"
                                                            class="col-sm-2 col-form-label">{{ __('Newsletter Modal') }}</label>
                                                        <div class="col-sm-10">
                                                            <select name="settings[newsletter_modal]" id="newsletter_modal" class="form-control">
                                                                <option value="0"{{ isset($settings['newsletter_modal']) && $settings["newsletter_modal"] == 0 ? ' selected' : '' }}>{{ __('Inactive') }}</option>
                                                                <option value="1"{{ isset($settings['newsletter_modal']) && $settings["newsletter_modal"] == 1 ? ' selected' : '' }}>{{ __('Active') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h4>{{ __('Google ReCaptcha') }}</h4>
                                                    <div class="form-group row">
                                                        <label for="grc_sitekey"
                                                            class="col-sm-2 col-form-label">{{ __('Site Key') }}</label>
                                                        <div class="col-sm-10 square">
                                                            <input type="text" class="form-control"
                                                                name="settings[recaptcha][key]" id="grc_sitekey"
                                                                value="{{ isset($settings['recaptcha']) ? $settings['recaptcha']->key : config('settings.recaptcha')->key }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="grc_secretkey"
                                                            class="col-sm-2 col-form-label">{{ __('Secret Key') }}</label>
                                                        <div class="col-sm-10 square">
                                                            <input type="text" class="form-control"
                                                                name="settings[recaptcha][secret]" id="grc_secretkey"
                                                                value="{{ isset($settings['recaptcha']) ? $settings['recaptcha']->secret : config('settings.recaptcha')->secret }}">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-5 col-md-5">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="card">
                                                            <h4 class="card-header font-weight-bold">
                                                                {{ __('Logo') }}
                                                            </h4>
                                                            <div class="card-body p-0">
                                                                @include('admin.common.imager.single', [
                                                                    'target' => 'logo',
                                                                    'name' => 'settings[logo]',
                                                                    'info_text' => false,
                                                                    'dir' => 'others',
                                                                    'sizes' => ['308x60'],
                                                                    'selected_image' => isset($settings['logo'])
                                                                        ? $settings['logo']
                                                                        : config('settings.logo'),
                                                                ])
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="card">
                                                            <h4 class="card-header font-weight-bold">
                                                                {{ __('Footer Logo') }}</h4>
                                                            <div class="card-body p-0">
                                                                @include('admin.common.imager.single', [
                                                                    'target' => 'footer_logo',
                                                                    'name' => 'settings[footer_logo]',
                                                                    'info_text' => false,
                                                                    'dir' => 'others',
                                                                    'sizes' => ['308x60'],
                                                                    'selected_image' => isset(
                                                                        $settings['footer_logo']
                                                                    )
                                                                        ? $settings['footer_logo']
                                                                        : config('settings.footer_logo'),
                                                                ])
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="card">
                                                            <h4 class="card-header font-weight-bold">
                                                                {{ __('Favicon') }}
                                                            </h4>
                                                            <div class="card-body p-0">
                                                                @include('admin.common.imager.mini', [
                                                                    'target' => 'favicon',
                                                                    'name' => 'settings[favicon]',
                                                                    'info_text' => false,
                                                                    'dir' => 'others',
                                                                    'sizes' => ['128x128'],
                                                                    'selected_image' => isset($settings['favicon'])
                                                                        ? $settings['favicon']
                                                                        : config('settings.favicon'),
                                                                ])
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel"
                                        aria-labelledby="contact-tab">

                                        <div class="row">
                                            <div class="col-lg-7 col-md-7">
                                                <div class="form-group row">
                                                    <label for="address"
                                                        class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            name="settings[contact][address]"
                                                            value="{{ isset($settings['contact']) ? $settings['contact']->address : config('settings.contact')->address }}"
                                                            id="address">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="phone"
                                                        class="col-sm-2 col-form-label">{{ __('Phone Number') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            name="settings[contact][phone]" id="phone"
                                                            value="{{ isset($settings['contact']) ? $settings['contact']->phone : config('settings.contact')->phone }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="emails"
                                                        class="col-sm-2 col-form-label">{{ __('Email Address') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            name="settings[contact][email]" id="emails"
                                                            value="{{ isset($settings['contact']) ? $settings['contact']->email : config('settings.contact')->email }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="coordinates"
                                                        class="col-sm-2 col-form-label">{{ __('Coordinates') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            name="settings[contact][coordinates]" id="coordinates"
                                                            value="{{ isset($settings['contact']) ? $settings['contact']->coordinates : config('settings.contact')->coordinates }}"
                                                            placeholder="(Ex. 48.8534951,2.3483915)">
                                                        <small class="text-muted">
                                                            You can visit <a href="" class="text-primary"
                                                                target="_blank">https://www.latlong.net/</a> to find
                                                            the
                                                            coordinates. <br />(Ex. 48.8534951,2.3483915)
                                                        </small>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="social" role="tabpanel"
                                        aria-labelledby="social-tab">

                                        <div class="form-group row">
                                            <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][facebook]" id="facebook"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->facebook : config('settings.socials')->facebook }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][twitter]" id="twitter"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->twitter : config('settings.socials')->twitter }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][instagram]" id="instagram"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->instagram : config('settings.socials')->instagram }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="youtube" class="col-sm-2 col-form-label">Youtube</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][youtube]" id="youtube"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->youtube : config('settings.socials')->youtube }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pinterest" class="col-sm-2 col-form-label">Pinterest</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][pinterest]" id="pinterest"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->pinterest : config('settings.socials')->pinterest }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="linkedin" class="col-sm-2 col-form-label">Linkedin</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][linkedin]" id="linkedin"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->linkedin : config('settings.socials')->linkedin }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="vk" class="col-sm-2 col-form-label">VK</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][vk]" id="vk"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->vk : config('settings.socials')->vk }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telegram" class="col-sm-2 col-form-label">Telegram</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                    name="settings[socials][telegram]" id="telegram"
                                                    value="{{ isset($settings['socials']) ? $settings['socials']->telegram : config('settings.socials')->telegram }}">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($lang == config('app.default_lang.id'))
                                        <div class="tab-pane fade" id="email" role="tabpanel"
                                            aria-labelledby="email-tab">
                                            <h4>{{ __('SMTP Settings') }}</h4>
                                            <div class="form-group row">
                                                <label for="verification"
                                                    class="col-sm-2 col-form-label">{{ __('Email Verification') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="settings[mail][verification]" id="verification"
                                                        class="form-control">
                                                        <option
                                                            value="0"{{ isset($settings['mail']->verification) && $settings['mail']->verification == '0' ? ' selected' : config('settings.mail')->verification }}>
                                                            {{ __('Inactive') }}</option>
                                                        <option
                                                            value="1"{{ isset($settings['mail']->verification) && $settings['mail']->verification == '1' ? ' selected' : config('settings.mail')->verification }}>
                                                            {{ __('Active') }}</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="host"
                                                    class="col-sm-2 col-form-label">{{ __('Mail Host') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="settings[mail][host]" id="host"
                                                        value="{{ isset($settings['mail']->host) ? $settings['mail']->host : config('settings.mail')->host }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name"
                                                    class="col-sm-2 col-form-label">{{ __('Mail Username') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="settings[mail][username]" id="name"
                                                        value="{{ isset($settings['mail']->username) ? $settings['mail']->username : config('settings.mail')->username }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password"
                                                    class="col-sm-2 col-form-label">{{ __('Mail Password') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control"
                                                        name="settings[mail][password]" id="password"
                                                        value="{{ isset($settings['mail']->password) ? $settings['mail']->password : config('settings.mail')->password }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="port"
                                                    class="col-sm-2 col-form-label">{{ __('Port') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="settings[mail][port]" id="port"
                                                        value="{{ isset($settings['mail']->port) ? $settings['mail']->port : config('settings.mail')->post }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="encryption"
                                                    class="col-sm-2 col-form-label">{{ __('Encryption') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="settings[mail][encryption]" id="encryption"
                                                        class="form-control">
                                                        <option
                                                            value="TSL"{{ isset($settings['mail']->encryption) && $settings['mail']->encryption == 'TSL' ? ' selected' : config('settings.mail')->encryption }}>
                                                            TSL</option>
                                                        <option
                                                            value="SSL"{{ isset($settings['mail']->encryption) && $settings['mail']->encryption == 'SSL' ? ' selected' : config('settings.mail')->encryption }}>
                                                            SSL</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="show_name"
                                                    class="col-sm-2 col-form-label">{{ __('Show Name') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="settings[mail][show_name]" id="show_name"
                                                        value="{{ isset($settings['mail']->show_name) ? $settings['mail']->show_name : config('settings.mail')->show_name }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-html" role="tabpanel"
                                            aria-labelledby="custom-html-tab">
                                            <div class="form-group row">
                                                <label for="footer-html"
                                                    class="col-sm-2 col-form-label">{{ __('Header HTML Code') }}</label>
                                                <div class="col-sm-10">
                                                   <textarea name="settings[header_html]" id="footer-html" cols="30" rows="10" class="form-control">{{ isset($settings['header_html']) ? $settings['header_html'] : config('settings.header_html') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="footer-html"
                                                    class="col-sm-2 col-form-label">{{ __('Footer HTML Code') }}</label>
                                                <div class="col-sm-10">
                                                   <textarea name="settings[footer_html]" id="footer-html" cols="30" rows="10" class="form-control">{{ isset($settings['footer_html']) ? $settings['footer_html'] : config('settings.footer_html') }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="url-shortener" role="tabpanel"
                                            aria-labelledby="url-shortener-tab">
                                            <div class="form-group row">
                                                <label for="shortener-enabled"
                                                    class="col-sm-2 col-form-label">{{ __('URL Shortener Enabled') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="settings[shortener]" id="shortener-enabled"
                                                        class="form-control">
                                                        <option
                                                            value="0"{{ isset($settings['shortener']) && $settings['shortener'] == 0 ? '' : ' selected' }}>
                                                            {{ __('No') }}</option>
                                                        <option
                                                            value="1"{{ isset($settings['shortener']) && $settings['shortener'] == 1 ? ' selected' : '' }}>
                                                            {{ __('Yes') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group row {{ isset($settings['shortener']) && $settings['shortener'] == 0 ? 'd-none' : '' }} different-domain-div">
                                                <label for="shortener_domain"
                                                    class="col-sm-2 col-form-label">{{ __('Select Domain') }}</label>
                                                <div class="col-sm-10">
                                                    <select name="settings[select_domain]" id="select_domain"
                                                        class="form-control">
                                                        <option
                                                            value="0"{{ isset($settings['shortener']) && isset($settings['select_domain']) && $settings['select_domain'] != 1 ? ' selected' : '' }}>
                                                            {{ __('Use main domain') }}</option>
                                                        <option
                                                            value="1"{{ isset($settings['shortener']) && isset($settings['select_domain']) && $settings['select_domain'] == 1 ? ' selected' : '' }}>
                                                            {{ __('Use different domain') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div
                                                class="different-domain {{ isset($settings['shortener']) && $settings['shortener'] == 1 && isset($settings['select_domain']) && $settings['select_domain'] == 1 ? '' : 'd-none' }} row">
                                                <label for="shortener_domain"
                                                    class="col-sm-2 col-form-label">{{ __('Use Different Domain') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="settings[shortener_domain]" id="shortener_domain"
                                                        value="{{ isset($settings['shortener_domain']) ? $settings['shortener_domain'] : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success float-right btn-lg"><i class="fa fa-save"></i>
                    {{ __('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
<script src="{{ url('/') }}/backend/vendor/coloris/coloris.min.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/vendor/coloris/coloris.min.css">
<script>
    $('#shortener-enabled').change(function() {
        var elm = $(this);
        if (elm.val() == '1') {
            $('.different-domain-div').removeClass('d-none');
        } else {
            $('.different-domain-div').addClass('d-none');
        }
    })
    $('#select_domain').change(function() {
        var elm = $(this);
        if (elm.val() == '1') {
            $('.different-domain').removeClass('d-none');
        } else {
            $('.different-domain').addClass('d-none');
        }
    })
</script>
