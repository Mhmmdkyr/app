<div class="page-inner">
    <div class="page-header mb-4">
        <h4 class="page-title">{{ __('Translates') }}</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <form action="{{ route('admin.settings.saveTranslates') }}" method="post">
                <input type="hidden" name="slug" value="{{ request('slug') }}">
                <div class="card position-relative">
                    <div class="card-body">
                        {{ csrf_field() }}
                        @foreach ($originals as $k => $translate)
                            @if ($translate && is_string($translate))
                                <div class="form-group">
                                    <label for="translate-{{ Str::slug($k) }}" class="form-label translate-label">{{ $k }}</label>
                                    <input type="hidden" value="{{ $k }}" name="keyword[]">
                                    <input type="text" class="form-control" id="translate-{{ Str::slug($k) }}" name="value[]"
                                        value="{{ isset($translates[$k]) ? $translates[$k] : $translate }}">
                                </div>
                            @elseif($translate && is_array($translate))
                                @foreach ($translate as $l => $sub)
                                    <div class="form-group">
                                        <label for="translate-{{ Str::slug($l) }}" class="form-label translate-label">{{ $l }}</label>
                                        <input type="hidden" value="{{ $l }}"
                                            name="keyword[{{ $k }}][]">
                                        <input type="text" class="form-control" id="translate-{{ Str::slug($l) }}" name="value[{{ $k }}][]"
                                            value="{{ isset($translates[$k][$l]) ? $translates[$k][$l] : $sub }}">
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-primary float-right">{{ __('Save Changes') }}</button>
            </form>
        </div>
    </div>
</div>