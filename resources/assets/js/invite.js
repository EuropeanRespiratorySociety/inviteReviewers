var Vue = require('vue')
var validator = require('vue-validator')
var resource = require('vue-resource')
//var typeahead = require('vue-typeahead')

Vue.use(validator)
Vue.use(resource)
//Vue.use(typeahead)

var token = $('#token').attr('value');
Vue.http.headers.common['X-CSRF-TOKEN'] = token;


new Vue({
	el:'#invite',

	data: {
		newReviewer: {
			title:'',
			last_name:'',
			first_name:'',
			email:'',
			ers_id:'null'
		},

		reviewers: [],
		self: [],
		search: {
			last_name:'',
			first_name:''
		},

		quantity: 0,
		notAllowed: false,
		error: null,
		message: null,

		submitted: false

	},

	ready: function(){

		this.fetchInvitedReviewers();


		/*
		todo it breaks the search...
		if(!this.quantity === true && !submitted) {
				this.$set('notAllowed', true)
			}
		*/	

    var ersContacts = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: 'api/search/%QUERY',
				wildcard: '%QUERY'
			}
		});

		$('#search')
			.typeahead({
				minLength: 2,
  				highlight: true,
  				hint: true
			}, 
			{
			  	displayKey: 'last_name',
			  	templates: {
			  		suggestion: function(ersContacts) {
			  			return (
			  			'<div class="uk-text">' +
				  			'<h3 class="uk-title">' 
				  			+ ersContacts.first_name + ' ' 
				  			+ ersContacts.last_name + 
								'</h3>'
								// +'<h4>'
				  			// + ersContacts.email +
								// '</h4>'
								+ '<p class="uk-text-muted "><i class="uk-icon-map-marker"></i> ' 
				  			+ ersContacts.city + ' | ' 
				  			+ ersContacts.country 
				  			+ '</p>' +
				  		'</div>'

			  			)
			  		}
			  	},
			  	source: ersContacts
			})
			.on('typeahead:select', function(e, suggestion){
				this.fetchNewReviewer(suggestion);
			}
			.bind(this));

	},

	methods: {
		fetchInvitedReviewers: function() {
			this.$http.get('api', function(response) {
			this.$set('reviewers', response.reviewers);
			this.$set('quantity', response.quantity);
			//we add the user as one of the rievewers
			this.$set('self', response.self);	

			if(response.quantity <= 0){
				this.submitted = true;
			}

			});
		},

		fetchNewReviewer: function(s) {
			this.$http.get('api/contact/' + s.ers_id , function(response) {
				this.search = response.first_name + ' ' + response.last_name
				this.newReviewer.title = response.title;
				this.newReviewer.last_name = response.last_name;
				this.newReviewer.first_name = response.first_name;
				this.newReviewer.email = response.email;
				this.newReviewer.ers_id = response.ers_id;	
			});	
		},

		onSubmitForm: function(e){
			e.preventDefault();
			this.error = null;
			this.message = null;
			var reviewer = this.newReviewer;
			
			//reset input values
			this.newReviewer = {title:'', last_name: '', first_name: '', email:'', ers_id:'null'}
			this.search = { last_name: '', first_name: ''};
			
			
			//sent post ajax request
			if(!this.quantity <= 0) {
				this.$http.post(
					'api/store', 
					reviewer,
					function(success){
						this.$set('reviewer', success.reviewer);
						this.$set('message', success.message);
						//add new reviewer to reviewers array
						this.reviewers.unshift(reviewer);
						//substract one to the quantity
						this.quantity -= 1 ;
						//show success and count how many left
						if(this.quantity <= 0) {
						this.submitted = true;
						}

					}).error(function(data){
						this.$set('error', data.message);
					})
			}




		}
		
	},

	validator: {
    		validates: {
      			email: function (val) {
        		return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(val)
      			}
      		}	
    }
  	

});

