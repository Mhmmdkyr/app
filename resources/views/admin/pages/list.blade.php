<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Pages') }}</h4>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-border ml-auto"><i
                class="fas fa-plus"></i> {{ __('Add Page') }}</a>
    </div>
    <div class="row mb-2 mt-4">
            <div class="col-lg-2 ml-auto col-md-2">
                <select name="" id="" class="form-control form-control-sm dynamic_select">
                    <option value="{{ set_querystring('lang', 0) }}">{{ __('All Pages') }}</option>
                    @foreach($languages as $language)
                        <option value="{{ set_querystring('lang', $language->id) }}"{{ isset($lang) && $lang == $language->id ? ' selected' : ''}}>{{ $language->title }}</option>
                    @endforeach
                </select>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <div class="card position-relative">
                <div class="card-body p-0">
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
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col" width="70">{{ __('Lang') }}</th>
                                <th scope="col" width="120">{{ __('Visibility') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($pages) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                            <p>{{ __('Would you like to add one now?') }}</p>
                                            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i>
                                                {{ __('Add New') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($pages as $item)
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
                                            <h4>{{ $item->title }}</h4>
                                        </td>
                                            <td>
                                                @foreach($languages as $language)
                                                    @if($language->id == $item->language_id)
                                                    <span class="badge text-uppercase">{{ $language->slug }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $item->visibility == 'all' ? 'success' : 'warning' }}">{{ $item->visibility == 'all' ? __('Everyone') : __('Only Members') }}</span>
                                        </td>
                                        <td>

                                            <a href="{{ route('admin.pages.edit', $item->id) }}"
                                                class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                                                {{ __('Edit') }}</a>
                                            <button type="button" data-id="{{ $item->id }}" data-section="pages"
                                                class="btn btn-xs btn-danger delete-single"><i
                                                    class="fa fa-trash"></i></button>

                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="bulk-actions-tools d-none">
                    <button class="btn btn-danger bulk-delete-button btn-block btn-sm"
                        data-section="pages">{{ __('Delete All') }}</button>
                </div>
            </div>

            {{ $pages->links() }}
        </div>
    </div>
</div>
