<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Users') }}</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-border ml-auto"><i class="fas fa-plus"></i>
            {{ __('Add User') }}</a>
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
            <div class="card">
                <div class="card-header pl-2 pr-2 pt-3 pb-2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <ul class="breadcrumbs ml-0 pr-0 pl-0">
                                <li class="nav-item"><a
                                        href="{{ set_querystring('status', 'all') }}"><b>{{ __('All') }}
                                            ({{ $all_count }})</b></a></li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('status', 'approved') }}"
                                        class="text-success"><b>{{ __('Approved') }}
                                            ({{ $approved_count }})</b></a></li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('status', 'pending') }}"
                                        class="text-warning"><b>{{ __('Waiting Approval') }}
                                            ({{ $pending_count }})</b></a></li>

                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3 ml-auto">
                            <form action="{{ set_querystring() }}" method="get">
                                @if (isset($_GET['status']))
                                    <input type="hidden" name="status" value="{{ $_GET['status'] }}">
                                @endif
                                <div class="input-group input-group-sm" style="margin-top: -7px">
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

                    </div>
                </div>
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
                                <th scope="col">{{ __('User Informations') }}</th>
                                <th scope="col" width="220">{{ __('Role') }}</th>
                                <th scope="col" width="120">{{ __('Status') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($users) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                            <p>{{ __('Would you like to add one now?') }}</p>
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i>
                                                {{ __('Add New') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($users as $item)
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
                                            <div class="left-imaged-td">
                                                @if ($item->avatar)
                                                    <img src="{{ image_url($item->avatar) }}" alt="..."
                                                        class="avatar-img rounded-circle" width="50">
                                                @else
                                                    <div class="avatar-letter">{{ avatar_letter($item->name) }}</div>
                                                @endif
                                            </div>
                                            <h5 class="mb-0 mt-2">{!! getRow($item->name, 'input:text') !!}</h5>
                                            <small>{!! getRow($item->email, 'input:text') !!}</small>
                                        </td>
                                        <td>{{ $item->role ? $item->role->role : __('Undefined') }}</td>
                                        <td>
                                            <div style="width: 110px"
                                                class="badge buttons-badge badge-{{ $item->status ? 'success' : 'default' }}">
                                                {{ $item->status ? __('Approved') : __('Pending') }}
                                                @if ($item->status)
                                                    <a class="btn btn-xs btn-in-badge btn-danger"
                                                        href="{{ route('admin.users.status', ['id' => $item->id, 'status' => 0]) }}"><i
                                                            class="fa fa-times"></i></a>
                                                @else
                                                    <a class="btn btn-xs btn-in-badge btn-success"
                                                        href="{{ route('admin.users.status', ['id' => $item->id, 'status' => 1]) }}"><i
                                                            class="fa fa-check"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $item->id) }}"
                                                class="btn btn-xs btn-warning btn-border"><i class="fa fa-edit"></i>
                                                {{ __('Edit') }}</a>
                                            <button type="button" data-id="{{ $item->id }}"
                                                data-section="users" class="btn btn-xs btn-danger delete-single"><i
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
                        data-section="users">{{ __('Delete All') }}</button>
                </div>
            </div>
        </div>
        {{ $users->links() }}
    </div>
</div>
