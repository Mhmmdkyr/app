@if (count($sliders) > 0 || count($slider_right) > 0 || count($featureds) > 0)
    <section class="main-container">
        <div class="container">
            <div class="row">
                @if (count($sliders) > 0)
                    <div class="col-lg-6 col-md-8">
                        <div class="main-banners swiper">
                            <div class="swiper-wrapper">
                                @foreach ($sliders as $slider)
                                    <div class="swiper-slide banner-item">
                                        <div class="banner-item-content">
                                            <a href="{{ uri('post', $slider->slug) }}">

                                                <img src="{{ image_url('placeholders/lg.jpg', '700x394') }}"
                                                    data-src="{{ image_url($slider->images->slider_image ? $slider->images->slider_image : $slider->images->featured_image, '700x394') }}"
                                                    alt="{{ $slider->title }}" class="swiper-lazy">
                                            </a>
                                            <div class="banner-item-desc">
                                                @if ($slider->categories)
                                                    <a href="{{ uri('category', $slider->categories[0]->slug) }}"
                                                        class="banner-category category-{{ $slider->categories[0]->id }}">
                                                        <i class="fas fa-genderless"></i> {{ $slider->categories[0]->category_title }}</a>
                                                @endif
                                                <p><a href="{{ uri('post', $slider->slug) }}"
                                                        class="text-white">{{ $slider->title }}</a>
                                                </p>
                                                <small class="d-block"><i class="fa-regular fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($slider->publish_date)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="banner-pagination swiper-pagination"></div>
                        </div>
                    </div>
                @endif
                @if (count($slider_right) > 0)
                    <div class="col-lg-3 col-md-4">
                        <div class="sbanners">
                            @foreach ($slider_right as $sright)
                                <a href="{{ uri('post', $sright->slug) }}" class="sbanner-item">
                                    <div class="sbanner-item-category category-{{ $sright->categories[0]->id }}">
                                        <i class="fas fa-genderless"></i> {{ $sright->categories[0]->category_title }}</div>
                                    <div class="sbanner-item-img">
                                        <img src="{{ image_url('placeholders/lg.jpg', '500x281') }}"
                                            data-src="{{ image_url($sright->images->slider_image ? $sright->images->slider_image : $sright->images->featured_image, '500x281') }}"
                                            alt="{{ $sright->title }}" class="lazy">
                                    </div>
                                    <div class="sbanner-item-desc">
                                        <p>{{ $sright->title }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (count($featureds) > 0)
                    <div class="col-lg-3 col-md-12">
                        <div class="list-items latest-posts">
                            <h4 class="text-uppercase"><i class="fas fa-highlighter"></i> {{ __('Featured Posts') }}</h4>
                            <ul class="list-item">
                                @foreach ($featureds as $featured)
                                    <li>
                                        <a href="{{ uri('post', $featured->slug) }}">{{ $featured->title }}<span><i
                                                    class="fa-regular fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($featured->publish_date)->diffForHumans() }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
@if (count($recommendeds) > 0)
    <section class="trends">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="trend-area">
                        <div class="trend-area-content">
                            <h3 class="float-left text-uppercase"><i class="fas fa-fire-alt"></i> {{ __('Trends') }}</h3>
                            <a href="" class="all-trends float-right"><i class="fas fa-caret-right"></i>
                                {{ __('All Trends') }}</a>
                            <div class="clear"></div>
                            <div class="row">
                                @foreach ($recommendeds as $recommended)
                                    <div class="col-lg-3 col-md-4">
                                        <a href="{{ uri('post', $recommended->slug) }}" class="trend-item">
                                            <div
                                                class="trend-item-category category-{{ $recommended->categories[0]->id }}">
                                                <i class="fas fa-genderless"></i> {{ $recommended->categories[0]->category_title }}</div>
                                            <div class="trend-item-img">
                                                <img src="{{ image_url('placeholders/lg.jpg', '500x281') }}"
                                                    data-src="{{ image_url($recommended->images->slider_image ? $recommended->images->slider_image : $recommended->images->featured_image, '500x281') }}"
                                                    alt="{{ $recommended->title }}" class="lazy">
                                            </div>
                                            <div class="trend-item-desc">
                                                <p>{{ $recommended->title }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<div class="clear"></div>
<section class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                @if (config('settings.ads') && isset(config('settings.ads')->home_top_desktop))
                    <div class="d-none d-md-none d-lg-block mb-d">
                        {!! config('settings.ads')->home_top_desktop !!}
                    </div>
                    <div class="clear"></div>
                @endif
                @if (config('settings.ads') && isset(config('settings.ads')->home_top_mobile))
                    <div class="d-block d-sm-none mt-3">
                        {!! config('settings.ads')->home_top_mobile !!}
                    </div>
                @endif
                @foreach ($blocks as $kay => $block)
                    @include('themes/' . $theme->path . '/blocks/posts/' . $block->home_block->type, [
                        'item' => $block,
                    ])
                @endforeach
                <div class="d-none d-md-none d-lg-block">
                    @if (config('settings.ads') && isset(config('settings.ads')->home_middle_desktop))
                        {!! config('settings.ads')->home_middle_desktop !!}
                    @endif
                </div>
                <div class="d-block d-sm-none">
                    @if (config('settings.ads') && isset(config('settings.ads')->home_middle_mobile))
                        {!! config('settings.ads')->home_middle_mobile !!}
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                @include('themes.' . $theme->path . '.includes.sidebar')
            </div>
        </div>

    </div>
</section>
@if (count($videos) > 0)
    <div class="section-video-area mt-d">
        <div class="container">
            <div class="row" style="position: relative; z-index: 12;">
                <div class="col-lg-12">
                    <h3 class="text-white mb-3 text-uppercase"><i class="fa fa-video"></i> {{ __('Videos') }}</h3>
                </div>
                <div class="col-lg-7 col-md-7">
                    @foreach ($videos as $i => $video)
                        @if ($i <= 0)
                            <div class="banner-item-content">
                                <a href="{{ uri('post', $video->slug) }}">
                                    <img src="{{ image_url('placeholders/lg.jpg', '700x394') }}"
                                        data-src="{{ image_url($video->images->featured_image, '700x394') }}"
                                        alt="{{ $video->title }}" class="lazy">
                                </a>
                                <div class="banner-item-desc">
                                    @if ($video->categories)
                                        <a href="{{ uri('category', $video->categories[0]->slug) }}"
                                            class="banner-category category-{{ $video->categories[0]->id }}">
                                            <i class="fas fa-genderless"></i> {{ $video->categories[0]->category_title }}</a>
                                    @endif
                                    <p><a href="{{ uri('post', $video->slug) }}"
                                            class="text-white">{{ $video->title }}</a>
                                    </p>
                                    <small class="d-block"><i class="fa-regular fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($video->publish_date)->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="video-side scrollable-dark">
                        <div class="row position-relative">
                            @foreach ($videos as $i => $video2)
                                @if ($i > 0)
                                    <div class="col-lg-6 col-md-6 mb-4">
                                        <div class="card-banner-item position-relative">
                                            <div class="card-banner-item-content">
                                                <a href="{{ uri('post', $video2->slug) }}"><img
                                                        src="{{ image_url('placeholders/lg.jpg', '1000x563') }}"
                                                        data-src="{{ image_url($video2->images->featured_image, '1000x563') }}"
                                                        alt="{{ $video2->title }}" class="lazy"></a>
                                                <div class="card-banner-item-desc">
                                                    <p class=" two-lines"><a href="{{ uri('post', $video2->slug) }}"
                                                            class="text-white two-lines">{{ $video2->title }}</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<section class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                @if (count($latest_posts) > 0)
                    <div class="card card-type-1 mt-d mb-d">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-4 col-md-4"><span
                                        class="card-rounded-title bg-primary">{{ __('Latest Posts') }}</span></div>
                                <div class="col-lg-8 col-md-8">
                                    <ul class="card-tab">
                                        <li><a href="{{ uri('all') }}" class="text-primary"><i
                                                    class="fas fa-caret-right"></i>{{ __('All Posts') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" style="position: relative; z-index: 12;">
                                @foreach ($latest_posts as $latest)
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="big-item">
                                                    <a href="{{ uri('post', $latest->slug) }}"><img
                                                            src="{{ image_url('placeholders/lg.jpg', '700x394') }}"
                                                            data-src="{{ image_url($latest->images->featured_image, '700x394') }}"
                                                            alt="{{ $latest->title }}" class="lazy"></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 big-item-caption">
                                                <h4><a
                                                        href="{{ uri('post', $latest->slug) }}">{{ $latest->title }}</a>
                                                </h4>
                                                <p>{{ Str::limit($latest->description, 300, $end = '...') }}
                                                </p>
                                                <small><i class="fa-regular fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($latest->publish_date)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-3 col-md-3 mb-4">
                <div class="sticky-top">
                    <div class="sidebar mt-d mb-3">
                        <div class="sidebar-title text-uppercase">{{ __('Follow us') }}</div>
                        <div class="row">
                            @if (isset(config('settings.socials')->facebook))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->facebook }}" rel="nofollow"
                                        target="_blank" class="btn btn-facebook btn-block btn-social text-left"><i
                                            class="fa-brands fa-facebook"></i> Facebook</a>
                                </div>
                            @endif
                            @if (isset(config('settings.socials')->twitter))
                                <div class="col-lg-6 col-md-6">
                                    <a href="{{ config('settings.socials')->twitter }}" rel="nofollow"
                                        target="_blank" class="btn btn-twitter btn-block btn-social text-left"><i
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
                                    <a href="{{ config('settings.socials')->youtube }}" rel="nofollow"
                                        target="_blank" class="btn btn-youtube btn-block btn-social text-left"><i
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
                    <div class="clear"></div>
                    <div class="mb-d float-left">
                        @if (config('settings.ads') && isset(config('settings.ads')->sidebar_bottom_desktop))
                            {!! config('settings.ads')->sidebar_bottom_desktop !!}
                        @endif
                    </div>
                    <div class="clear"></div>
                    @if (count($random_posts) > 0)
                        <div class="sidebar">
                            <div class="sidebar-title text-uppercase">{{ __('Random Posts') }}</div>
                            <div class="list-items with-img">
                                <ul class="list-item">
                                    @foreach ($random_posts as $i => $post)
                                        <li><a href="{{ uri('post', $post->slug) }}"><img
                                                    src="{{ image_url('placeholders/lg.jpg', '500x281') }}"
                                                    data-src="{{ image_url($post->images->featured_image, '500x281') }}"
                                                    alt="{{ $post->title }}" class="lazy"> <b class="two-lines">
                                                    {{ $post->title }}</b><span><i class="fa-regular fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
