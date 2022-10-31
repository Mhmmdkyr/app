<div class="page-inner">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="alert alert-secondary system-update-monitor"><span>Mevcut sistem versiyonu :
                    <b>{{ config('app.version') }}</b></span> <button
                    class="btn btn-sm btn-warning ml-auto p-1 pl-4 pr-4 update-check">Kontrol Et</button></div>
        </div>
    </div>
    <div class="page-header">
        <h4 class="page-title">{{ __('Dashboard') }}</h4>
    </div>
    <div class="row">

        <div class="col-sm-6 col-md-3">
            <a class="card card-stats card-round" href="{{ route('admin.posts.index', ['status' => 'published']) }}">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="far fa-newspaper"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Published Posts') }}</p>
                                <h4 class="card-title">{{ $published_posts }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-newspaper"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Drafted Posts') }}</p>
                                <h4 class="card-title">{{ $drafted_posts }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="far fa-comments"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Pending Comments') }}</p>
                                <h4 class="card-title">{{ $pending_comments_count }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">{{ __('Registered Users') }}</p>
                                <h4 class="card-title">{{ $registered_users }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">{{ __('Latest Users') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($latest_users as $user)
                        <div class="d-flex">
                            <div class="avatar">
                                @if ($user->avatar)
                                    <img src="{{ image_url($user->avatar, '250x250') }}"
                                        class="rounded-circle border border-white">
                                @else
                                    <span
                                        class="avatar-title rounded-circle border border-white bg-info">{{ avatar_letter($user->name) }}</span>
                                @endif
                            </div>
                            <div class="flex-1 ml-3 pt-1">
                                <h5 class="text-uppercase fw-bold mb-1">{{ $user->name }} </h5>
                                <span
                                    class="text-uppercase fw-bold text-{{ $user->status ? 'success' : 'warning' }}">{{ $user->status ? __('Active') : __('Pending') }}</span>
                            </div>
                            <div class="float-right pt-1">
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">{{ __('Pending Comments') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($pending_comments as $comment)
                        <div class="d-flex">
                            <div class="flex-1 ml-3 pt-1">
                                <h5 class=" fw-bold mb-1"><i class="fa fa-link"></i> {{ $comment->post->title }}</h5>
                                <span class="text-muted"><b>{{ __('Comment') }} : </b>{{ $comment->comment }}</span>
                            </div>
                            <div class="float-right pt-1">
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.update-check').click(function() {
        var elm = $(this)
        elm.prop('disabled', true)
        $.get(base_url + "/admin/dashboard/update-check", function(data) {
            if (data.update) {
                $('.system-update-monitor').removeClass('alert-secondary')
                $('.system-update-monitor').addClass('alert-warning')
                $('.system-update-monitor').find('span').html(data.message)
                elm.prop('disabled', false)
                elm.text('Yükselt')
                elm.removeClass('update-check btn-warning')
                elm.addClass('update-now btn-success')
                $('.update-now').click(function() {
                    $.post(base_url + "/admin/dashboard/updater", {
                        '_token': token
                    }, function(data2) {
                        if (data2.update) {
                            $('.system-update-monitor').removeClass('alert-warning')
                            $('.system-update-monitor').addClass('alert-success')
                            $('.system-update-monitor').find('span').html(data2.message)
                            elm.remove()
                        } else {
                            $('.system-update-monitor').removeClass('alert-warning')
                            $('.system-update-monitor').addClass('alert-danger')
                            $('.system-update-monitor').find('span').html(
                                'Güncelleme işlemi başlatılırken hata meydana geldi. Lütfen daha sonra yeniden deneyin.')
                            elm.remove()
                        }
                    });
                })
            } else {
                $('.system-update-monitor').removeClass('alert-warning')
                $('.system-update-monitor').addClass('alert-success')
                $('.system-update-monitor').find('span').html(
                    'Güzel haber! Sisteminiz güncel görünüyor 🥳')
                elm.remove()
            }
        })
    })
</script>
