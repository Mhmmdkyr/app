
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>{{ config('app.name', 'Amasra') }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ url('/') }}/backend/img/icon.ico" type="image/x-icon"/>
	<base href="{{ url('/') }}/">
	<!-- Fonts and icons -->
	<script src="{{ url('/') }}/backend/js/plugin/webfont/webfont.min.js?version=<?=VERSION;?>"></script>
	<script>
		WebFont.load({
			google: {"families":["Inter:200,400,500,600"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ url('/') }}/backend/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<link rel="stylesheet" href="{{ url('/') }}/backend/css/bootstrap.min.css?version=<?=VERSION;?>">
	<link rel="stylesheet" href="{{ url('/') }}/backend/css/azzara.min.css?version=<?=VERSION;?>">
	<link rel="stylesheet" href="{{ url('/') }}/backend/css/app.css?version=<?=VERSION;?>">
	<script>
		var base_url = "{{ url('/') }}";
		var token = "{{ csrf_token() }}";
		var lang = [];
		@foreach (__('messages') as $key => $message)
			lang.{{ $key }} = '{{ $message }}'
		@endforeach
	</script>
	<script src="{{ url('/') }}/backend/js/core/jquery.3.2.1.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/core/popper.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/core/bootstrap.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/vendor/tinymce/tinymce.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/init.js?version=<?=VERSION;?>"></script>
	@if(isset($imager) && $imager)
	<script src="{{ url('/') }}/backend/js/imager.js?version=<?=VERSION;?>"></script>
	@endif
	<script src="{{ url('/') }}/backend/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/moment/moment.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/chart.js/chart.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/jquery.sparkline/jquery.sparkline.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/chart-circle/circles.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/bootstrap-notify/bootstrap-notify.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/sweetalert/sweetalert.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/ready.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/datepicker/bootstrap-datetimepicker.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js?version=<?=VERSION;?>"></script>
	<script src="{{ url('/') }}/backend/js/plugin/sweetalert/sweetalert.min.js?version=<?=VERSION;?>"></script>
</head>
<body data-background-color="bg3">
	<div class="wrapper">
		<!--
			Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
		-->
		<div class="main-header" data-background-color="white">
			<!-- Logo Header -->
			<div class="logo-header  mw-100">

				<a href="{{ route('admin.dashboard')}}" class="logo  mw-100">
					<span class="navbar-brand mw-100"><img src="{{ url('/') }}/backend/img/logo-small.png" width="35" alt=""> <span class="site-text">{{ config('app.name', 'income') }}</span></span>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon mt-4">
						<i class="far fa-dot-circle text-dark"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v mt-4 text-dark"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded mt-4">
						<i class="far fa-dot-circle text-dark"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			@include('admin.includes.navbar')
			<!-- End Navbar -->
		</div>
		@include('admin.includes.sidebar', $left_menu)
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				@include($view)
			</div>
		</div>
	</div>
</div>
@if(isset($imager) && $imager)
<div class="modal fade" id="imager" tabindex="122" style="z-index: 145334443" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Imager</h5>
		  <button type="button" class="close" onClick="close_modal()" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body p-0">
		  <iframe src="{{ url('/') }}/backend/imager?" width="100%" height="550" frameborder="0"></iframe>
		</div>
	  </div>
	</div>
  </div>
@endif
</body>
</html>
