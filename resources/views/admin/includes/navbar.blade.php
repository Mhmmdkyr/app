<nav class="navbar navbar-header navbar-expand-lg">

	<div class="container-fluid">
		<ul class="navbar-nav topbar-nav mr-md-auto align-items-center">
			<li><a href="{{ route('admin.posts.create') }}" class="text-dark fw-bold"><i class="fa fa-plus"></i> {{ __('Add Post') }}</a></li>
			<li class="ml-4"><a href="{{ route('admin.comments.index', ['filter' => 'pending']) }}" class="text-dark fw-bold"><i class="fa fa-comment"></i> {{ __('Pending Comments') }}</a></li>
		</ul>
		<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
			<li class="nav-item mr-4">
				<a href="{{ url('/') }}" target="_blank" class="text-dark fw-bold"><i class="fa fa-external-link-alt"></i> {{ __('View Site') }}</a>
			</li>
			<li class="nav-item toggle-nav-search hidden-caret">
				<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
					<i class="fa fa-search"></i>
				</a>
			</li>
			<li class="nav-item dropdown hidden-caret">
				<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
					<div class="avatar-sm">
						<img src="{{ image_url(auth()->user()->avatar, '250x250') }}" alt="..." class="avatar-img rounded-circle border border-white">
					</div>
				</a>
				<ul class="dropdown-menu dropdown-user animated fadeIn">
					<li>
						<div class="user-box">
							<div class="u-text">
								<h4>{{ auth()->user()->name }}</h4>
								<p class="text-muted">{{ auth()->user()->email }}</p>
							</div>
						</div>
					</li>
					<li>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('frontend.user.profile') }}">Profili Düzenle</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('frontend.login.logout') }}">Çıkış Yap</a>
					</li>
				</ul>
			</li>

		</ul>
	</div>
</nav>
