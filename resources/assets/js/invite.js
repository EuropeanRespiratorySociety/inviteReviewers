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

		reviewers: {},
		search: {
			last_name:'',
			first_name:''
		},

		quantity: {},

		submitted: false,

	},

	ready: function(){

		this.fetchInvitedReviewers();
 
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
				  			+ ersContacts.title + ' '  
				  			+ ersContacts.first_name + ' ' 
				  			+ ersContacts.last_name + 
				  			'</h3><h4>'
				  			+ ersContacts.email +
				  			'</h4><p class="uk-text-muted "><i class="uk-icon-map-marker"></i> ' 
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
				this.search = suggestion.first_name + ' ' + suggestion.last_name
				this.newReviewer.title = suggestion.title;
				this.newReviewer.last_name = suggestion.last_name;
				this.newReviewer.first_name = suggestion.first_name;
				this.newReviewer.email = suggestion.email;
				this.newReviewer.ers_id = suggestion.ers_id;

			}
			.bind(this));

	},

	methods: {
		fetchInvitedReviewers: function() {
			this.$http.get('api', function(response) {
				this.$set('reviewers', response.reviewers);
				this.$set('quantity', response.quantity); 
			});
		},

		onSubmitForm: function(e){
			e.preventDefault();
			
			var reviewer = this.newReviewer;
			
			//add new reviewer to reviewers array
			this.reviewers.push(reviewer);
			
			//reset input values
			this.newReviewer = {title:'', last_name: '', first_name: '', email:'', ers_id:'null'}
			this.search = { last_name: '', first_name: ''};
			
			//substract one to the quantity
			this.quantity -= 1 ;
			
			//sent post ajax request
			//this.$http.post('api/store', reviewer)

			//show success and count how many left
			if(this.quantity <= 0) {
			this.submitted = true;
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

