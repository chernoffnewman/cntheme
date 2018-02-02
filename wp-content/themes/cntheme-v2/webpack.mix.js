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

mix.js('components/js/site.js', 'assets/js')
    .sass('components/scss/style.scss', 'assets/css',{
        includePaths: ["./node_modules/bootstrap/scss"]
    }).options({
        processCssUrls: false
     });