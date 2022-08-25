<!DOCTYPE html>
<html lang="en">

<head>
	<title>Register Page</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico">
    <link id="theme-style" rel="stylesheet" href="{{asset('public/assets/css/portal.css')}}">

</head>

<body class="app app-signup p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding mb-4">
						<a class="app-logo" href="#">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32.6 32.6" style="enable-background:new 0 0 32.6 32.6" xml:space="preserve" width="60px">
								<path fill="#054A73" d="M19.5.3v32c-1 .2-2.1.3-3.2.3-9 0-16.3-7.3-16.3-16.3S7.3 0 16.3 0c1.1 0 2.2.1 3.2.3z" />
								<path fill="#0DA3CC" d="M24.8 2.4v27.9c-1.6 1-3.4 1.7-5.3 2.1V.4c1.9.3 3.7 1 5.3 2z" />
								<path fill="#B28500" d="M32.6 16.3c0 5.9-3.1 11.1-7.8 13.9V2.4c4.7 2.8 7.8 8 7.8 13.9z" />
							</svg>
						</a>
					</div>
					<h2 class="auth-heading text-center mb-4">Sign Up</h2>

					<div class="auth-form-container text-start mx-auto">
						<form class="auth-form auth-signup-form" method="POST" action="{{ route('register') }}">
                        @csrf
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Name</label>
								<input id="signup-name" name="name"  value="{{ old('name') }}" type="text" class="form-control signup-name @error('name') is-invalid @enderror" placeholder="Full name" required="required" autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="signup-email">Your Email</label>
								<input id="signup-email" name="email" type="email" class="form-control signup-email @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required="required" autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signup-password">Password</label>
								<input id="signup-password" name="password" type="password" class="form-control signup-password @error('password') is-invalid @enderror" placeholder="Create a password" required="required" autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

                            <div class="password mb-3">
								<label class="sr-only" for="signup-password">Confirm Password</label>
								<input id="password-confirm" name="password_confirmation" type="password" class="form-control signup-password"  required="required" autocomplete="new-password">
                           
							</div>
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign Up</button>
							</div>
						</form>

						<div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="{{route('login')}}">Log in</a></div>
					</div>
				</div>

				<footer class="app-auth-footer">
					<div class="container text-center py-3">
						<small class="copyright">Designed with <span class="sr-only">love</span>
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fb866a" stroke="fb866a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
								<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
							</svg>
						</small>
					</div>
				</footer>
			</div>
		</div>

		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
				<div class="d-flex flex-column align-content-end h-100">
					<div class="h-100"></div>

				</div>
			</div>
		</div>
	</div>
</body>

</html>