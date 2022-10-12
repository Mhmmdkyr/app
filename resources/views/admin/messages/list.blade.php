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
                                <th scope="col">{{ __('Message') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($messages) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($messages as $item)
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

                                            <h4 class="mb-0"> {{ $item->name }}</h4>
                                            <p class="mb-0">{{ $item->email }}</p>
                                            <p class="mb-0">{{ $item->phone }}</p>
                                        </td>
                                        <td>
                                            <h4>{{ $item->subject }}</h4>
                                            {{ \Illuminate\Support\Str::limit(getRow($item->message, 'textarea'), 200, '...') }}
                                        </td>
                                        <td>
                                            <a data-toggle="collapse" href="#message{{ $item->id }}"
                                                class="btn btn-xs btn-info btn-border"><i class="fa fa-info"></i></a>
                                            <button type="button" data-id="{{ $item->id }}"
                                                data-section="messages"
                                                class="btn btn-xs btn-danger btn-border delete-single"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr id="message{{ $item->id }}" class="collapse">
                                        <td colspan="4">
                                            <div class="card mb-0">
                                                <card class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6">
                                                            <p><b>{{ __('Full Name') }} : </b>
                                                                {{ $item->name }}
                                                            </p>
                                                            <p><b>{{ __('Email') }} : </b>
                                                                {{ $item->email }}
                                                            </p>
                                                            <p><b>{{ __('Ip Address') }} : </b>
                                                                {{ $item->ip_address }}</p>
                                                            
                                                            @if ($item->status)
                                                                <p><b>{{ __('Received Date') }}: </b>
                                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i') }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-8 col-md-8">
                                                            <div class="comment-detail">
                                                                {{ $item->message }}
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
                    <button class="btn btn-danger bulk-delete-button btn-block btn-sm" data-section="messages"
                        data-process="delete">{{ __('Delete All') }}</button>
                </div>
            </div>

            @if (count($messages) / 50 >= 1)
                {{ $messages->links() }}
            @endif
        </div>
    </div>
</div>
