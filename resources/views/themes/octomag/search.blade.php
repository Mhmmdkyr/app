<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Search result for ":q"', ['q' => Request::get("q")]) }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    <h1 class="mb-0 mt-0">{{ __('Search result for ":q"', ['q' => Request::get("q")]) }}</h1>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            @foreach ($posts as $k => $latest)
                            @if($k == 1)
                            <div class="d-none d-md-none d-lg-block">
                                @if (config('settings.ads') && isset(config('settings.ads')->category_middle_desktop))
                                    {!! config('settings.ads')->category_middle_desktop !!}
                                @endif
                            </div>
                            <div class="d-block d-sm-none">
                            @if (config('settings.ads') && isset(config('settings.ads')->category_middle_mobile))
                                {!! config('settings.ads')->category_middle_mobile !!}
                            @endif
                            </div>
                            @endif

                            @if($k == 13)
                            <div class="d-none d-md-none d-lg-block">
                                @if (config('settings.ads') && isset(config('settings.ads')->category_bottom_desktop))
                                    {!! config('settings.ads')->category_bottom_desktop !!}
                                @endif
                            </div>
                            <div class="d-block d-sm-none">
                            @if (config('settings.ads') && isset(config('settings.ads')->category_bottom_mobile))
                                {!! config('settings.ads')->category_bottom_mobile !!}
                            @endif
                            </div>
                            @endif
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="big-item">
                                                <a href="{{ uri('post', $latest->slug) }}"><img
                                                        src="{{ image_url($latest->images->featured_image, '700x394') }}"
                                                        alt="{{ $latest->title }}"></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <h4><a href="{{ uri('post', $latest->slug) }}">{{ $latest->title }}</a>
                                            </h4>
                                            <p>{{ Str::limit($latest->description, 300, $end = '...') }}
                                            </p>
                                            <small><i class="fa-regular fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($latest->publish_date)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    {{ $posts->links() }}
                </div>
                <div class="col-lg-3 col-md-3">
                    @include('themes.' . $theme->path . '.includes.sidebar')
                </div>
            </div>
        </div>
    </div>
</div>
