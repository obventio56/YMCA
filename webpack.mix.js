let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/jquery-1.8.0.min.js', 'public/js')
   .js('resources/assets/js/jquery-ui-1.8.23.custom.min.js', 'public/js')
   .js('resources/assets/js/jquery.timepicker.js', 'public/js')
   .js('resources/assets/js/lib/base.js', 'public/js')
   .js('resources/assets/js/jquery.datepicker.js', 'public/js')