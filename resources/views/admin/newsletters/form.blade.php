<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ __('Roles') }}</h4>
    </div>
    @if ($role)
        <form action="{{ route('admin.roles.update', [$role->id]) }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @else
            <form action="{{ route('admin.roles.save') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @endif
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group"><label for="inp-name" class="">{{ __('Role') }}</label><input
                            type="text" name="role" id="inp-name" class="form-control" required
                            value="{{ $role ? $role->role : '' }}"></div>


                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card">
                <h4 class="card-header">{{ __('Panel Access') }}</h4>
                <div class="card-body">
                    <div class="custom-control custom-checkbox"><input
                            class="custom-control-input" type="checkbox" id="panel_login-1"
                            value="1" name="panel_login"{{ $role && $role->panel_login ? ' checked' : '' }}><label for="panel_login-1"
                            class="custom-control-label">{{ __('Can this role access the panel?') }}</label></div>
                </div>
            </div>
            <button class="btn btn-success btn-lg btn-block"><i class="fa fa-save"></i>
                {{ __('Save Changes') }}</button>
        </div>
    </div>
    </form>
</div>
