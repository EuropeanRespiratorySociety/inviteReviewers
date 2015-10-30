	@if (Session::has('flash_message'))
	<div class="uk-panel uk-width-1-3 uk-container-center" style="margin-top:50px;">
		<div class="uk-alert uk-alert-warning">
			<ul class="uk-list uk-alert uk-alert-danger">
				<li>{{Session::get('flash_message')}} <i class="uk-icon-button uk-icon-close"></i></li>
			</ul>
		</div>
	</div>
	@endif