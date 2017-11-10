@extends('invite')

@section('content')

<div class="uk-grid">
<div class="uk-width-1-1">

			<div class="uk-panel uk-width-1-3 uk-container-center" style="margin-top:50px;">
					@if (count($errors) > 0)
						<div class="uk-alert uk-alert-warning">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul class="uk-list">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
			</div>
	
			<div style="margin-top:50px;"class="uk-panel uk-panel-box uk-width-1-3 uk-container-center">
				<div class="uk-panel-title">Login</div>
						<form class="uk-form uk-form-stacked" role="form" method="POST" action="{{ url('/auth/login') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">


							<div class="uk-form-row">
								<label class="">Username</label>
								<input type="text" class="uk-form-large uk-width-1-1" name="username" value="{{ old('email') }}">				
							</div>
							<div class="uk-form-row">
								<label class="">Password</label>
								<input type="password" class="uk-form-large uk-width-1-1" name="password">
							</div>

							<div class="uk-form-row">
								<label>
								<input class="uk-form-large"type="checkbox" name="remember">
								Remember Me
								</label>	
							</div>

							<div class="uk-form-row">
								<button type="submit" class="uk-button uk-button-large uk-width-1-1">Login</button>
							</div>
							<div class="uk-form-row">
									<a class="" href="http://my.ersnet.org/Forgot">Forgot Your Password?</a>
							</div>
						</form>
					</div>
			
</div>			
		
@endsection
