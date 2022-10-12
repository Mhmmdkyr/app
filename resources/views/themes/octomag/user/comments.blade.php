<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Your Comments') }}</li>
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
                    <h1 class="mb-0 mt-0">{{ __('Your Comments') }}</h1>
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
                    @foreach ($comments as $comment)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5><a href="{{ uri('posts', $comment->post->slug) }}"><i class="fa fa-link"></i>
                                        {{ $comment->post->title }}</a> <a
                                        href="{{ route('frontend.user.remove_comment', ['comment_id' => $comment->id]) }}"
                                        onClick="return confirm('{{ __('Are you sure?') }}')"
                                        class="btn btn-sm btn-outline-danger float-right"><i
                                            class="fa fa-trash"></i></a></h5>
                                <hr>
                                <h6><i class="fa fa-user"></i> {{ $comment->user->name }} / <span
                                        class="badge badge-{{ $comment->status ? 'success' : 'warning' }}">{{ $comment->status ? __('Approved') : __('Pending') }}</span>
                                    <small>{{ \Carbon\Carbon::parse($comment->post->publish_date)->diffForHumans() }}</small>
                                </h6>
                                <p>{{ $comment->comment }}</p>
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
