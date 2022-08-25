@extends('admin-layouts.adminapp')
@section('content')
<div class="app-wrapper">

	<div class="app-content pt-3 p-md-3 p-lg-4">
		<div class="container-xl">

			<h1 class="app-page-title">My Account</h1>
			<div class="row gy-4">
				<div class="col-12 col-lg-6">
					<div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						<div class="app-card-header p-3 border-bottom-0">
							<div class="row align-items-center gx-3">
								<div class="col-auto">
									<div class="app-icon-holder">
										<svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10">
											<path d="M17.754 14a2.249 2.249 0 0 1 2.25 2.249v.575c0 .894-.32 1.76-.902 2.438-1.57 1.834-3.957 2.739-7.102 2.739-3.146 0-5.532-.905-7.098-2.74a3.75 3.75 0 0 1-.898-2.435v-.577a2.249 2.249 0 0 1 2.249-2.25h11.501Zm0 1.5H6.253a.749.749 0 0 0-.75.749v.577c0 .536.192 1.054.54 1.461 1.253 1.468 3.219 2.214 5.957 2.214s4.706-.746 5.962-2.214a2.25 2.25 0 0 0 .541-1.463v-.575a.749.749 0 0 0-.749-.75ZM12 2.004a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Z" fill="currentColor"></path>
										</svg>
									</div>

								</div>
								<div class="col-auto">
									<h4 class="app-card-title">Profile</h4>
								</div>
							</div>
						</div>
						<div class="app-card-body px-4 w-100">
							<div class="item border-bottom py-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<div class="item-label mb-2"><strong>Photo</strong></div>

										<div class="item-data">
											@if(Auth::user()->image)
											<img class="profile-image" src="{{asset('public/upload/profile/'.Auth::user()->image)}}" alt="">
											@else
											<img class="profile-image" src="{{asset('public/upload/profile/'.Auth::user()->image)}}" alt="">
											@endif

										</div>
									</div>
									<div class="col text-end">
										<a class="btn-sm app-btn-secondary" href="#" data-bs-toggle="modal" data-bs-target="#modelId1">Change</a>
									</div>
								</div>
							</div>
							<div class="item border-bottom py-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<div class="item-label"><strong>Name</strong></div>
										<div class="item-data">{{Auth::user()->name}}</div>
									</div>
								</div>
							</div>
							<div class="item  py-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<div class="item-label"><strong>Email</strong></div>
										<div class="item-data">{{Auth::user()->email}}</div>
									</div>

								</div>
							</div>
						</div>
						<div class="app-card-footer p-4 mt-auto">
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-6">
					<div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						<div class="app-card-header p-3 border-bottom-0">
							<div class="row align-items-center gx-3">
								<div class="col-auto">
									<div class="app-icon-holder">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-shield-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M5.443 1.991a60.17 60.17 0 0 0-2.725.802.454.454 0 0 0-.315.366C1.87 7.056 3.1 9.9 4.567 11.773c.736.94 1.533 1.636 2.197 2.093.333.228.626.394.857.5.116.053.21.089.282.11A.73.73 0 0 0 8 14.5c.007-.001.038-.005.097-.023.072-.022.166-.058.282-.111.23-.106.525-.272.857-.5a10.197 10.197 0 0 0 2.197-2.093C12.9 9.9 14.13 7.056 13.597 3.159a.454.454 0 0 0-.315-.366c-.626-.2-1.682-.526-2.725-.802C9.491 1.71 8.51 1.5 8 1.5c-.51 0-1.49.21-2.557.491zm-.256-.966C6.23.749 7.337.5 8 .5c.662 0 1.77.249 2.813.525a61.09 61.09 0 0 1 2.772.815c.528.168.926.623 1.003 1.184.573 4.197-.756 7.307-2.367 9.365a11.191 11.191 0 0 1-2.418 2.3 6.942 6.942 0 0 1-1.007.586c-.27.124-.558.225-.796.225s-.526-.101-.796-.225a6.908 6.908 0 0 1-1.007-.586 11.192 11.192 0 0 1-2.417-2.3C2.167 10.331.839 7.221 1.412 3.024A1.454 1.454 0 0 1 2.415 1.84a61.11 61.11 0 0 1 2.772-.815z" />
											<path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
										</svg>
									</div>

								</div>
								<div class="col-auto">
									<h4 class="app-card-title">Security</h4>
								</div>
							</div>
						</div>
						<div class="app-card-body px-4 w-100">

							<div class="item  py-3">
								<div class="row justify-content-between align-items-center">
									<div class="col-auto">
										<div class="item-label"><strong>Password</strong></div>
										<div class="item-data">••••••••</div>
									</div>

									<div class="col text-end">
										<a class="btn-sm app-btn-secondary" href="#" data-bs-toggle="modal" data-bs-target="#modelId">Change</a>
									</div>
									@if(session()->has('message'))
									<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
										{{session()->get('message')}}
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
									@endif

									@if(session()->has('error'))
									<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
										{{session()->get('error')}}
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>


	<!-- Change Password Modal -->
	<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Chnage Password</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="POST" action="{{route('chnage_password')}}">
						@csrf
						<div class="form-group">
							<div class="mb-3">
								<label>Current Password</label>
								<input type="password" name="old_password" class="form-control">
							</div>
							<div class="mb-3">
								<label>New Password</label>
								<input type="password" name="password" class="form-control">
							</div>
						</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Change Password</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Change Profile Modal -->
	<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Chnage Profile title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">

					<form method="POST" action="{{route('chnage_profile')}}" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<div class="mb-3">
								<label>Name</label>
								<input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
							</div>
							<div class="mb-3">
								<label>Photo</label>
								<input type="file" name="image" class="form-control">
							</div>
						</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	@endsection