
<div class="page-inner">
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
									@foreach($latest_users as $user)
									<div class="d-flex">
										<div class="avatar">
											@if($user->avatar)
											<img src="{{ image_url($user->avatar, '250x250') }}" class="rounded-circle border border-white">
											@else
											<span class="avatar-title rounded-circle border border-white bg-info">{{ avatar_letter($user->name) }}</span>
											@endif
										</div>
										<div class="flex-1 ml-3 pt-1">
											<h5 class="text-uppercase fw-bold mb-1">{{ $user->name }} </h5>
											<span class="text-uppercase fw-bold text-{{ $user->status ? 'success' : 'warning' }}">{{ $user->status ? __('Active') : __('Pending') }}</span>
										</div>
										<div class="float-right pt-1">
											<small class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</small>
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
									@foreach($pending_comments as $comment)
									<div class="d-flex">
										<div class="flex-1 ml-3 pt-1">
											<h5 class=" fw-bold mb-1"><i class="fa fa-link"></i> {{ $comment->post->title }}</h5>
											<span class="text-muted"><b>{{ __('Comment') }} : </b>{{ $comment->comment }}</span>
										</div>
										<div class="float-right pt-1">
											<small class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
										</div>
									</div>
									<div class="separator-dashed"></div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>