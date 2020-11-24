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

const CompressionPlugin = mix.config.production ? require('compression-webpack-plugin') : null;
mix.webpackConfig({
    resolve: {
        alias: {
            "@": __dirname + "/resources/js",
            "jQuery": "jquery"
        }
    }
});

if(mix.config.production){
    mix.webpackConfig({
        plugins: [
            new CompressionPlugin({
                filename: '[path].gz[query]',
                algorithm: 'gzip', // all browsers support this algo
                test: /\.js$|\.css$/,
                threshold: 10240,
                minRatio: 0.8,
            }),
        ],
    });
}

mix
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/welcome.js', 'public/js')
    .js('resources/js/setup-inventory.js', 'public/js')
    .js('resources/js/public-quotation.js', 'public/js')
    .js('resources/js/public-invoice.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/buefy.scss', 'public/css')
    .postCss('resources/css/tailwind.css', 'public/css', [
        require('tailwindcss'),
    ]);
