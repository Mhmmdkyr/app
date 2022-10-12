<div class="page-inner">
    <div class="row">
        <div class="col-lg-10 col-md-10">
            <div class="page-header">
                <h4 class="page-title">{{ __('Categories') }}</h4>
                <div class="clear"></div>
                <hr>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <select name="" id="" class="form-control form-control-sm dynamic_select">
                <option value="{{ set_querystring('lang', 0) }}"{{ isset($lang) && $lang == 0 ? ' selected' : '' }}>
                    {{ __('All Languages') }}</option>
                @foreach ($languages as $language)
                    <option
                        value="{{ set_querystring('lang', $language->id) }}"{{ isset($lang) && $lang == $language->id ? ' selected' : '' }}>
                        {{ $language->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert alert-success">{{ Session::get('status') }}</p>
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
            <div class="card">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="p-4 h-100" style="background:#f5f5f5; border-right: 1px solid #dedede">
                                <h4>
                                    @if (isset($category))
                                        <b class="text-warning"><i class="fa fa-edit"></i>
                                            {{ __('Edit Category') }}</b>
                                        <a href="{{ route('admin.categories.index') }}"
                                            class="float-right text-dark"><i class="fa fa-chevron-left"></i>
                                            {{ __('Go Back') }}</a>
                                    @else
                                        <b class="text-success"><i class="fa fa-plus"></i>
                                            {{ __('New Category') }}</b>
                                    @endif
                                </h4>
                                <hr>
                                @if (isset($category))
                                    <form action="{{ route('admin.categories.update', $category->uniq_id) }}"
                                        method="post">
                                    @else
                                        <form action="{{ route('admin.categories.store') }}" method="post">
                                @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group pt-4">
                                    <label for="category_title" class="w-100 float-left">{{ __('Category Title') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend square">
                                            <input type="text" class="form-control" data-coloris
                                                style="width: 40px; padding-left: 5px; color:transparent" name="color"
                                                id="color"
                                                value="#{{ isset($category) && $category->color ? $category->color : ltrim(config('settings.color'), '#') }}">
                                        </div>
                                        <input type="text" class="form-control" id="category_title"
                                            name="category_title"
                                            value="{{ isset($category) ? $category->category_title : '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group{{ $lang ? ' d-none' : '' }}">
                                    <label for="language_id" class="w-100 float-left">{{ __('Language') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
                                    <select name="language_id" id="language_id" class="form-control" required>
                                        <option value="">Select Language</option>
                                        @foreach ($languages as $language)
                                            <option
                                                value="{{ $language->id }}"{{ isset($category) && $category->language_id == $language->id ? ' selected' : (!isset($category) && Request::has('lang') && Request::get('lang') == $language->id ? ' selected' : '') }}>
                                                {{ $language->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="spotlight">{{ __('Category Description') }}</label>
                                    <textarea class="form-control" id="spotlight" rows="3" name="category_description">{{ isset($category) ? $category->category_description : '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="parent">{{ __('Parent') }}</label>
                                    <select class="custom-select category-select" id="parent" name="parent">
                                        <option value="">
                                            {{ __('Select Parent Category') }}</option>
                                        @foreach ($categories as $parent)
                                            <option value="{{ $parent->uniq_id }}"
                                                data-lang="{{ $parent->language_id }}"
                                                {{ isset($category) && $category->parent == $parent->uniq_id ? 'selected' : '' }}>
                                                {{ $parent->category_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="shown[home_enable]" value="0">
                                <input type="hidden" name="shown[home_type]" value="0">
                                <input type="hidden" name="shown[menu]" value="0">
                                <input type="hidden" name="shown[footer]" value="0">
                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="category-home"
                                        name="shown[home_enable]"
                                        value="1"{{ isset($category) && isset($category->shown) && isset($category->shown->home_enable) && $category->shown->home_enable == '1' ? ' checked' : '' }}>
                                    <label class="custom-control-label"
                                        for="category-home">{{ __('Show on Homepage') }}</label>
                                </div>
                                <div
                                    class="collapse home-types{{ isset($category) && isset($category->shown) && isset($category->shown->home_enable) && $category->shown->home_enable == '1' ? ' show' : '' }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-ld-4">
                                            <div
                                                class="category-home-type{{ isset($category) && isset($category->shown) && isset($category->shown->home_type) && $category->shown->home_type == '1' ? ' active' : '' }}">
                                                <img src="{{ url('/') }}/backend/img/type-1.png"
                                                    class="border rounded" alt="">
                                                <input type="radio" name="shown[home_type]" value="1" checked
                                                    id="type-1"
                                                    {{ isset($category) && isset($category->shown) && isset($category->shown->home_type) && $category->shown->home_type == '1' ? ' checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-ld-4">
                                            <div
                                                class="category-home-type{{ isset($category) && isset($category->shown) && isset($category->shown->home_type) && $category->shown->home_type == '2' ? ' active' : '' }}">
                                                <img src="{{ url('/') }}/backend/img/type-2.png"
                                                    class="border rounded" alt="">
                                                <input type="radio" name="shown[home_type]" value="2"
                                                    id="type-2"
                                                    {{ isset($category) && isset($category->shown) && isset($category->shown->home_type) && $category->shown->home_type == '2' ? ' checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-ld-4">
                                            <div
                                                class="category-home-type{{ isset($category) && isset($category->shown) && isset($category->shown->home_type) && $category->shown->home_type == '3' ? ' active' : '' }}">
                                                <img src="{{ url('/') }}/backend/img/type-3.png"
                                                    class="border rounded" alt="">
                                                <input type="radio" name="shown[home_type]" value="3"
                                                    id="type-3"{{ isset($category) && isset($category->shown) && isset($category->shown->home_type) && $category->shown->home_type == '3' ? ' checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="category-top-menu"
                                        name="shown[menu]"
                                        value="1"{{ isset($category) && isset($category->shown) && isset($category->shown->menu) && $category->shown->menu == '1' ? ' checked' : '' }}>
                                    <label class="custom-control-label"
                                        for="category-top-menu">{{ __('Show on Menu') }}</label>
                                </div>
                                <div class="clear"></div>
                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="category-footer"
                                        name="shown[footer]"
                                        value="1"{{ isset($category) && isset($category->shown) && isset($category->shown->footer) && $category->shown->footer == '1' ? ' checked' : '' }}>
                                    <label class="custom-control-label"
                                        for="category-footer">{{ __('Show on Footer') }}</label>
                                </div>
                                @include('admin.includes/seo_form', [
                                    'section' => 'categories',
                                    'slug_target' => 'category_title',
                                    'language' => false,
                                    'item' => isset($category) ? $category->meta : false,
                                    'slug' => isset($category) ? $category->slug : '',
                                ])

                                <button
                                    class="btn btn-{{ isset($category) ? 'warning' : 'success' }} float-right mb-4 pl-4 pr-4"><i
                                        class="fa fa-save"></i> {{ __('Save Changes') }}</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <table class="table table-hover mb-0 tiny-td">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Category Title') }}</th>
                                        <th scope="col" width="70">{{ __('Lang') }}</th>
                                        <th scope="col" width="160" class="text-center">
                                            {{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($categories) && count($categories) == 0)
                                        <tr>
                                            <td colspan="6" style="background:#fff !important"
                                                class="text-center">
                                                <div class="not-result mb-4">
                                                    <img src="{{ url('/') }}/assets/admin/not-result.jpg"
                                                        alt="">
                                                    <h2>{{ __('Sorry, no result found!') }}</h2>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($categories as $item)
                                            <tr>

                                                <td><span
                                                        style="background: #{{ $item->color }}; width: 10px; height: 10px; margin-right: 14px; border-radius: 50%; display: inline-block"></span>{!! getRow($item->category_title, 'input:text') !!}
                                                </td>
                                                <td>
                                                    @foreach ($languages as $language)
                                                        @if ($language->id == $item->language_id)
                                                            <span
                                                                class="badge text-uppercase">{{ $language->slug }}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button {{ count($item->subs) == 0 ? 'disabled' : '' }}
                                                        data-toggle="collapse"
                                                        data-target=".subs-{{ $item->id }}"
                                                        class="btn btn-xs btn-info btn-border"><i
                                                            class="fa fa-chevron-down"></i>
                                                        {{ __('Subs') }}</button>
                                                    <a href="{{ route('admin.categories.edit', $item->id) }}"
                                                        class="btn btn-xs btn-warning btn-border"><i
                                                            class="fa fa-edit"></i>
                                                        {{ __('Edit') }}</a>
                                                    <a data-id="{{ $item->id }}" data-section="categories"
                                                        href="javascript:;"
                                                        class="btn btn-xs btn-danger btn-border delete-single"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @foreach ($item->subs as $sub)
                                                <tr style="background:#f5f5f5;"
                                                    class="collapse fade subs-{{ $item->id }}">
                                                    <td>{!! getRow($sub->category_title, 'input:text') !!}</td>
                                                    <td>
                                                        <a href="{{ route('admin.categories.edit', $sub->id) }}"
                                                            class="btn btn-xs btn-warning btn-border"><i
                                                                class="fa fa-edit"></i>
                                                            {{ __('Edit') }}</a>
                                                        <a data-id="{{ $sub->id }}" data-section="categories"
                                                            href="javascript:;"
                                                            class="btn btn-xs btn-danger btn-border delete-single"><i
                                                                class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ url('/') }}/backend/vendor/coloris/coloris.min.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/backend/vendor/coloris/coloris.min.css">
<script>
    $('.category-home-type').click(function() {
        $('.category-home-type').removeClass('active');
        $(this).addClass('active');
    })
    $('#category-home').change(function() {
        if ($(this).is(':checked')) {
            $('.home-types').collapse('show');
        } else {
            $('.home-types').collapse('hide');
        }
    })

    $('#language_id').change(function() {
        var elm = $(this);
        if (elm.val()) {
            $('.category-select').find('option').removeClass('d-none')
            $('.category-select').find('option').each(function(i, item) {
                if ($(item).attr('data-lang') != elm.val()) {
                    $(this).addClass('d-none')
                }
            })
        } else {
            $('.category-select').find('option').each(function(i, item) {
                $(this).addClass('d-none')
            })
        }
    })
</script>
