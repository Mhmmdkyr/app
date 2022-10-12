<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
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
                    <h1 class="mb-0 mt-0">{{ $page->title }}</h1>
                    <p>{{ $page->description }}</p>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            {!! $page->content !!}
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
