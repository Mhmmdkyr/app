<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ $form_title }}</h4>
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
    @if ($post)
    <form action="{{ route('admin.posts.update', [$post->id]) }}" method="post">
    @else
    <form action="{{ route('admin.posts.save') }}" method="post">
    @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group form-group-default">
                        <label for="title">{{ __('Post Title') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
                        <input type="text" class="form-control form-control-lg pl-0" style="padding-left: 0 !important" id="title" name="title" placeholder="{{ __('Write a title for your content...') }}" value="{{ old('title', $post ? $post->title : '') }}">
                    </div>

                    <div class="form-group p-0 mb-3">
                        <label for="spotlight">{{ __('Description') }}</label>
                        <textarea class="form-control" name="spotlight" id="spotlight" rows="3">{{ old('description', $post ? $post->description : '') }}</textarea>
                    </div>
                </div>
            </div>
            @include('admin.types/' .$type, ['post' => $post ? $post : false])
            @include('admin.includes/seo_form', ['section' => 'post', 'collapse' => true , 'item' => isset($post->meta) ? $post->meta : false, 'slug' => $post ? $post->slug : ''])
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="card">
                <h4 class="card-header form-weight-bold">{{ __('Languages') }} <small data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></small></h4>
                <div class="card-body pt-0 pb-0 pl-2 pr-2">
                    <div class="form-group">
                        <select name="language_id" id="language_id" class="form-control language-select">
                            @foreach($languages as $lang)
                            <option value="{{ $lang->id }}"{{ Request::get('lang') == $lang->id ? ' selected' : isset($post) && isset($post->language_id) && $post->language_id == $lang->id ? ' selected' : '' }}>{{ $lang->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <h4 class="card-header font-weight-bold">{{ __('Categories') }} <small data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></small></h4>
                <div class="card-body category-nested pb-0 pt-0">
                    <i class="fas fa-spinner fa-pulse"></i>
                    <span>{{ __('Loading') }}</span>
                </div>
                
            </div>

            <div class="card">
                <h4 class="card-header font-weight-bold">{{ __('Featured Image') }}</h4>
                <div class="card-body p-0">
                    @include('admin.common.imager.single', [
                    'target' => 'featured_image',
                    'info_text' => false,
                    'selected_image' =>
                    $post && $post->images->featured_image ? $post->images->featured_image : false,
                    ])
                </div>
            </div>

            <div class="card">
                <h4 class="card-header font-weight-bold">{{ __('Prefences') }}</h4>
                <div class="card-body p-0">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox w-100">
                                <input type="checkbox" class="custom-control-input" data-collapsed=".slider_image_container" name="features[slider]" id="customCheck1" value="1" {{ $post && $post->features && isset($post->features->slider) && $post->features->slider ? ' checked' : '' }}>
                                <label class="custom-control-label" for="customCheck1">{{ __('Add to Slider') }}</label>

                            </div>
                        </li>
                        <li class="list-group-item p-0 w-100 slider_image_container{{ $post && $post->features && isset($post->features->slider) && $post->features->slider ? ' d-block' : ' d-none' }}">
                            @include('admin.common.imager.single', [
                            'target' => 'slider_image',
                            'info_text' => __('Select Slider Image'),
                            'selected_image' =>
                            $post && $post->images->slider_image ? $post->images->slider_image : false,
                            ])
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="features[featured]" id="customCheck2" value="1" {{ $post && $post->features && isset($post->features->featured) && $post->features->featured ? ' checked' : '' }}>
                                <label class="custom-control-label" for="customCheck2">{{ __('Add to Featured') }}</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="features[breaking]" id="customCheck3" value="1" {{ $post && $post->features && isset($post->features->breaking) && $post->features->breaking ? ' checked' : '' }}>
                                <label class="custom-control-label" for="customCheck3">{{ __('Add to Breaking') }}</label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="features[recommended]" id="customCheck4" value="1" {{ $post && $post->features && isset($post->features->recommended) && $post->features->recommended ? ' checked' : '' }}>
                                <label class="custom-control-label" for="customCheck4">{{ __('Add to Trends') }}</label>
                            </div>
                        </li>
                    </ul>
                    <div class="form-group p-2">
                        <label for="exampleInput">{{ __('Publish Date') }}</label>
                        <input type="text" class="form-control datetime" name="publish_date" id="exampleInput" value="{{ old('publish_date', $post ? $post->publish_date : date('Y-m-d H:i')) }}">
                    </div>
                    <div class="form-group p-2">
                        <label for="visibility">{{ __('Visibility') }}</label>
                        <select class="form-control" id="visibility" name="visibility">
                            <option value="all" {{ $post && $post->visibility && $post->visibility == 'all' ? ' selected' : '' }}>
                                {{ __('Public') }}
                            </option>
                            <option value="only_members" {{ $post && $post->visibility && $post->visibility == 'only_members' ? ' selected' : '' }}>
                                {{ __('Only Members') }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group p-2">
                        <label for="status">{{ __('Status') }}</label>
                        <select class="form-control" id="status" name="status">
                            <option value="published" {{ $post && $post->status && $post->status == 'published' ? ' selected' : '' }}>
                                {{ __('Publish') }}
                            </option>
                            <option value="drafted" {{ $post && $post->status && $post->status == 'drafted' ? ' selected' : '' }}>{{ __('Draft') }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn btn-block btn-success"><i class="fa fa-save"></i> {{ __('Save Changes') }}</button>
        </div>
    </div>
</form>
</div>
<script>
    var lang_id = {{ Request::has('lang') ? Request::get('lang') : (isset($post) && isset($post->language_id) ? $post->language_id : config('app.default_lang.id')) }}
    var categories = [];
    function init_category_tree(categories) {
        if ($('.category-nested').length > 0) {
            if (categories != '[]') {
                console.log(categories)
                $('.category-nested').html('<ul>' + category_tree(categories[lang_id]) + '</ul>');
            } else {
                $('.category-nested').html('<div class="category-no-result text-center mt-4"><img src="'+base_url+'/assets/admin/not-result.jpg" class="category-not-result" width="200" alt=""></div>');
            }
        }
        $('.category-nested-input').change(function() {
            var elm = $(this);
            var parent = elm.attr("data-parent");
            if (elm.is(':checked')) {
                category_parent_checker(parent);
            } else {
                category_parent_unchecker(elm)
            }
        })
    }
    function category_tree(categories) {
        var html = '';
        $.each(categories, function(i, item) {
            var checked = '';
            $.each(selected_categories, function(a, atem) {
                if (atem == item.id) {
                    checked = 'checked';
                }
            })
            html += '<li class="category-nested-parent-' + item.id +
                '"><div class="custom-control custom-checkbox"><input class="custom-control-input category-nested-input" ' +
                checked + ' type="checkbox" id="category-checklist-' + item.id + '" value="' + item.id +
                '" data-parent="' + item.parent + '" name="categories[]"><label for="category-checklist-' + item
                .id + '" class="custom-control-label">' + item.category_title + '</label></div></li>';
            if (item.subs) {
                html += '<ul class="category-nested-ul category-nested-subs-' + item.id + '" data-parent="' +
                    item.id + '">' + category_tree(item.subs) + '</ul>';
            }
        })
        return html;
    }

    function category_parent_checker(parent_id) {
        var parent = $(".category-nested-input[value|='" + parent_id + "']");
        parent.prop("checked", true);
        if (parent.attr("data-parent") != 0) {
            category_parent_checker(parent.attr("data-parent"))
        }
    }

    function category_parent_unchecker(elm) {
        elm.parents(".category-nested-ul").find("input").prop("checked", false);
        if (elm.attr("data-parent") == 0) {
            elm.parent().parent().next().find("input").prop("checked", false);
        }
    }
    @if($categories)
    categories = {!! $categories !!}
    @endif
    var selected_categories = [];
    @if($post)
    @foreach($post->categories as $category)
    @if($category)
    selected_categories.push('{{  $category->uniq_id }}');
    @endif
    @endforeach
    @endif
    $('.language-select').change(function(){
        var elm = $(this);
        var id = elm.val();
        lang_id = id;
        init_category_tree(categories)
    })
</script>
