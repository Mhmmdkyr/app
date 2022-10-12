<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ __('Navigations') }}</h4>
        <div class="clear"></div>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="p-4 h-100" style="background:#f5f5f5; border-right: 1px solid #dedede">
                                <h4>
                                    @if (isset($category))
                                        <b class="text-warning"><i class="fa fa-edit"></i>
                                            {{ __('settings.edit_item') }}</b>
                                        <a href="{{ route('admin.navigations.index') }}"
                                            class="float-right text-dark"><i class="fa fa-chevron-left"></i>
                                            {{ __('global.go_back') }}</a>
                                    @else
                                        <b class="text-success"><i class="fa fa-plus"></i>
                                            {{ __('settings.new_item') }}</b>
                                    @endif
                                </h4>
                                <hr>
                                @if (isset($category))
                                    <form action="{{ route('admin.navigations.update', $category->id) }}"
                                        method="post">
                                    @else
                                        <form action="{{ route('admin.navigations.store') }}" method="post">
                                @endif
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="navigationname">{{ __('global.title') }}</label>
                                    <input type="text" class="form-control" id="title" name="navigationtitle"
                                        value="{{ isset($category) ? $category->navigationtitle : '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent">{{ __('settings.parent') }}</label>
                                    <select class="custom-select" id="parent" name="parent">
                                        <option value="">{{ __('settings.select_parent_item') }}</option>
                                        @foreach ($navigations as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ isset($category) && $category->parent == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->navigationtitle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type">{{ __('settings.content') }}</label>
                                    <select class="custom-select" id="type" name="type">
                                        <option value="">{{ __('settings.select_content') }}</option>
                                        <option value="">{{ __('settings.category') }}</option>
                                        <option value="">{{ __('settings.page') }}</option>
                                        <option value="">{{ __('settings.link') }}</option>
                                    </select>
                                </div>
                                <button
                                    class="btn btn-{{ isset($category) ? 'warning' : 'success' }} float-right mb-4 pl-4 pr-4"><i
                                        class="fa fa-save"></i> {{ __('global.save_changes') }}</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <table class="table table-hover mb-0 tiny-td">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" width="55">
                                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="customControlInline">
                                                <label class="custom-control-label" for="customControlInline"></label>
                                            </div>
                                        </th>
                                        <th>Item Detail</th>
                                        <th scope="col" width="160" class="text-center">
                                            {{ __('global.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($navigations) == 0)
                                        <tr>
                                            <td colspan="6" style="background:#fff !important" class="text-center">
                                                <div class="not-result mb-4">
                                                    <img src="{{ url('/') }}/assets/admin/not-result.jpg"
                                                        alt="">
                                                    <h2>{{ __('global.no_result_title') }}</h2>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($navigations as $item)
                                            <tr>
                                                <td scope="col" class="text-center" width="55">
                                                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="bulkProcessCheckbox{{ $item->id }}">
                                                        <label class="custom-control-label"
                                                            for="bulkProcessCheckbox{{ $item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>{!! getRow($item->navigationtitle, 'input:text') !!}</td>
                                                <td>
                                                    <a href="{{ route('admin.navigations.edit', $item->id) }}"
                                                        class="btn btn-xs btn-warning btn-border"><i
                                                            class="fa fa-edit"></i> {{ __('global.edit') }}</a>
                                                    <a onClick="return confirm('Are you fucking kidding me?')"
                                                        href="{{ route('admin.navigations.delete', $item->id) }}"
                                                        class="btn btn-xs btn-danger btn-border"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $navigations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
