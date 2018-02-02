let mix = require('laravel-mix');
var ModernizrWebpackPlugin = require('modernizr-webpack-plugin');

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

//Modernizr - Only choose what we need
var config = {
    'feature-detects': [
        //"geolocation",
        //"input",
        // "svg",
        // "touchevents",
        // "video",
        "css/animations",
        //"css/flexbox",
        //"css/flexboxlegacy",
        //"css/flexboxtweener",
        //"css/flexwrap",
        // "csspositionsticky",
        // "cssremunit",
        // "csstransforms",
        // "csstransforms3d",
        // "preserve3d",
        // "csstransitions",
        // "cssvhunit",
        // "cssvmaxunit",
        // "cssvminunit",
        // "cssvwunit",
        // "localstorage",
        // "sessionstorage",
        //"svg",
        //"svg/asimg",
    ]
}

mix.webpackConfig({

    //Modernizr
    resolve: {
        modules: [
            path.resolve(__dirname, './node_modules/modernizr/')
        ]
    },
    plugins: [
        new ModernizrWebpackPlugin(config)
    ]
})

//Head
mix.scripts([
        'modernizr-bundle.js',
    ], 'assets/js/head.js')

    //Foot
    .scripts([
        'components/js/site.js',
    ], 'assets/js/foot.js')

    //Sass
    .sass('components/scss/style.scss', 'assets/css',{
        includePaths: ["./node_modules/bootstrap/scss"]
    }).options({
        processCssUrls: false
     });