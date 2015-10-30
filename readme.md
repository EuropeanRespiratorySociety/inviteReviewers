# ERS Reviewers Invitation App

The app is designed to let an ERS chair who has an account in myERS to login with the myERS credentials. He comes to a dashboard where he sees how many reviewers he needs to invite (or suggest to invite). He can search our database to see if the person he wants to invite is already known by the ERS. If he selects a person (mouse or enter) the form is prefilled for him. He just need to hit the "invite/suggest" button in order to validate his choice. He has no way back. 

## Administration

There are two tables `permissions` and `all_ers_contacts` that need to be managed. 

The `permissions` tables uses the ers_id of the chair and an integer for the amount of invite he needs to send. 

The `all_ers_contacts` is a simplefied version of our all contacts list where we use the `ers_id`, `last_name`, `first_name`, `city`, `country`, `title`, and `email`.

You can import a permission file and you need to split in many files the contact list as for now it is poorly handeled.

There are two routes to import the files !! do not go on the all contacts without a reason !! as it will blow the server. 

* /importpermissions
* /importallcontacts

There is a controller that handle the upload: App/Http/Controllers/Import.php there you can change the file names.

## To do

- [ ] fix the import
- [ ] create an export


### Official Documentations

* Documentation for the Laravel framework can be found on the [Laravel website](http://laravel.com/docs).
* Documentation for the [Excel import/export](www.maatwebsite.nl/laravel-excel/)
* Documentation for [Vue](http://vuejs.org/guide/).
* Documentation for [Vue ressource](https://github.com/vuejs/vue-resource).
* Documentation for [Vue validator](https://github.com/vuejs/vue-validator).
* Documentation for [Typeahead](https://github.com/twitter/typeahead.js).

