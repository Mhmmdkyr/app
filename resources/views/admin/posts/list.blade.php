<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Posts') }}</h4>
        <a href="{{ route('admin.posts.types', ['lang' => $lang]) }}" class="btn btn-primary btn-border ml-auto"><i
                class="fas fa-plus"></i> {{ __('Add Post') }}</a>
    </div>
    <div class="row mb-2 mt-4">
        <div class="col-lg-8 col-md-8">

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
            <div class="card position-relative">
                <div class="card-header pl-2 pr-2 pt-3 pb-2">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <ul class="breadcrumbs ml-0 pr-0 pl-0">
                                <li class="nav-item"><a
                                        href="{{ set_querystring('status', 'all') }}"><b>{{ __('All') }}
                                            ({{ $all_count }})</b></a></li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('status', 'published') }}"
                                        class="text-success"><b>{{ __('Published') }}
                                            ({{ $publish_count }})</b></a></li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('status', 'drafted') }}"
                                        class="text-warning"><b>{{ __('Drafted') }}
                                            ({{ $drafted_count }})</b></a></li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('status', 'trashed') }}"
                                        class="text-danger"><b>{{ __('Trashed') }}
                                            ({{ $trashed_count }})</b></a></li>
                            </ul>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 ml-auto">
                            <form action="{{ set_querystring() }}" method="get">
                                @if (isset($_GET['status']))
                                    <input type="hidden" name="status" value="{{ $_GET['status'] }}">
                                @endif
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder=""
                                        aria-label="" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                            {{ __('Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <select name="" id="" class="form-control form-control-sm dynamic_select">
                                @foreach($languages as $language)
                                    <option value="{{ set_querystring('lang', $language->id) }}"{{ isset($lang) && $lang == $language->id ? ' selected' : ''}}>{{ $language->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($status == 'trashed')
                        <div class="alert alert-danger bg-dark text-danger mb-0">
                            {{ __('Content is completely deleted 7 days after it is thrown away.') }}
                        </div>
                    @endif
                    <table class="table table-hover mb-0 tiny-td">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="55">
                                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                        <input type="checkbox" class="custom-control-input bulk-checkbox-group"
                                            id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline"></label>
                                    </div>
                                </th>
                                <th scope="col" width="110">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Description') }}</th>
                                <th scope="col" width="220">{{ __('Added Date') }}</th>
                                <th scope="col" width="220">{{ __('Features') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($posts) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                            <p>{{ __('Would you like to add one now?') }}</p>
                                            <a href="{{ route('admin.posts.types') }}" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i>
                                                {{ __('Add New') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($posts as $item)
                                    <tr>
                                        <td scope="col" class="text-center" width="55">
                                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                <input type="checkbox"
                                                    class="custom-control-input bulk-checkbox bulk-checkbox-group"
                                                    id="bulkProcessCheckbox{{ $item->id }}"
                                                    data-id="{{ $item->id }}">
                                                <label class="custom-control-label"
                                                    for="bulkProcessCheckbox{{ $item->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <img style="border-radius: 4px; border: 1px solid #dedede; box-shadow:  0 0 10px rgba(0,0,0,0.1)"
                                                src="{{ image_url($item->images->featured_image, '160x140') }}"
                                                width="70" alt="">
                                        </td>
                                        <td>
                                            <h4 style="margin-top: -10px"><b><a href="{{ uri('post', $item->slug) }}" class="text-dark" target="_blank">{{ $item->title }}</a></b></h4>
                                            @if (isset($item->categories))
                                                @foreach ($item->categories as $category)
                                                        <span
                                                            class="badge">{{ $category->category_title }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <div class="date-list">
                                                <p class="mb-0">
                                                    <b><small
                                                            style="font-size: 10px; display: block; margin-bottom: -5px">{{ __('Added Date') }}</small></b>
                                                    <span class="text-dark">{{ $item->created_at }}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <b><small
                                                            style="font-size: 10px; display: block; margin-bottom: -5px">{{ __('Publish Date') }}</small></b>
                                                    <span class="text-dark">{{ $item->publish_date }}</span>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <span title="{{ __('Add to Slider') }}" data-placement="left"
                                                class="badge bg-1{{ isset($item->features) && isset($item->features->slider) && $item->features->slider == '1' ? ' active' : ' passive' }}"><i
                                                    class="fas fa-star"></i></span>
                                            <span title="{{ __('Add to Featured') }}" data-placement="left"
                                                class="badge bg-1{{ isset($item->features) && isset($item->features->featured) && $item->features->featured == '1' ? ' active' : ' passive' }}"><i
                                                    class="fas fa-heart"></i></span>
                                            <span title="{{ __('Add to Breaking') }}" data-placement="left"
                                                class="badge bg-1{{ isset($item->features) && isset($item->features->breaking) && $item->features->breaking == '1' ? ' active' : ' passive' }}"><i
                                                    class="fas fa-bullhorn"></i></span>
                                            <span title="{{ __('Add to Trends') }}" data-placement="left"
                                                class="badge bg-1{{ isset($item->features) && isset($item->features->recommended) && $item->features->recommended == '1' ? ' active' : ' passive' }}"><i
                                                    class="fas fa-check-circle"></i></span>
                                        </td>
                                        <td>
                                            @if ($status == 'trashed')
                                                <button type="button" data-id="{{ $item->id }}"
                                                    class="btn btn-xs btn-success revert-item"><i
                                                        class="fa fa-backward"></i>
                                                    {{ __('Undo') }}</a>
                                                    <button type="button" data-id="{{ $item->id }}"
                                                        class="btn btn-xs btn-danger hard-delete ml-1"><i
                                                            class="fa fa-times"></i></button>
                                                @else
                                                    <a href="{{ route('admin.posts.edit', $item->id) }}"
                                                        class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                        {{ __('Edit') }}</a>
                                                    <button type="button" data-id="{{ $item->id }}"
                                                        data-section="posts"
                                                        class="btn btn-xs btn-danger delete-single"><i
                                                            class="fa fa-trash"></i></button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="bulk-actions-tools d-none">
                    <button class="btn btn-danger bulk-delete-button btn-block btn-sm"
                        data-section="posts">{{ __('Delete All') }}</button>
                </div>
            </div>

            {{ $posts->links() }}
        </div>
    </div>
</div>
