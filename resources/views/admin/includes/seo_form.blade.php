<div id="accordion" class="mt-3">
    <div class="card">
        <div class="card-header p-1" id="headingOne">
            <h5 class="mb-0">
                <button type="button" class="btn btn-link text-dark w-100 text-left" data-toggle="collapse" data-target="#collapse{{ isset($language) && $language ? $language : '1' }}"
                    aria-expanded="{{ isset($collapse) && $collapse ? 'true' : 'false' }}" aria-controls="collapse{{ isset($language) && $language ? $language : '1' }}">
                    <i class="fa fa-search"></i> <b>{{ __('Search Optimization') }}</b>
                    <i class="fa fa-caret-down float-right pt-1"></i>
                </button>

            </h5>
        </div>

        <div id="collapse{{ isset($language) && $language ? $language : '1' }}" class="collapse{{ isset($collapse) && $collapse ? ' show' : '' }}" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <input type="hidden" name="section" value="{{ $section }}">
                <div class="form-group">
                    <label for="meta_title">{{ __('Meta Title') }}</label>
                    <input type="text" class="form-control" name="{{ isset($language) && $language ? 'lang['.$language.'][meta_title]' : 'meta_title' }}" id="meta_title" data-duplicate="true"
                        data-target="#{{ isset($slug_target) ? $slug_target : 'title' }}" value="{{ $item && $item->meta_title ? $item->meta_title : '' }}">
                </div>
                <div class="form-group">
                    <label for="exampleInput">{{ __('Meta Description') }}</label>
                    <textarea class="form-control" name="{{ isset($language) && $language ? 'lang['.$language.'][meta_description]' : 'meta_description' }}" id="exampleInput" rows="3" data-duplicate="true"
                        data-target="#spotlight">{{ $item && $item->meta_description ? $item->meta_description : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInput">{{ __('Meta Keywords') }}s</label><br />
                    <input type="text" class="form-control tagsinput" name="{{ isset($language) && $language ? 'lang['.$language.'][meta_keywords]' : 'meta_keywords' }}" data-role="tagsinput"
                        value="{{ $item && $item->meta_keywords ? $item->meta_keywords : '' }}">
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12" style="height: 47px">
                        <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox"
                        {{ $item && $slug ? '' : 'checked' }} data-collapsed=".manual-permalink" data-checked="false" id="auto-permalink"
                                value="1"><label for="auto-permalink" class="custom-control-label">{{ __('Auto Permalink') }}</label></div>
                    </div>
                    <div class="col-lg-12 col-md-12 manual-permalink {{ $item && $slug ? '' : 'd-none' }}">
                        <div class="input-group mb-3 input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    id="basic-addon3"><small>{{ url('/') }}/{{ $section }}/</small></span>
                            </div>
                            <input type="text" name="{{ isset($language) && $language ? 'lang['.$language.'][slug]' : 'slug' }}" class="form-control" id="basic-url"  aria-describedby="basic-addon3" value="{{ $item && $slug ? $slug : '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
