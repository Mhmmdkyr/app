<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Themes') }}</h4>
    </div>
    <div class="row mb-2 mt-4">
        <div class="col-lg-8 col-md-8">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">{{ __('Uploaded Themes') }}</h4>
                <div class="card-body">
                    <div class="row">
                        @foreach ($themes as $theme)
                            <div class="col-lg-3 col-md-3">
                                <div class="card mb-0">
                                    <img src="data:image/png;base64,{{ theme_sreenshot($theme->path) }}" class="card-img-top" alt="{{ $theme->theme_name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $theme->theme_name }}</h5>
                                        <p class="card-text">{{ $theme->description }}</p>
                                        <a href="{{ route('admin.themes.set_theme', ['id' => $theme->id]) }}" {{ $theme->active ? ' disabled ' : '' }} class="btn btn-primary btn-block{{ $theme->active ? ' disabled ' : '' }}">{{ __( $theme->active ? 'Current Theme' : 'Set Theme') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
