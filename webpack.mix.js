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
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.browserSync({
  browser: "google chrome",
  proxy: {
    target: 'http://lv55trial.dev'
  },
  files: [
    {
      match: [
            "./**/*.php",
            "./public/js/*.js",
            "./public/css/*.css"
        ]
    }
  ]
});

mix.disableNotifications();
