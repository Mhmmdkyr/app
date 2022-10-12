<div class="main-container">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Your Profile') }}</li>
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
                    <h1 class="mb-0 mt-0">{{ __('Your Profile') }}</h1>
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
                    <form action="{{ route('frontend.user.profile_store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="card">
                            <h4 class="card-header">{{ __('Informations') }}</h4>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">{{ __('Your Name') }}</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ __('Email Address') }}</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ __('Role') }}</label>
                                            <div class="form-control">{{ $user->role->role }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="bio">{{ __('Biography') }}</label>
                                            <textarea class="form-control" id="bio" name="about[bio]">{{ isset($user->about->bio) ? $user->about->bio : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <h4 class="card-header">{{ __('Social Links') }}</h4>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[facebook]" id="facebook"
                                            value="{{ $user && isset($user->about->facebook) ? $user->about->facebook : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[twitter]" id="twitter"
                                            value="{{ $user && isset($user->about->twitter) ? $user->about->twitter : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[instagram]"
                                            id="instagram"
                                            value="{{ $user && isset($user->about->instagram) ? $user->about->instagram : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="youtube">Youtube</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[youtube]" id="youtube"
                                            value="{{ $user && isset($user->about->youtube) ? $user->about->youtube : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pinterest">Pinterest</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[pinterest]"
                                            id="pinterest"
                                            value="{{ $user && isset($user->about->pinterest) ? $user->about->pinterest : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="linkedin">Linkedin</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[linkedin]" id="linkedin"
                                            value="{{ $user && isset($user->about->linkedin) ? $user->about->linkedin : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vk">VK</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[vk]" id="vk"
                                            value="{{ $user && isset($user->about->vk) ? $user->about->vk : '' }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telegram">Telegram</label>
                                    <div>
                                        <input type="text" class="form-control" name="about[telegram]"
                                            id="telegram"
                                            value="{{ $user && isset($user->about->telegram) ? $user->about->telegram : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                        <hr>
                        <div class="accordion mt-3" id="accordionExample">
                            <div class="card">
                                <div class="card-header p-0" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-outline-danger btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            {{ __('Reset Your Password') }}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="current_password">{{ __('Current Password') }}</label>
                                                    <input type="text" class="form-control" name="current_password" id="current_password">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="new_password">{{ __('New Password') }}</label>
                                                    <input type="text" class="form-control" name="new_password" id="new_password">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="confirm_password">{{ __('Confirm New Password') }}</label>
                                                    <input type="text" class="form-control" name="confirm_password" id="confirm_password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success float-right ml-auto mt-3" type="submit"><i class="fas fa-save"></i> {{ __('Save Changes') }}</button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-3">
                    @include('themes.'.$theme->path.'.user.sidebar')
                </div>
            </div>
        </div>
    </div>
