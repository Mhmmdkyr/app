<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ __('Users') }}</h4>
    </div>
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
    @if ($users)
        <form action="{{ route('admin.users.update', [$users->id]) }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @else
            <form action="{{ route('admin.users.save') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @endif
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group"><label for="inp-name" class="w-100 float-left">{{ __('Full Name') }} <span
                                data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}"
                                class="text-danger float-right"><i
                                    class="fas fa-exclamation-triangle"></i></span></label><input type="text"
                            name="name" id="inp-name" class="form-control" required
                            value="{{ $users ? $users->name : '' }}"></div>
                    <div class="form-group"><label for="inp-e_mail" class="w-100 float-left">{{ __('Email') }} <span
                                data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}"
                                class="text-danger float-right"><i
                                    class="fas fa-exclamation-triangle"></i></span></label><input type="text"
                            name="email" id="inp-e_mail" class="form-control"
                            value="{{ $users ? $users->email : '' }}" required></div>
                    <div class="form-group"><label for="inp-password" class="w-100 float-left">{{ __('Password') }}
                            <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}"
                                class="text-danger float-right"><i
                                    class="fas fa-exclamation-triangle"></i></span></label><input type="text"
                            name="password" id="inp-password" class="form-control" {{ $users ? '' : ' required ' }}
                            value="{{ $users ? $users->value : '' }}" >
                            @if($users)
                            <small class="text-muted">Yanlızca kullanıcının şifresini değiştirmek için kullanın. Şifre değiştirmek istemiyorsanız boş bırakın.</small>
                            @endif
                          </div>
                    <div class="form-group"><label for="inp-role" class="float-left w-100">{{ __('Role') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
                        <select name="role_id" id="role" class="form-control" required>
                            <option value="">{{ __('Kullanıcı Rolünü Seçin') }}</option>
                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->id }}"{{ $users && $users->role_id == $role->id ? ' selected' : '' }}>
                                    {{ $role->role }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="card">
                <h4 class="card-header">{{ __('User Informations') }}</h4>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="about_bio" class="col-sm-2 col-form-label">{{ __('Biography') }}</label>
                        <div class="col-sm-10">
                            <textarea name="about[bio]" id="about_bio" class="form-control">{{ $users && isset($users->about->bio) ? $users->about->bio : '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[facebook]" id="facebook"
                                value="{{ $users && isset($users->about->facebook) ? $users->about->facebook : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[twitter]" id="twitter"
                                value="{{ $users && isset($users->about->twitter) ? $users->about->twitter : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[instagram]" id="instagram"
                                value="{{ $users && isset($users->about->instagram) ? $users->about->instagram : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="youtube" class="col-sm-2 col-form-label">Youtube</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[youtube]" id="youtube"
                                value="{{ $users && isset($users->about->youtube) ? $users->about->youtube : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pinterest" class="col-sm-2 col-form-label">Pinterest</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[pinterest]" id="pinterest"
                                value="{{ $users && isset($users->about->pinterest) ? $users->about->pinterest : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="linkedin" class="col-sm-2 col-form-label">Linkedin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[linkedin]" id="linkedin"
                                value="{{ $users && isset($users->about->linkedin) ? $users->about->linkedin : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="vk" class="col-sm-2 col-form-label">VK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[vk]" id="vk"
                                value="{{ $users && isset($users->about->vk) ? $users->about->vk : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telegram" class="col-sm-2 col-form-label">Telegram</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="about[telegram]" id="telegram"
                                value="{{ $users && isset($users->about->telegram) ? $users->about->telegram : '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card">
                <h4 class="card-header font-weight-bold">{{ __('User Avatar') }}</h4>
                <div class="card-body p-0">
                    @include('admin.common.imager.single', [
                        'target' => 'avatar',
                        'info_text' => false,
                        'dir' => 'avatars',
                        'sizes' => ['250x250'],
                        'selected_image' => $users && $users->avatar ? $users->avatar : false,
                    ])
                </div>
            </div>
            <button class="btn btn-success btn-lg btn-block"><i class="fa fa-save"></i>
                {{ __('Save Changes') }}</button>
        </div>
    </div>
    </form>
</div>
