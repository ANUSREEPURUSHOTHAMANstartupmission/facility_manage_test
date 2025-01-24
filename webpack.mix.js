const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/tabler/tabler.js', 'public/js')
  .js('resources/js/public/nav.js', 'public/js')
  .js('resources/js/public/main.js', 'public/js')
  .js('resources/js/public/facility.js', 'public/js')
  // .sass('resources/scss/tabler/tabler.scss', 'public/css')
  .sass('resources/scss/public/main.scss', 'public/css')
  .sass('resources/scss/public/navbar.scss', 'public/css')
  .sass('resources/scss/public/home.scss', 'public/css')
  .sass('resources/scss/public/facility.scss', 'public/css')
  .browserSync('localhost');