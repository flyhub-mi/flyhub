const mix = require('laravel-mix');
const s3Plugin = require('webpack-s3-plugin');
const tailwindcss = require('tailwindcss');

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

let webpackPlugins = [];
if (mix.inProduction() && process.env.UPLOAD_S3) {
    webpackPlugins = [
        new s3Plugin({
            exclude: /.*\.(htaccess)$/,
            s3Options: {
                accessKeyId: process.env.AWS_ACCESS_KEY_ID,
                secretAccessKey: process.env.AWS_SECRET_ACCESS_KEY,
                region: process.env.AWS_CDN_DEFAULT_REGION,
            },
            s3UploadOptions: {
                Bucket: process.env.AWS_CDN_BUCKET,
                CacheControl: 'public, max-age=31536000',
            },
            directory: 'public',
        }),
    ];
}

/** Tenant */
mix.react('resources/js/tenant/app.js', 'public/js/tenant');
mix.sass('resources/sass/tenant/app.scss', 'public/css/tenant');
mix.react('resources/js/auth.js', 'public/js');
mix.sass('resources/sass/auth.scss', 'public/css');

/** Home */
mix.react('resources/js/home/main.jsx', 'public/js');

/** Tailwind */
mix.sass('resources/sass/home/style.scss', 'public/css').options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
});

/** Public Assets */
mix.copy('resources/assets', 'public');

mix.webpackConfig({
    plugins: webpackPlugins,
});

if (mix.inProduction()) {
    mix.version();
}
