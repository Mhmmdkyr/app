<header>
    <div class="desktop">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <ul class="top-bar-nav top-bar-left">
                            @foreach ($top_pages as $page)
                                <li><a href="{{ uri('page', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                            <li><a href="{{ uri('contact-us') }}">{{ __('Contact Us') }}</a></li>
                        </ul>
                        <ul class="top-bar-nav float-right position-relative">
                            @if (isset(config('settings.socials')->facebook))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->facebook }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-facebook"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->twitter))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->twitter }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->instagram))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->instagram }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->youtube))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->youtube }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-youtube"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->pinterest))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->pinterest }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-pinterest"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->linkedin))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->linkedin }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                                </li>
                            @endif
                            @if (isset(config('settings.socials')->vk))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->vk }}" rel="nofollow" target="_blank"><i
                                            class="fa-brands fa-vk"></i></a>
                                </li>
                            @endif

                            @if (isset(config('settings.socials')->telegram))
                                <li class="social-link">
                                    <a href="{{ config('settings.socials')->telegram }}" rel="nofollow"
                                        target="_blank"><i class="fa-brands fa-telegram"></i></a>
                                </li>
                            @endif
                            <li>
                                <div class="btn-group">
                                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"
                                        href="javascript:;">
                                        @foreach ($languages as $lang)
                                            @if (app()->getLocale() == $lang->slug)
                                                <i class="fa fa-globe"></i> {{ $lang->title }}
                                            @endif
                                        @endforeach

                                    </a>
                                    <div class="dropdown-menu">
                                        @foreach ($languages as $lang)
                                            @if (app()->getLocale() != $lang->slug)
                                                <a class="dropdown-item" hreflang="{{ $lang->slug }}"
                                                    href="{{ url('', $lang->id != config('app.default_lang.id') ? $lang->slug : '') }}">
                                                    {{ $lang->title }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="run-bar-item run-dark-mode">
                                    <label class="run-toggle-container">
                                        <input type="checkbox"
                                            class="run-dark-mode-toggle"{{ session()->has('dark_mode') ? ' checked' : '' }}
                                            data-change="{{ route('dynamic.dark_mode') }}">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="main-nav">
            <div class="container">
                <div class="row position-relative">
                    <div class="col-lg-3 col-md-3">
                        <div class="logo">
                            <a href="{{ uri('') }}">
                                <img @if (session()->has('dark_mode')) src="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo')) : url('/') . '/themes/' . $theme->path . '/img/footer-logo.png' }}"
                                @else
                                src="{{ config('settings.logo') ? image_url(config('settings.logo')) : url('/') . '/themes/' . $theme->path . '/img/logo.png' }}" @endif
                                    data-light="{{ config('settings.logo') ? image_url(config('settings.logo')) : url('/') . '/themes/' . $theme->path . '/img/logo.png' }}"
                                    data-dark="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo')) : url('/') . '/themes/' . $theme->path . '/img/footer-logo.png' }}"
                                    alt="{{ config('settings.title') }}" height="40">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 position-static">
                        <ul class="main-menu">
                            <li class="home-link"><a href="{{ uri('') }}"><i class="fas fa-home"></i></a></li>
                            @foreach ($menu as $item)
                                <li><a href="{{ uri('category', $item->slug) }}"
                                        class="mm-item{{ count($item->subs) > 0 ? ' mm-megamenu' : '' }}">{{ $item->category_title }}
                                        @if (count($item->subs) > 0)
                                            <i class="fa fa-chevron-down menu-arrow"></i>
                                        @endif
                                    </a>
                                    @if ($item->subs && count($item->subs) > 0)
                                        <div class="megamenu">
                                            <div class="container">
                                                <div class="row position-relative">
                                                    <div class="col-lg-2 col-md-2 pr-0">
                                                        <div class="mm-tab">
                                                            <div class="mm-tab-content">
                                                                <a href="{{ uri('category', $item->slug) }}"
                                                                    data-id="{{ $item->id }}"
                                                                    class="active">{{ __('All') }}</a>
                                                                @foreach ($item->subs as $k => $sub)
                                                                    <a href="{{ uri('category', $sub->slug) }}"
                                                                        data-id="{{ $sub->id }}">{{ $sub->category_title }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="sbanners row" data-category=""></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                </li>
                            @endforeach
                            <li class="separator"></li>
                            <li><a href="javascript:;" class="collapse-search"><i class="fas fa-search"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile position-relative">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <a href="javascript:;" data-toggle="ahtoogler" data-target=".left-drawer" data-change="opened"
                        class="toggler-icon float-left"><i class="fas fa-bars"></i></a>
                </div>
                <div class="col-8">
                    <div class="logo text-center">
                        <a href="{{ uri('') }}">
                            <img @if (session()->has('dark_mode')) src="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo')) : url('/') . '/themes/' . $theme->path . '/img/footer-logo.png' }}"
                                @else
                                src="{{ config('settings.logo') ? image_url(config('settings.logo')) : url('/') . '/themes/' . $theme->path . '/img/logo.png' }}" @endif
                                data-light="{{ config('settings.logo') ? image_url(config('settings.logo')) : url('/') . '/themes/' . $theme->path . '/img/logo.png' }}"
                                data-dark="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo')) : url('/') . '/themes/' . $theme->path . '/img/footer-logo.png' }}"
                                alt="{{ config('settings.title') }}" height="25">
                        </a>
                    </div>
                </div>
                <div class="col-2">
                    <a href="javascript:;" data-toggle="ahtoogler" data-target=".mobile .search-area"
                        data-change="opened" class="toggler-icon float-right"><i class="fas fa-search"></i></a>
                </div>
            </div>
        </div>
        <div class="left-drawer transition">
            <div class="row">
                <div class="col-10">
                    <div class="logo">
                        <a href="{{ uri('') }}">
                            <img @if (session()->has('dark_mode')) src="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo')) : url('/') . '/themes/' . $theme->path . '/img/footer-logo.png' }}"
                                @else
                                src="{{ config('settings.logo') ? image_url(config('settings.logo')) : url('/') . '/themes/' . $theme->path . '/img/logo.png' }}" @endif
                                data-light="{{ config('settings.logo') ? image_url(config('settings.logo')) : url('/') . '/themes/' . $theme->path . '/img/logo.png' }}"
                                data-dark="{{ config('settings.footer_logo') ? image_url(config('settings.footer_logo')) : url('/') . '/themes/' . $theme->path . '/img/footer-logo.png' }}"
                                alt="{{ config('settings.title') }}" height="40">
                        </a>
                    </div>
                </div>
                <div class="col-2">
                    <a href="javascript:;" data-toggle="ahtoogler" data-target=".left-drawer" data-change="opened"
                        class="toggler-icon float-right"><i class="fas fa-times"></i></a>
                </div>
            </div>
            <hr class="mt-0">
            <ul class="main-menu">
                @foreach ($menu as $item)
                    <li><a href="{{ uri('category', $item->slug) }}">{{ $item->category_title }}</a></li>
                @endforeach
                <li class="separator"></li>
                <li><a href="{{ uri('all/video') }}">{{ __('Videos') }}</a></li>
                <li><a href="#login-modal" data-toggle="modal" class="text-primary">{{ __('Login') }}</a>
                </li>
                <li class="separator"></li>
                @foreach ($top_pages as $page)
                    <li><a href="{{ uri('page', $page->slug) }}">{{ $page->title }}</a></li>
                @endforeach
                <li class="separator"></li>
                @if (isset(config('settings.socials')->facebook))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->facebook }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-facebook"></i></a>
                    </li>
                @endif
                @if (isset(config('settings.socials')->twitter))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->twitter }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-twitter"></i></a>
                    </li>
                @endif
                @if (isset(config('settings.socials')->instagram))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->instagram }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-instagram"></i></a>
                    </li>
                @endif
                @if (isset(config('settings.socials')->youtube))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->youtube }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-youtube"></i></a>
                    </li>
                @endif
                @if (isset(config('settings.socials')->pinterest))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->pinterest }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-pinterest"></i></a>
                    </li>
                @endif
                @if (isset(config('settings.socials')->linkedin))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->linkedin }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-linkedin"></i></a>
                    </li>
                @endif
                @if (isset(config('settings.socials')->vk))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->vk }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-vk"></i></a>
                    </li>
                @endif

                @if (isset(config('settings.socials')->telegram))
                    <li class="social-link">
                        <a href="{{ config('settings.socials')->telegram }}" rel="nofollow" target="_blank"><i
                                class="fa-brands fa-telegram"></i></a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="search-area transition">
            <form action="{{ route('frontend.posts.search') }}" method="get">
                <div class="search-inducator">
                    <input type="text" name="q" placeholder="{{ __('Search in posts') }}">
                    <i class="fas fa-times uncollapse-search"></i>
                </div>
            </form>
        </div>
    </div>
</header>
<div class="clear"></div>
<div class="search-wrapper transition">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8">
                <div class="text-center">
                    <h2>{{ __('Search') }}</h2>
                    <form action="{{ route('frontend.posts.search') }}" method="get">
                        <div class="input-wrapper">
                            <input type="text" placeholder="{{ __('Search in posts') }}" name="q"
                                required>
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <i class="fa fa-times collapse-search"></i>
    </div>
</div>
<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div class="breaking-news">
                    <h3 class="float-left text-uppercase"><i class="fas fa-bullhorn"></i> {{ __('Breaking') }}</h3>
                    <div class="swiper breakings">
                        <ul class="swiper-wrapper">
                            @foreach ($breakings as $breaking)
                                <li class="swiper-slide">
                                    <a href="{{ uri('post', $breaking->slug) }}">
                                        <p>
                                            <span>{{ $breaking->title }}</span>
                                            <span class="breaking-time"><small><i class="fa-regular fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($breaking->publish_date)->diffForHumans() }}</small></span>
                                        </p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bread-controls">
                        <a href="javascript:;" class="bread-prev"><i class="fa fa-chevron-left"></i></a>
                        <a href="javascript:;" class="bread-next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 text-right breaking-right d-none d-md-none d-lg-block">
                <a href="{{ uri('all/video') }}" class="btn btn-link"><i class="fas fa-video"></i>
                    {{ __('Videos') }}</a>
                @if (!auth()->user())
                    <a href="#login-modal" data-toggle="modal" class="btn btn-outline-primary"><i
                            class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                @else
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary user-dropdown dropdown-toggle"
                            data-toggle="dropdown" aria-expanded="false">
                            <img src="{{ image_url(auth()->user()->avatar, '250x250') }}"
                                alt="{{ auth()->user()->name }}">
                            {{ auth()->user()->name }}
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-item">
                                <h5 class="mt-b">{{ auth()->user()->name }}</h5>
                                <p class="text-muted p-0 m-0" style="margin-top: -15px !important">
                                    <small>{{ auth()->user()->email }}</small>
                                </p>
                            </div>
                            @if (auth()->user()->role->panel_login)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                        class="fas fa-cog"></i> {{ __('Admin Panel') }}</a>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item" href="{{ route('frontend.user.profile') }}"><i
                                    class="far fa-user"></i>
                                {{ __('Profile') }}</a>
                            <a class="dropdown-item" href="{{ route('frontend.user.favorites') }}"><i
                                    class="far fa-heart"></i>
                                {{ __('Favorites') }}</a>
                            <a class="dropdown-item" href="{{ route('frontend.user.comments') }}"><i
                                    class="far fa-comments"></i>
                                {{ __('Comments') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('frontend.login.logout') }}"><i
                                    class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
