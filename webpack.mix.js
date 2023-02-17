const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/js/app.js', 'public/js')
 .sass('resources/sass/app.scss', 'public/css');
  mix.styles([
 	'resources/css/bootstrap.min.css',	 
 	'resources/css/now-ui-dashboard.css',	 	
 	'resources/demo/demo.css'
 	],'public/css/libs.css');


 mix.scripts([	
 	'resources/js/now-ui-dashboard.js',	 	
 	'resources/js/core/jquery.min.js',
 	'resources/js/core/popper.min.js',
 	'resources/js/core/bootstrap.min.js', 	
 	'resources/js/plugins/chartjs.min.js',
 	'resources/js/plugins/bootstrap-notify.js',
 	'resources/js/now-ui-dashboard.min.js',
 	'resources/demo/demo.js'
 	], 'public/js/libs.js');


