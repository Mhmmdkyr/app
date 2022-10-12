<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Roles') }}</h4>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-border ml-auto"><i
                class="fas fa-plus"></i> {{ __('Add Role') }}</a>
    </div>
    <div class="row mb-2 mt-4">
        <div class="col-lg-8 col-md-8">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <div class="card">
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
                                <th scope="col">Role</th>
                                <th scope="col" width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($roles) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                            <p>{{ __('Would you like to add one now?') }}</p>
                                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i>
                                                {{ __('Add New') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($roles as $item)
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

                                            <h5 class="mb-0 mt-2">{!! getRow($item->role, 'input:text') !!}</h5>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.roles.edit', $item->id) }}"
                                                class="btn btn-xs btn-warning btn-border"><i class="fa fa-edit"></i>
                                                Edit</a>
                                            <button type="button" data-id="{{ $item->id }}" data-section="roles"
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
                        data-section="roles">{{ __('Delete All') }}</button>
                </div>
            </div>
        </div>
        {{ $roles->links() }}
    </div>
</div>
