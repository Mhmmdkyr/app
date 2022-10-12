<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ $form_title }}</h4>
    </div>
    @if ($page)
    <form action="{{ route('admin.pages.edit_save', [$page->id]) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @else
    <form action="{{ route('admin.pages.save') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @endif
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group form-group-default">
                        <label for="title">{{ __('Page Title') }}</label>
                        <input type="text" class="form-control form-control-lg pl-0" style="padding-left: 0 !important" id="title" name="title" placeholder="{{ __('Write a title for your content...') }}" value="{{ old('title', $page ? $page->title : '') }}">
                    </div>
                    <textarea id="editor" name="content" class="editor" rows="3">{{ old('content', $page ? $page->content : '') }}</textarea>
                </div>
            </div>
            @include('admin.includes/seo_form', ['section' => 'pages', 'collapse' => true, 'item' => isset($page->meta) ? $page->meta : false, 'slug' => isset($page) && isset($page->slug) ? $page->slug : ''])
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card">
                <h4 class="card-header font-weight-bold">{{ __('Prefences') }}</h4>
                <div class="card-body p-0">
                    <div class="form-group p-2">
                        <label for="language_id">{{ __('Language') }}</label>
                        <select class="form-control" id="language_id" name="language_id">
                           @foreach($languages as $language)
                            <option value="{{ $language->id }}">{{ $language->title }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group p-2">
                        <label for="visibility">{{ __('Visibility') }}</label>
                        <select class="form-control" id="visibility" name="visibility">
                            <option value="all" {{ $page && $page->visibility && $page->visibility == 'all' ? ' selected' : '' }}>
                                {{ __('Everyone') }}
                            </option>
                            <option value="only_members" {{ $page && $page->visibility && $page->visibility == 'only_members' ? ' selected' : '' }}>
                                {{ __('Only Members') }}
                            </option>
                        </select>
                    </div>
                    <div class="clear"></div>
                    <input type="hidden" name="shown[menu]" value="0">
                    <input type="hidden" name="shown[footer]" value="0">
                    <div class="custom-control custom-checkbox my-1 mr-sm-2 ml-2">
                        <input type="checkbox" class="custom-control-input"
                            id="category-top-menu" name="shown[menu]" value="1"{{ $page && $page->shown && $page->shown->menu == '1' ? ' checked' : '' }}>
                        <label class="custom-control-label" for="category-top-menu">{{ __('Show on Menu') }}</label>
                    </div>
                    <div class="clear"></div>
                    <div class="custom-control custom-checkbox my-1 mr-sm-2 ml-2">
                        <input type="checkbox" class="custom-control-input"
                            id="category-footer" name="shown[footer]" value="1"{{ $page && $page->shown && $page->shown->footer == '1' ? ' checked' : '' }}>
                        <label class="custom-control-label" for="category-footer">{{ __('Show on Footer') }}</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-block btn-success"><i class="fa fa-save"></i> {{ __('Save Changes') }}</button>
        </div>
    </div>
</form>
</div>