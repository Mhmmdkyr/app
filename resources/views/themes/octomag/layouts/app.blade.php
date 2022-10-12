<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('app.active_lang.rtl') ? 'rtl' : 'ltr' }}">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @include('themes.'.$theme->path.'.includes.meta', ['settings' => config('settings'), 'languages' => config('app.languages')])
</head>

@if(session()->has('dark_mode'))
<body class="dark-mode">
@else
<body>
@endif
  <div class="preloader">
    <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/logo.png" height="25" alt="">
    <div class="lds-ripple">
      <div></div>
      <div></div>
    </div>
  </div>
  @include('themes.'.$theme->path.'.includes.header')
    @include($view)
  </main>
  <div class="clear"></div>
  <div class="container mb-d">
    <div class="d-none d-md-none d-lg-block">
      @if (config('settings.ads') && isset(config('settings.ads')->home_bottom_desktop))
          {!! config('settings.ads')->home_bottom_desktop !!}
      @endif
  </div>
  <div class="clear"></div>
  <div class="d-block d-sm-none">
  @if (config('settings.ads') && isset(config('settings.ads')->home_bottom_mobile))
      {!! config('settings.ads')->home_bottom_mobile !!}
  @endif
  </div>
</div>
  <div class="clear"></div>
  @include('themes.'.$theme->path.'.includes.footer')
</body>

</html>