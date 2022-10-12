<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title mb-4">{{ $title }}</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('status'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
            @endif
            <div class="card position-relative">
                <div class="card-header pr-2 pb-2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <ul class="breadcrumbs ml-0 pr-0 pl-0">
                                <li class="nav-item"><a
                                        href="{{ set_querystring('filter', 'all') }}"><b>{{ __('All') }}
                                            ({{ $all_count }})</b></a></li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('filter', 'approved') }}"
                                        class="text-success"><b>{{ __('Approved') }} ({{ $approved_count }})</b></a>
                                </li>
                                <li class="separator"> | </li>
                                <li class="nav-item"><a href="{{ set_querystring('filter', 'pending') }}"
                                        class="text-warning"><b>{{ __('Pending') }} ({{ $pending_count }})</b></a>
                                </li>
                            </ul>
                        </div>
                        {{-- <div class="col-lg-3 col-md-3 ml-auto">
                            <form action="{{ set_querystring() }}" method="get">
                                @if (isset($_GET['status']))
                                <input type="hidden" name="status" value="{{ $_GET['status'] }}">
                                @endif
                                <div class="input-group input-group-sm" style="margin-top: -7px">
                                    <input type="text" class="form-control" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i> {{ __('global.search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}

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
                                <th scope="col" width="300">{{ __('User Informations') }}</th>
                                <th scope="col">{{ __('Comment') }}</th>
                                <th scope="col" width="150">{{ __('Status') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($comments) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($comments as $item)
                                    <tr class="{{ $item->status ? 'approved-comment' : 'pending-comment' }}">
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
                                            @if ($item->user)
                                                <h4 class="mb-0"><i class="fa fa-check-circle"
                                                        title="{{ __('Registered User') }}"></i>
                                                    {{ $item->user->name }}</h4>
                                                <p class="mb-0">{{ $item->user->email }}</p>
                                            @else
                                                <h4 class="mb-0"> {{ $item->fullname }}</h4>
                                                <p class="mb-0">{{ $item->email }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->post && $item->post->meta)
                                                <h4><a href="{{ url('post') . '/' . $item->post->slug }}"
                                                        class="text-dark" target="_blank"><b><i class="fa fa-link"></i>
                                                            {{ $item->post->title }}</b></a></h4>
                                            @endif
                                            {{ \Illuminate\Support\Str::limit(getRow($item->comment, 'textarea'), 200, '...') }}
                                        </td>
                                        <td>
                                            <div style="width: 110px"
                                                class="badge buttons-badge badge-{{ $item->status ? 'success' : 'default' }}">
                                                {{ $item->status ? __('Approved') : __('Pending') }}
                                                @if ($item->status)
                                                    <a class="btn btn-xs btn-in-badge btn-danger"
                                                        href="{{ route('admin.comments.status', ['id' => $item->id, 'status' => 0]) }}"><i
                                                            class="fa fa-times"></i></a>
                                                @else
                                                    <a class="btn btn-xs btn-in-badge btn-success"
                                                        href="{{ route('admin.comments.status', ['id' => $item->id, 'status' => 1]) }}"><i
                                                            class="fa fa-check"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a data-toggle="collapse" href="#comment{{ $item->id }}"
                                                class="btn btn-xs btn-info btn-border"><i class="fa fa-info"></i></a>
                                            <button type="button" data-id="{{ $item->id }}"
                                                data-section="comments"
                                                class="btn btn-xs btn-danger btn-border delete-single"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr id="comment{{ $item->id }}" class="collapse">
                                        <td colspan="5">
                                            <div class="card mb-0">
                                                <card class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6">
                                                            <p><b>{{ __('Full Name') }} : </b>
                                                                {{ isset($item->user) ? $item->user->name : $item->fullname }}
                                                            </p>
                                                            <p><b>{{ __('Email') }} : </b>
                                                                {{ isset($item->user) ? $item->user->email : $item->email }}
                                                            </p>
                                                            <p><b>{{ __('Ip Address') }} : </b>
                                                                {{ $item->user_ip }}</p>
                                                            <p><b>{{ __('Status') }}: </b>
                                                                {{ $item->status ? __('Approved') : __('Pending') }}
                                                            </p>
                                                            @if ($item->status)
                                                                <p><b>{{ __('Approved Date') }}: </b>
                                                                    {{ \Carbon\Carbon::parse($item->updated_at)->format('d.m.Y H:i') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-8 col-md-8">
                                                            <div class="comment-detail">
                                                                {{ $item->comment }}
                                                                <hr>
                                                                @if ($item->status)
                                                                    <a class="btn btn-danger"
                                                                        href="{{ route('admin.comments.status', ['id' => $item->id, 'status' => 0]) }}"><i
                                                                            class="fa fa-times"></i>
                                                                        {{ __('Swich Pending') }}</a>
                                                                @else
                                                                    <a class="btn btn-success"
                                                                        href="{{ route('admin.comments.status', ['id' => $item->id, 'status' => 1]) }}"><i
                                                                            class="fa fa-check-circle"></i>
                                                                        {{ __('Approve') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </card>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="bulk-actions-tools d-none">
                    <button class="btn btn-danger bulk-delete-button btn-block btn-sm" data-section="comments"
                        data-process="delete">{{ __('Delete All') }}</button>
                </div>
            </div>

            @if (count($comments) / 50 >= 1)
                {{ $comments->links() }}
            @endif
        </div>
    </div>
</div>
