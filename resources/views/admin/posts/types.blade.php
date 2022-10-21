<div class="page-inner">
    <div class="page-header mb-0 d-block">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <h4 class="page-title">{{ __('Select Post Type') }}</h4>
            </div>

        </div>

    </div>
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-2">
                    <a class="card mb-0 posttype-item-1 posttype-item" href="{{ route('admin.posts.create', ['lang' => config('app.active_lang.id'), 'type' => 'article']) }}" data-id="article">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fa fa-newspaper"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark"><b>{{ __('Classic Post') }}</b></h5>
                            <p class="card-text text-muted">{{ __('For classic news, blog or text posts.') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-6 mb-2">
                    <a class="card mb-0 posttype-item-2 posttype-item" href="{{ route('admin.posts.create', ['lang' => config('app.active_lang.id'), 'type' => 'gallery']) }}">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fa fa-images"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark"><b>{{ __('Gallery Post') }}</b></h5>
                            <p class="card-text text-muted">{{ __('For create impressive galleries with pictures.') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-6 mb-2">
                    <a class="card mb-0 posttype-item-3 posttype-item" href="{{ route('admin.posts.create', ['lang' => config('app.active_lang.id'), 'type' => 'video']) }}">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark"><b>{{ __('Video Post') }}</b></h5>
                            <p class="card-text text-muted">{{ __('For publishing your youtube and vimeo videos.') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-6 mb-2">
                    <a class="card mb-0 posttype-item-4 posttype-item" href="{{ route('admin.posts.create', ['lang' => config('app.active_lang.id'), 'type' => 'list']) }}">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark"><b>{{ __('Sorted List') }}</b></h5>
                            <p class="card-text text-muted">{{ __('For create ordered lists within the post.') }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
