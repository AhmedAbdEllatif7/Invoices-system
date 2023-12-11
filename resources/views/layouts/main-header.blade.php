<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
						
					</div>
					<div class="main-header-right">
						<ul class="nav">
							<li class="">
								
							</li>
						</ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" role="search">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>

							@can('الاشعارات')
							<div class="dropdown nav-item main-header-notification">
								<a class="new nav-link" href="#" style="position: relative;">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
										stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
										class="feather feather-bell">
										<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
										<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
									</svg>
									@if(auth()->user()->unreadNotifications->count() > 0)
									<div id="unreadIconeNotifications">
										<span class="badge badge-pill badge-danger" style="position: absolute; top: 1px; right: 1px;">
											{{ auth()->user()->unreadNotifications->count() }}
										</span>
									</div>
									@endif
								</a>
								
								
								<div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-right">
										<div class="d-flex">

											<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الإشعارات</h6>
											@if(auth()->user()->unreadNotifications->count() > 0)
											<span class="badge badge-pill badge-warning mr-auto my-auto float-left" style="font-size: 16px;">
												<a href="{{ route('read.all.notification') }}" style="color: white; font-size: inherit;">تحديد الكل كمقرؤ</a>
											</span>
											@endif
											
										</div>
										<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12">
											<h6 style="color: rgb(255, 255, 255)" id="notificationsCount">
												{{ auth()->user()->unreadNotifications->count() }}
											</h6>
										</p>
									</div>
									<div id="unreadNotifications" style="max-height: 300px; overflow-y: auto;">
										@foreach (auth()->user()->unreadNotifications as $notification)
											<div class="main-notification-list">
												<a class="d-flex p-3 border-bottom" href="{{ route('view.notification.invoice', ['id' => $notification->data['id']]) }}">
													<div style="height: 40px" class="notifyimg bg-pink">
														<i class="la la-file-alt text-white"></i>
													</div>
													<input type="hidden" name="id" value="{{$notification->id}}">
													<div class="mr-3">
														<h5 class="notification-label mb-1">
															{{ $notification->data['title'] }} {{ $notification->data['created_by'] }}
														</h5>
														<h5 class="notification-label mb-1">
														رقم الفاتورة {{ $notification->data['invoice_number'] }} 
														</h5>
														<div class="notification-subtext">
															{{ $notification->created_at->setTimezone('Africa/Cairo')->format('F j, Y g:i A') }}
														</div>
													</div>
												</a>
											</div>
										@endforeach
									</div>
									{{-- <div class="dropdown-footer">
										<a href="#">VIEW ALL</a>
									</div> --}}
								</div>
							</div>
							@endcan

							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('Images/317691123_1910822605946650_4850342044776345663_n.jpg')}}"></a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user"><img alt="" src="{{URL::asset('Images/317691123_1910822605946650_4850342044776345663_n.jpg')}}" class=""></div>
											<div class="mr-3 my-auto">
												<h6>{{auth()->user()->name}}</h6><span>{{auth()->user()->email}}</span>
											</div>
										</div>
									</div>

									<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
												document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i>تسجيل خروج
									</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
	
<!-- /main-header -->
