<div class="main-container">
    
    <div class="post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    <div class="breadcrumb-area">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb bg-transparent p-0">
                                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                                            <li class="breadcrumb-item"><a
                                                    href="{{ uri('category', $post->categories[0]->slug) }}">{{ $post->categories[0]->category_title }}</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                    </div>
                    <h1 class="mb-0 mt-0">{{ $post->title }}</h1>
                    <p class="text-muted"><small><i class="far fa-clock"></i>
                            {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</small></p>
                    <h5 class="fw-normal">{{ $post->description }}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-lg-1 col-md-1 pr-0">
                            <div class="share-tool text-center sticky-top">
                                <h4 class="text-uppercase">{{ __('Share') }}</h4>
                                <hr>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ share_link($post) }}"
                                    target="_blank" rel="nofollow" class="btn btn-social btn-facebook btn-block"><i
                                        class="fab fa-facebook"></i></a>
                                <a href="https://twitter.com/share?url={{ share_link($post) }}" target="_blank"
                                    rel="nofollow" class="btn btn-social btn-twitter btn-block"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ share_link($post) }}"
                                    target="_blank" rel="nofollow" class="btn btn-social btn-linkedin btn-block"><i
                                        class="fab fa-linkedin"></i></a>
                                <a href="https://api.whatsapp.com/send?text={{ share_link($post) }}"
                                    class="btn btn-social btn-whatsapp btn-block"><i class="fab fa-whatsapp"></i></a>
                                <a href="https://pinterest.com/pin/create/button/?url={{ share_link($post) }}"
                                    target="_blank" rel="nofollow" class="btn btn-social btn-pinterest btn-block"><i
                                        class="fab fa-pinterest"></i></a>
                                <hr>
                                <a href="javascript:window.print()" class="btn btn-social btn-secondary btn-block"><i
                                        class="fas fa-print"></i></a>
                                @if (auth()->user() && $post_favorites)
                                    <a href="{{ route('frontend.user.add_favorite', ['post_id' => $post->id]) }}"
                                        class="dynamic-button btn btn-social btn-success btn-block"><i
                                            class="fa fa-check"></i></a>
                                @else
                                    <a href="{{ route('frontend.user.add_favorite', ['post_id' => $post->id]) }}"
                                        data-href="{{ route('frontend.login', ['redirect_url' => url()->current()]) }}"
                                        class="dynamic-button btn btn-social btn-dark btn-block"><i
                                            class="far fa-star"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-11 col-md-11">
                            @if ($post->type != 'list' && $post->type != 'video')
                                <img src="{{ image_url($post->images->featured_image, '1000x563') }}"
                                    class="rounded border" alt="{{ $post->title }}">
                                <div class="d-none d-md-none d-lg-block mt-4 mb-4">
                                    @if (config('settings.ads') && isset(config('settings.ads')->post_middle_desktop))
                                        {!! config('settings.ads')->post_middle_desktop !!}
                                    @endif
                                </div>
                                <div class="clear"></div>
                                <div class="d-block d-sm-none">
                                    @if (config('settings.ads') && isset(config('settings.ads')->post_middle_mobile))
                                        {!! config('settings.ads')->post_middle_mobile !!}
                                    @endif
                                </div>
                                <div class="clear"></div>
                            @endif
                            @if ($post->type == 'list')
                                @if (Request::has('content') && Request::get('content') > 0)
                                @endif
                                <h3 class="mb-2">{{ Request::has('content') ? Request::get('content') + 1 : 1 }}.
                                    {{ $post->content->items[Request::has('content') ? Request::get('content') : 0]->title }}
                                </h3>
                                <img src="{{ image_url($post->content->items[Request::has('content') ? Request::get('content') : 0]->image, '1000x563') }}"
                                    class="rounded border mb-3" alt="">
                                <div class="d-none d-md-none d-lg-block mt-4 mb-4">
                                    @if (config('settings.ads') && isset(config('settings.ads')->post_middle_desktop))
                                        {!! config('settings.ads')->post_middle_desktop !!}
                                    @endif
                                </div>
                                <div class="d-block d-sm-none">
                                    @if (config('settings.ads') && isset(config('settings.ads')->post_middle_mobile))
                                        {!! config('settings.ads')->post_middle_mobile !!}
                                    @endif
                                </div>
                                {!! $post->content->items[Request::has('content') ? Request::get('content') : 0]->content !!}
                                <hr>
                                <div class="clear"></div>
                                <div class="content-controls mb-3 float-left w-100">
                                    @if (Request::has('content') && Request::get('content') > 0)
                                        <a href="{{ set_querystring('content', Request::has('content') ? Request::get('content') - 1 : 0) }}"
                                            class="btn btn-outline-primary"><i class="fa fa-chevron-left"></i>
                                            {{ __('Previous') }}</a>
                                    @endif
                                    @if (!Request::has('content') ||
                                        (Request::has('content') && Request::get('content') < count($post->content->items) - 1))
                                        <a href="{{ set_querystring('content', Request::has('content') ? Request::get('content') + 1 : 1) }}"
                                            class="btn btn-outline-primary float-right">{{ __('Next') }} <i
                                                class="fa fa-chevron-right"></i></a>
                                    @endif
                                </div>
                            @elseif($post->type == 'article')
                                <div class="content-wrapper mt-4">
                                    {!! $post->content !!}
                                </div>
                            @elseif($post->type == 'gallery')
                            <div class="content-wrapper">
                                {!! $post->content->content !!}
                            </div>
                                <div class="gallery-container mb-4">
                                    @foreach (explode(',', $post->content->image[0]) as $i => $image)
                                        <figure>
                                            <a href="{{ image_url($image) }}" data-fancybox="gallery">
                                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                    data-src="{{ image_url($image) }}" class="lazy"
                                                    alt="{{ $post->title }} Gallery {{ $i }}st."
                                                    class="rounded border" />
                                            </a>
                                        </figure>
                                    @endforeach
                                </div>
                            @elseif($post->type == 'video')
                                <div class="embed-responsive embed-responsive-16by9 mb-4">
                                    <iframe class="embed-responsive-item" src="{{ $post->content->url }}"
                                        allowfullscreen></iframe>
                                </div>
                                <div class="d-none d-md-none d-lg-block mt-4 mb-4">
                                    @if (config('settings.ads') && isset(config('settings.ads')->post_middle_desktop))
                                        {!! config('settings.ads')->post_middle_desktop !!}
                                    @endif
                                </div>
                                <div class="d-block d-sm-none">
                                    @if (config('settings.ads') && isset(config('settings.ads')->post_middle_mobile))
                                        {!! config('settings.ads')->post_middle_mobile !!}
                                    @endif
                                </div>
                                <div class="content-wrapper">
                                    {!! $post->content->content !!}
                                </div>

                            @endif
                            <div class="clear"></div>
                            @if ($post->meta && isset($post->meta->meta_keywords))
                                <small><i class="fa fa-tag"></i> {{ __('Tags') }} :
                                    @foreach (explode(',', $post->meta->meta_keywords) as $keyword)
                                        <a class="btn btn-sm btn-outline-secondary"
                                            href="{{ route('frontend.posts.search', ['q' => $keyword]) }}">{{ $keyword }}</a>
                                    @endforeach
                                </small>
                                <hr>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        @if ($post->user->avatar)
                                            <div class="col-lg-2 col-md-2 d-none d-lg-block">
                                                <a href=""><img src="{{ image_url($post->user->avatar) }}"
                                                        class="circle border" alt=""></a>
                                            </div>
                                        @endif
                                        <div class="col-lg-10 col-md-10">
                                            <h5>{{ $post->user->name }}</h5>
                                            <p><small>{{ $post->user->about && isset($post->user->about->bio) ? $post->user->about->bio : '' }}</small>
                                            </p>
                                            @if ($post->user->about && isset($post->user->about->facebook))
                                                <a href="{{ $post->user->about->facebook }}" rel="nofollow"
                                                    target="_blank" title="Facebook Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-facebook"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->twitter))
                                                <a href="{{ $post->user->about->twitter }}" rel="nofollow"
                                                    target="_blank" title="Twitter Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-twitter"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->instagram))
                                                <a href="{{ $post->user->about->instagram }}" rel="nofollow"
                                                    target="_blank" title="Instagram Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-instagram"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->youtube))
                                                <a href="{{ $post->user->about->youtube }}" rel="nofollow"
                                                    target="_blank" title="Youtube Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-youtube"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->pinterest))
                                                <a href="{{ $post->user->about->pinterest }}" rel="nofollow"
                                                    target="_blank" title="Pinterest Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-pinterest"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->linkedin))
                                                <a href="{{ $post->user->about->linkedin }}" rel="nofollow"
                                                    target="_blank" title="Linkedin Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-linkedin"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->vk))
                                                <a href="{{ $post->user->about->vk }}" rel="nofollow"
                                                    target="_blank" title="Facebook Link"
                                                    class="btn btn-sm btn-outline-dark"><i class="fab fa-vk"></i></a>
                                            @endif
                                            @if ($post->user->about && isset($post->user->about->telegram))
                                                <a href="{{ $post->user->about->telegram }}" rel="nofollow"
                                                    target="_blank" title="Telegram Link"
                                                    class="btn btn-sm btn-outline-dark"><i
                                                        class="fab fa-telegram"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="next-prev mt-4 mb-4">
                                @if ($prev)
                                    <a href="{{ url('post', $prev->slug) }}" class="np-prev">
                                        <i class="fas fa-chevron-left"></i>
                                        <span>{{ $prev->title }}</span>
                                    </a>
                                @endif
                                @if ($next)
                                    <a href="{{ url('post', $next->slug) }}" class="np-next">
                                        <span>{{ $next->title }}</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="clear"></div>
                            @include('themes.' . $theme->path . '.includes.reactions', ['post' => $post])
                            <hr>
                            <div class="d-none d-md-none d-lg-block mt-4 mb-4">
                                @if (config('settings.ads') && isset(config('settings.ads')->post_bottom_desktop))
                                    {!! config('settings.ads')->post_bottom_desktop !!}
                                @endif
                            </div>
                            <div class="d-block d-sm-none">
                                @if (config('settings.ads') && isset(config('settings.ads')->post_bottom_mobile))
                                    {!! config('settings.ads')->post_bottom_mobile !!}
                                @endif
                            </div>
                            @if ($releated_posts)
                                <div class="row pt-3 pb-3">
                                    <div class="col-lg-12 col-md-12">
                                        <h3>Releated Posts</h3>
                                    </div>
                                    @foreach ($releated_posts as $i => $post)
                                        <div class="col-lg-4 col-md-4">
                                            <div class="card-banner-item position-relative">
                                                <div class="card-banner-item-content">
                                                    <a href="{{ uri('post', $post->slug) }}"><img
                                                            src="{{ image_url('placeholders/lg.jpg', '700x394') }}"
                                                            data-src="{{ image_url($post->images->featured_image, '700x394') }}"
                                                            alt="{{ $post->title }}" class="lazy"></a>
                                                    <div class="card-banner-item-desc">
                                                        <p><a href="{{ uri('post', $post->slug) }}"
                                                                class="text-white">{{ $post->title }}</a></p>
                                                        <small class="d-block"><i class="fa-regular fa-clock"></i>
                                                            {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="card mt-4 mb-4">
                                <h5 class="card-header">{{ __('Comments') }}</h5>
                                <div class="card-body">
                                    <form action="{{ route('frontend.posts.add_comment', ['post' => $post->id]) }}"
                                        method="post" id="add-comment">
                                        <div class="error-handler"></div>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @if (!auth()->user())
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('Your Name') }}</label>
                                                        <input type="text" class="form-control" name="name"
                                                            required>
                                                        @if ($errors->has('name'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('Your Email Address') }}</label>
                                                        <input type="email" class="form-control" name="email"
                                                            required>
                                                        @if ($errors->has('email'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                {{ __('The logged in user is :username', ['username' => auth()->user()->name]) }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="comment">{{ __('Comment') }}</label>
                                            <textarea name="comment" id="comment" class="form-control"></textarea>
                                            @if ($errors->has('comment'))
                                                <span class="text-danger">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>
                                        <div class="row">
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
                                                <button type="submit" class="btn btn-success"><i
                                                        class="fa fa-check"></i> {{ __('Send Comment') }}</button>
                                            </div>
                                    </form>
                                </div>
                                <hr>
                                @foreach ($post->comments as $comment)
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>{{ $comment->user ? $comment->user->name : $comment->fullname }}</h6>
                                            <p>{{ $comment->comment }}</p>
                                            <small class="text-muted"><i class="fa fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                @include('themes.' . $theme->path . '.includes.sidebar')
            </div>
        </div>

    </div>
</div>
</div>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "item": {
                    "@id": "{{ uri('category', $post->categories[0]->slug) }}",
                    "name": "{{ $post->categories[0]->category_title }}"
                }
            },
            {
                "@type": "ListItem",
                "position": 2,
                "item": {
                    "@id": "{{ uri('post', $post->slug) }}",
                    "name": "{{ $post->title }}"
                }
            }
        ]
    }
</script>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "https://google.com/article"
        },
        "headline": "{{ $post->title }}",
        "description": "{{ $post->description }}",
        @if ($post->images->featured_image)
            "image": "{{ image_url($post->images->featured_image, '700x394') }}",
        @endif
        "datePublished": "{{ \Carbon\Carbon::parse($post->publish_date)->format('Y-m-dTH:i:sP') }}",
        "dateModified": "{{ \Carbon\Carbon::parse($post->updated_at)->format('Y-m-dTH:i:sP') }}",
        "author": {
            "@type": "Person",
            "name": "{{ $post->user->name }}",
            "image": "{{ image_url($post->user->avatar, '250x250') }}",
            "url": "{{ uri('') }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "{{ config('settings.short_title') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ image_url($settings['favicon'], '128x128') }}"
            }
        }
    }
</script>
