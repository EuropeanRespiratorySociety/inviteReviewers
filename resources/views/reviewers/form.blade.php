	@extends('invite')

	@section('content')
	<div id="invite" style="padding-left:35px"> 

	<div v-if="notAllowed" class="uk-grid uk-text-center">
		<h1 class="uk-container-center" style="margin-top:50px;"> You are not allowed to suggest reviewers</h1>
	</div>
	<div v-if="! submitted" class="uk-grid">

		<h3 v-if="!notAllowed" class="" style="margin-top:50px;"> Welcome {{ $user->name }}
		@if($user->group)
		<p class="uk-text uk-text-muted uk-text-small">ERS group: {{ $user->group }}</p>
		@endif
		</h3>
	</div>
	<div v-if="! submitted" class="uk-grid uk-text-center">
		<h1 v-if="!notAllowed" class="uk-container-center" style="margin-top:50px;"> You still have @{{quantity}} reviewers to select.</h1>
	</div>
	<div class="uk-grid uk-grid-medium">
		<div v-if="! submitted" class="uk-width-medium-1-3 uk-grid-width-small-1-1">
			<h2 v-if="!notAllowed" style="margin-top:30px;" class="uk-text uk-text-center">Step 1</h2>
			<div v-if="!notAllowed" class="uk-grid">
				<div style="margin-top:30px;"class="uk-panel uk-panel-header uk-panel-box uk-width-1-1 uk-container-center">
					<div class="uk-panel-title">Search for an existing ERS Contact</div>
					<p class="uk-text-muted">Type the contact name you are looking for, and select the right person suggested from ERS database. 
						To select someone, use the arrow key / hit enter or click to validate your selection. 
						If you do not find the person you want to invite, simply fill in manually the form on Step 2.
					</p>
					<form class="uk-form">
						<input type="text" 
						id="search" 
						name="search" 		
						class="uk-form-large uk-width-1-1"
						v-model="search.last_name" 
						placeholder="Start typing..." 
						>
					</form>
				</div>
			</div>
		</div>
		<div v-if="submitted" class="uk-width-medium-1-3 uk-grid-width-small-1-1">
		</div>
		<div v-if="! submitted" class="uk-width-medium-1-3 uk-grid-width-small-1-1">
			<h2 v-if="!notAllowed" style="margin-top:30px;" class="uk-text uk-text-center">Step 2</h2>
			<div v-if="!notAllowed" class="uk-grid">
				<div id="scrollable-dropdown-menu" style="margin-top:30px;"class="uk-panel uk-panel-header uk-panel-box uk-width-1-1 uk-container-center">
					<div class="uk-panel-title">Select a reviewer</div>
					<p class="uk-text-muted">Note that once you select a reviewer, you will not be able to change it. 
						Please contact <a href="mailto:scientific@ersnet.org" target="_blank">scientific@ersnet.org</a> 
						if you want to change the selected reviewers list.
					</p>
					<form method="POST" v-on="submit: onSubmitForm" class="uk-form">

						<div class="uk-form-row">
							<label for="title">Title:</label>
							<select id="title" name="title" v-model="newReviewer.title" class="uk-form-large uk-width-1-1">
								<option value=""></option>
								<option value="Ms.">Ms.</option>
								<option value="Mr.">Mr.</option>
								<option value="Dr.">Dr.</option>
								<option value="Prof.">Prof.</option>
								<option value="Prof. Dr.">Prof. Dr.</option>
							</select>
						</div>

						<div class="uk-form-row">
							<label for="last_name">Last Name:</label>
							<input 
							type="text" id="last_name" name="last_name" 
							class="uk-form-large uk-width-1-1" 
							v-model="newReviewer.last_name"
							v-validate="required, minLength: 3,"
							v-class="uk-form-danger : validation.newReviewer.last_name.invalid && validation.newReviewer.last_name.dirty"
							>
						</div>
						<!-- Text Field -->         
						<div class="uk-form-row">
							<label for="first_name">First Name:</label>
							<input type="text" id="first_name" name="first_name" 
							class="uk-form-large uk-width-1-1" 
							v-model="newReviewer.first_name"
							v-validate="required, minLength: 3,"
							v-class="uk-form-danger : validation.newReviewer.first_name.invalid && validation.newReviewer.first_name.dirty"
							>
						</div>
						<!-- Text Field -->         
						<div class="uk-form-row">
							<label for="email">Email:</label>
							<input type="text" id="email" name="email" 
							class="uk-form-large uk-width-1-1" 
							v-model="newReviewer.email" 
							v-validate="required, email, minLength: 3,"
							v-class="uk-form-danger : validation.newReviewer.email.invalid && validation.newReviewer.email.dirty"
							>
						</div>
						<!-- Submit Button -->      
						<div v-if="! submitted" class="uk-form-row">
							<button 
							type="submit" value="Suggest" 
							class="uk-form-large uk-button uk-button-large uk-width-1-1"
							v-if="invalid"
							disabled
							>Select</button>
							<button 
							type="submit" value="Suggest" 
							class="uk-form-large uk-button uk-button-large uk-width-1-1"
							v-if="valid"
							>Select</button>
						</div>  
						<ul class="uk-list uk-text-danger">
							<li v-if="validation.newReviewer.last_name.invalid && validation.newReviewer.last_name.dirty">
								The last name is required and must be more than 3 charachters long
							</li>
							<li v-if="validation.newReviewer.first_name.invalid && validation.newReviewer.first_name.dirty">
								The first name is required and must be more than 3 charachters long
							</li>
							<li v-if="validation.newReviewer.email.invalid && validation.newReviewer.email.dirty">
								The email is required and must be more than 3 charachters long and be a valid email address
							</li>
						</ul>              
					</form>
				</div>
			</div>
		</div>
		<div v-if="!notAllowed" class="uk-width-medium-1-3 uk-grid-width-small-1-1">
				<h2 v-if="! submitted" style="margin-top:30px;" class="uk-text uk-text-center">Step 3</h2>
				<div class="uk-grid">
					<div style="margin-top:30px;"class="uk-panel uk-panel-header uk-panel-box uk-width-1-1 uk-container-center">
						<div class="uk-panel-title">Selected reviewers</div>
						<div class="uk-alert uk-alert-success uk-animation-scale-up" v-if="submitted">
							<p>Thank you for your help, you have selected all the reviewers you could.</p>
						</div>
						<div class="uk-alert uk-alert-success uk-animation-scale-up" v-if="message">
							<p>@{{ message }}</p>
						</div>
						<div class="uk-alert uk-alert-danger uk-animation-scale-up" v-if="error">
							<p>@{{ error }}</p>
						</div>

						<div class=" uk-text uk-text-muted uk-alert uk-alert-info uk-animation-scale-up" v-if="self">
							<p>As chair of a group, you have automatically been added as a reviewer of this group</p>
							<h3 class="uk-title" style="margin:0;" v-repeat="self">
										@{{ title }} @{{ first_name }} @{{ last_name }}
							</h3>	
						</div>
						<ul class="uk-list">
							<li class="uk-animation-scale-up"
							v-repeat="reviewers"
							>
								<h3 class="uk-title" style="margin:0;">
										@{{ title }} @{{ first_name }} @{{ last_name }}
								</h3>		
								<span class="uk-text uk-article-meta" style="margin:0;">@{{ email }}</span>
								
							</li>
						</ul>
						
					</div>
				</div>

		</div>
	</div>
</div>
</div>



@endsection