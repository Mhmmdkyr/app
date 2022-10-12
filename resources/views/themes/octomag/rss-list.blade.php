<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('RSS Lists') }}</li>
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
                    <h1 class="mb-0 mt-0"><i class="fa fa-rss"></i> {{ __('RSS Lists') }}</h1>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            @foreach ($categories as $category)
                            <div class="card mb-3">
                                <h5 class="card-header">{{ $category->category_title }}</h5>
                                <div class="card-body">RSS Feed : <a target="_blank" href="{{ uri('rss', $category->slug) }}">{{ uri('rss', $category->slug) }}</a></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-lg-3 col-md-3">
                    @include('themes.' . $theme->path . '.includes.sidebar')
                </div>
            </div>
        </div>
    </div>
</div>
