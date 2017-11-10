@if ($errors->any())
	<ul class="uk-list uk-alert uk-alert-danger">
		@foreach ($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach		
	</ul>
@endif