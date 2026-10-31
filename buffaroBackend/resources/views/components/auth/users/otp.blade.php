@extends('layouts.app')
@section('content')

<div class="limiter">

		<div class="container-login100" style="background-image: url('loginfolder/images/bg-012.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
			@if (\Session::has('link'))
			<form class="login100-form validate-form" method="POST" action="{{\Session::get('link')}}">
			@else

				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
				@endif	
				{{ csrf_field() }}
				@if (\Session::has('tel'))
                <input type="hidden" name="tel" value="{{\Session::get('tel')}}">
                <input type="hidden" name="expired_at" value="{{\Session::get('expired_at')}}">
				@endif
				<a href="index.html"><span style="visibility:hidden">Back Home</span></a><span class="login100-form-title p-b-49">
					OTP
				</span>
				@if (\Session::has('status'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong></strong>{!! \Session::get('status') !!}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
					<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is required">
						<span class="label-input100">OTP</span>
						<input class="input100" type="text" name="otp" placeholder="otp">
						<span class="focus-input100" data-symbol="&#xf2be;"></span>
						@if (\Session::has('status'))
						<span class="help-block d-none"  style="color:red">
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
								Verify
							</button>
						</div>
					</div>
					
                  

					

				
				</form>
			</div>
		</div>
	</div>
	
@endsection