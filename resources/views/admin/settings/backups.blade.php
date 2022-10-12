<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Database Backups') }}</h4>
        <a href="{{ route('admin.settings.downloaddb') }}" class="btn btn-primary btn-border ml-auto"><i
                class="fas fa-plus"></i> {{ __('New Database Backup') }}</a>
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
            <div class="card position-relative">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 tiny-td">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col" width="120" class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($backups) == 0)
                                <tr>
                                    <td colspan="6" style="background:#fff !important" class="text-center">
                                        <div class="not-result mb-4">
                                            <img src="{{ url('/') }}/assets/admin/not-result.jpg" alt="">
                                            <h2>{{ __('Sorry, no result found!') }}</h2>
                                            <p>{{ __('Would you like to add one now?') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($backups as $backup)
                                    <tr>
                                        <td>
                                            <h4><i class="fa fa-database"></i>
                                                {{ ucfirst(str_replace('_', ' ', $backup['name'])) }}</h4>
                                        </td>
                                        <td class="text-right">
                                            <form action="{{ route('admin.settings.downloadbackup') }}" method="post">
                                                <input type="hidden" name="file" value="{{ $backup['name'] }}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-sm btn-success btn-block"><i
                                                        class="fa fa-download"></i> {{ __('Download') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
