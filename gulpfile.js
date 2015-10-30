var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
   /* mix.sass('erskit.scss');

    mix.styles([
        "custom.css",
        "fonts.css"
    ]);

    mix.stylesIn("public/css");

    mix.copy('resources/vendor/fonts/DINpro', 'public/fonts/DINpro')
    .copy('resources/vendor/uikit/fonts', 'public/fonts/fontawesome');*/

    mix.styles([
    		'uikit.css',
    		'theme.css',
    		'custom.css'
    	]);

    mix.browserify('invite.js');

    mix.scripts([
    		'jquery.js',
    		'uikit.js',
    		'erskit.js',
    		'typeahead.js'
    	]);


});


