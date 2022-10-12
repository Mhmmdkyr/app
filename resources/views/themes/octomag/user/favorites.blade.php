<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Your Favorites') }}</li>
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
                    <h1 class="mb-0 mt-0">{{ __('Your Favorites') }}</h1>
                    <hr>
                    @if (Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
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
                    @if (count($posts) == 0)
                        <div class="alert alert-danger">{{ __('Your favorite list is empty.') }}</div>
                    @endif
                    @foreach ($posts as $k => $latest)
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="big-item">
                                    <a href="{{ uri('post', $latest->post->slug) }}"><img
                                            src="{{ image_url($latest->post->images->featured_image, '700x394') }}"
                                            alt="{{ $latest->post->title }}"></a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <h4><a href="{{ uri('post', $latest->post->slug) }}">{{ $latest->post->title }}</a>
                                </h4>
                                <p>{{ Str::limit($latest->post->description, 300, $end = '...') }}
                                </p>
                                <small><i class="fa-regular fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($latest->post->publish_date)->diffForHumans() }}</small>
                                <div class="clear"></div>
                                <a href="{{ route('frontend.user.remove_fav', ['post_id' => $latest->post->id]) }}"
                                    onClick="return confirm('{{ __('Are you sure?') }}')"
                                    class="btn btn-sm btn-outline-danger mt-4"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-3 col-md-3">
                    @include('themes.'.$theme->path.'.user.sidebar')
                </div>
            </div>
        </div>
    </div>
