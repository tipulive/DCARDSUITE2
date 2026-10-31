@extends('layouts.app')
@section('content')

<div class="limiter">

		<div class="container-login100" style="background-image: url('loginfolder/images/bg-012.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form" method="POST" action="{{ route('user_resend_confirmation') }}">
				{{ csrf_field() }}
					
				<a href="index.html"><span style="visibility:hidden">Back Home</span></a><span class="login100-form-title p-b-49">
				Email Confirmation
				</span>
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is required">
						<span class="label-input100">Email or Phone</span>
						<input class="input100" type="text" name="email" placeholder="Email or Phone">
						<span class="focus-input100" data-symbol="&#xf15a;"></span>
						@if (\Session::has('status'))
						<span class="help-block"  style="color:red">
							<strong>{!! \Session::get('status') !!}</strong>
						</span>
                           @else
						
					@endif
					</div>

					


					
					
                    <div class="text-right p-t-8 p-b-31" style="color:blue">
						
					</div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn btn-small">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Resend Email or OTP
							</button>
						</div>
					</div>
                    <div class="text-right p-t-8 p-b-31" >
						<a href="loginpage" style="color:blue">
						Login
						</a>
					</div>

					

				
				</form>
			</div>
		</div>
	</div>
	
@endsection