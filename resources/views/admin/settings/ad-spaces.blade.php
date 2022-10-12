<div class="page-inner">
    <div class="page-header mb-0">
        <h4 class="page-title">{{ __('Ad Spaces') }}</h4>
    </div>
    <div class="row mb-2 mt-4">
        <div class="col-lg-8 col-md-8">

        </div>
    </div>
    @php
        $config = (array) config('settings.ads');
    @endphp
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.settings.savespaces') }}" method="post">
                {{ csrf_field() }}
                <div class="accordion" id="ads">
                    @foreach ($spaces as $k => $space)
                        <div class="card">
                            <div class="card-header" id="heading{{ $k }}">
                                <h2 class="mb-0" data-toggle="collapse" data-target="#ad-{{ $k }}"
                                    aria-expanded="{{ $k == 'home' ? 'true' : 'false' }}"
                                    aria-controls="ad-{{ $k }}">
                                    {{ $space['title'] }}
                                </h2>
                            </div>

                            <div id="ad-{{ $k }}" class="collapse{{ $k == 'home' ? ' show' : false }}"
                                aria-labelledby="heading{{ $k }}" data-parent="#ads">
                                <div class="card-body">
                                    @foreach ($space['spaces'] as $m => $item)
                                        <h3 class="mb-3"> {{ $item['label'] }}</h3>
                                        <div class="row">
                                            <div class="col-2" style="margin-top: 35px">
                                                <div class="nav flex-column nav-pills"
                                                    id="v-{{ $k }}-{{ $m }}-tab" role="tablist"
                                                    aria-orientation="vertical">
                                                    <a class="nav-link active"
                                                        id="v-{{ $k }}-{{ $m }}-desktop-tab"
                                                        data-toggle="pill"
                                                        href="#v-{{ $k }}-{{ $m }}-desktop"
                                                        role="tab"
                                                        aria-controls="v-{{ $k }}-{{ $m }}-desktop"
                                                        aria-selected="true"><i class="fa fa-desktop"></i> {{ __('Desktop') }}</a>
                                                    @if ($item['mobile'])
                                                        <a class="nav-link"
                                                            id="v-{{ $k }}-{{ $m }}-mobile-tab"
                                                            data-toggle="pill"
                                                            href="#v-{{ $k }}-{{ $m }}-mobile"
                                                            role="tab"
                                                            aria-controls="v-{{ $k }}-{{ $m }}-mobile"
                                                            aria-selected="false"><i class="fa fa-mobile"></i>
                                                            {{ __('Mobile') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="tab-content"
                                                    id="v-{{ $k }}-{{ $m }}-tabContent">
                                                    <div class="tab-pane fade show active"
                                                        id="v-{{ $k }}-{{ $m }}-desktop"
                                                        role="tabpanel"
                                                        aria-labelledby="v-{{ $k }}-{{ $m }}-desktop-tab">
                                                        <h5><i class="fa fa-desktop"></i> <b>{{ __('Desktop') }}</b></h5>
                                                        <div class="row">
                                                            <div class="col-lg-7 col-md-7">
                                                                <div class="form-group">

                                                                    <textarea name="ads[{{ $k }}_{{ $m }}_desktop]"
                                                                        id="textarea-{{ $k }}-{{ $m }}-desktop" rows="8" class="form-control"
                                                                        placeholder="Paste the ad code in this field or create a new ad code on the right">{{ $config[$k . '_' . $m . '_desktop'] }}</textarea>
                                                                    <small
                                                                        class="text-muted">{{ __('Recommended ad sizes: :size', ['size' => $item['desktop']]) }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-md-5" style="margin-top: -30px">
                                                                <h4>{{ __('Create Ad Code') }}</h4>
                                                                <div style=" background:#fff; padding: 0 15px"
                                                                    class="create-code-wrapper">
                                                                    <div class="card mb-0" style="margin-top: 25px">
                                                                        <div class="card-body bg-white p-0">
                                                                            @include('admin.common.imager.mini',
                                                                                [
                                                                                    'target' =>
                                                                                        'ads_' .
                                                                                        $k .
                                                                                        '_' .
                                                                                        $m .
                                                                                        '_desktop',
                                                                                    'info_text' => false,
                                                                                    'dir' => 'ads',
                                                                                    'sizes' => [$item['desktop']],
                                                                                    'selected_image' => false,
                                                                                ])
                                                                        </div>
                                                                    </div>
                                                                    <hr style="margin-bottom: 5px">
                                                                    <div class="row">
                                                                        <div class="col-lg-8 col-md-8">
                                                                            <div class="form-group">
                                                                                <label for="">{{ __('Target URL') }}</label>
                                                                                <input type="text"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4">
                                                                            <div class="form-group mt-1">
                                                                                <label for="">&nbsp;</label>
                                                                                <button type="button"
                                                                                    data-main="textarea-{{ $k }}-{{ $m }}-desktop"
                                                                                    class="btn btn-outline-secondary btn-block float-right btn-sm create-code-submit">{{ __('Create') }}</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($item['mobile'])
                                                        <div class="tab-pane fade"
                                                            id="v-{{ $k }}-{{ $m }}-mobile"
                                                            role="tabpanel"
                                                            aria-labelledby="v-{{ $k }}-{{ $m }}-mobile-tab">
                                                            <h5><i class="fa fa-mobile"></i> <b>{{ __('Mobile') }}</b></h5>
                                                            <div class="row">
                                                                <div class="col-lg-7 col-md-7">
                                                                    <div class="form-group">
                                                                        <textarea name="ads[{{ $k }}_{{ $m }}_mobile]" rows="8"
                                                                            id="textarea-{{ $k }}-{{ $m }}-mobile" class="form-control"
                                                                            placeholder="Paste the ad code in this field or create a new ad code on the right">{{ $config[$k . '_' . $m . '_mobile'] }}</textarea>
                                                                        <small
                                                                            class="text-muted">{{ __('Recommended ad sizes: :size', ['size' => $item['mobile']]) }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5 col-md-5"
                                                                    style="margin-top: -30px">
                                                                    <h4>{{ __('Create Ad Code') }}</h4>
                                                                    <div style=" background:#fff; padding: 0 15px"
                                                                        class="create-code-wrapper">
                                                                        <div class="card mb-0"
                                                                            style="margin-top: 25px">
                                                                            <div class="card-body bg-white p-0">
                                                                                @include('admin.common.imager.mini',
                                                                                    [
                                                                                        'target' =>
                                                                                            'ads_' .
                                                                                            $k .
                                                                                            '_' .
                                                                                            $m .
                                                                                            '_mobile',
                                                                                        'info_text' => false,
                                                                                        'dir' => 'ads',
                                                                                        'sizes' => [
                                                                                            $item['mobile'],
                                                                                        ],
                                                                                        'selected_image' => false,
                                                                                    ])
                                                                            </div>
                                                                        </div>
                                                                        <hr style="margin-bottom: 5px">
                                                                        <div class="row">
                                                                            <div class="col-lg-8 col-md-8">
                                                                                <div class="form-group">
                                                                                    <label for="">{{ __('Target URL') }}</label>
                                                                                    <input type="text"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4">
                                                                                <div class="form-group mt-1">
                                                                                    <label
                                                                                        for="">&nbsp;</label>
                                                                                    <button type="button"
                                                                                        data-main="textarea-{{ $k }}-{{ $m }}-mobile"
                                                                                        class="btn btn-outline-secondary btn-block float-right btn-sm create-code-submit">{{ __('Create') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="clear"></div>
                <button class="btn btn-success btn-block"><i class="fa fa-save"></i> {{ __('Save Changes') }}</button>
            </form>
        </div>
    </div>
</div>
<script>
    $('.create-code-submit').click(function() {
        var elm = $(this);
        var main = elm.attr('data-main');
        var wrapper = elm.parents('.create-code-wrapper');
        var url = wrapper.find('input.form-control').val();
        var image = wrapper.find('.card-body>input').val();
        if (!url || !image) {
            alert('Please fill in all fields in the code creator.')
            return false;
        }
        var code = '<a href="' + url + '"  class="ad-item" data-sponsor="SPONSOR" target="_blank" rel="nofollow"><img src="' + base_url + '/uploads/' +
            image + '" alt="ad image" /></a>';
        $('#' + main).val(code)
    })
</script>
