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
                    <div class="card mb-0 posttype-item-1 posttype-item active" data-id="article">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fa fa-newspaper"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Classic Post') }}</h5>
                            <p class="card-text">{{ __('For classic news, blog or text posts.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-6 mb-2"">
                    <div class="card mb-0 posttype-item-2 posttype-item" data-id="gallery">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fa fa-images"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Gallery Post') }}</h5>
                            <p class="card-text">{{ __('For create impressive galleries with pictures.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-6 mb-2"">
                    <div class="card mb-0 posttype-item-3 posttype-item" data-id="video">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Video Post') }}</h5>
                            <p class="card-text">{{ __('For publishing your youtube and vimeo videos.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-6 mb-2"">
                    <div class="card mb-0 posttype-item-4 posttype-item" data-id="list">
                        <div class="icon-posttype d-none d-lg-block">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Sorted List') }}</h5>
                            <p class="card-text">{{ __('For create ordered lists within the post.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-3 col-md-3 mt-4">
            <div class="form-group">
                <label for="">{{ __('Language') }}</label>
                <select name="" id="" class="form-control language-select">
                    @foreach ($languages as $lang)
                        <option value="{{ $lang->id }}"{{ Request::has('lang') && Request::get('lang') == $lang->id ? ' selected' : '' }}>{{ $lang->title }}</option>
                    @endforeach
                </select>
            </div>
            <a href="javascript:;" data-href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-block mt-3 add-post-button">{{ __('Continue') }}</a>

        </div>
    </div>
</div>
