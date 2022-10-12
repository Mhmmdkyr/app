<div class="page-inner">
    <div class="page-header mb-4">
        <h4 class="page-title">{{ __('Newsletter') }}</h4>

    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="m-0 mb-3"><b>{{ __('Users') }}</b></h3>
                            <form action="{{ route('admin.newsletters.editor') }}" method="post">
                                <input type="hidden" name="type" value="user">
                                {{ csrf_field() }}
                                <table class="table table-striped mb-3 border border-rounded" id="users">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" width="55">
                                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customControlInline" data-toggle="checkboxer"
                                                        data-target="#users">
                                                    <label class="custom-control-label"
                                                        for="customControlInline"></label>
                                                </div>
                                            </th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td scope="col" class="text-center" width="55">
                                                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                        <input type="checkbox"
                                                            class="custom-control-input group-checkbox"
                                                            id="bulkProcessCheckbox{{ $user->id }}"
                                                            value="{{ $user->id }}" name="users[]" required
                                                            data-id="{{ $user->id }}">
                                                        <label class="custom-control-label"
                                                            for="bulkProcessCheckbox{{ $user->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <button class="btn btn-primary float-right"><i class="fas fa-paper-plane"></i>
                                    {{ __('Send Email') }}</button>
                                {{ $users->links() }}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="m-0 mb-3"><b>{{ __('Subscribers') }}</b></h3>
                            <form action="{{ route('admin.newsletters.editor') }}" method="post">
                                <input type="hidden" name="type" value="subscriber">
                                {{ csrf_field() }}
                                <table class="table table-striped mb-3 border border-rounded" id="subscribers">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" width="55">
                                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customControlInline2" data-toggle="checkboxer"
                                                        data-target="#subscribers">
                                                    <label class="custom-control-label"
                                                        for="customControlInline2"></label>
                                                </div>
                                            </th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Added Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscribers as $sub)
                                            <tr>
                                                <td scope="col" class="text-center" width="55">
                                                    <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                        <input type="checkbox"
                                                            class="custom-control-input group-checkbox"
                                                            id="bulkProcessCheckboxsub{{ $sub->id }}"
                                                            value="{{ $sub->id }}" name="subscribers[]" required
                                                            data-id="{{ $sub->id }}">
                                                        <label class="custom-control-label"
                                                            for="bulkProcessCheckboxsub{{ $sub->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $sub->email }}</td>
                                                <td>{{ $sub->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <button class="btn btn-primary float-right" type="submit"><i
                                        class="fas fa-paper-plane"></i>
                                    {{ __('Send Email') }}</button>
                            </form>
                            {{ $subscribers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
