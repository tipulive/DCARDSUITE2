@extends('layouts.app')
@section('content')

<div class="limiter">

		<div class="container-login100" style="background-image: url('loginfolder/images/bg-012.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
			@if (\Session::has('status'))
			<form class="login100-form validate-form" method="POST" action="{{\Session::get('status')}}">
			@else

				<form class="login100-form validate-form" method="POST" action="{{ route('User_forgetpassword') }}">
				@endif	
				{{ csrf_field() }}
					
				<a href="index.html"><span style="visibility:hidden">Back Home</span></a><span class="login100-form-title p-b-49">
					Forget Password
				</span>
				@if (\Session::has('errors'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Hi</strong>{!! \Session::get('errors') !!}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
					@if (\Session::has('status'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Hi </strong>{!! \Session::get('status') !!}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is required">
						<span class="label-input100">Email or Phone </span>
						<input class="input100" type="text" name="email" placeholder="Email or Phone" required>
						<span class="focus-input100" data-symbol="&#xf15a;"></span>
						@if (\Session::has('status'))
						<span class="help-block"  style="color:red">
							<strong>{!! \Session::get('status') !!}</strong>
						</span>
                           @else
                           
					@endif
					</div>

					


					
					
                  
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn btn-small">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Forget Password
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