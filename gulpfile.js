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

elixir(function (mix) {
    mix.publish(
        'jquery/dist/jquery.min.js',
        'public/js/vendor/jquery.js'
    )
        .publish(
        'bootstrap/dist/js/bootstrap.min.js',
        'public/js/vendor/bootstrap.js'
    )
        .scripts(
        [
            'public/js/vendor/jquery.js',
            'public/js/vendor/bootstrap.js'
        ]
    )
        // CSS
        .publish(
        'select2/select2.css',
        'public/css/vendor/select2/select2.css'
    )
        .publish(
        'select2-bootstrap3-css/select2-bootstrap.css',
        'public/css/vendor/select2/select2-bootstrap.css'
    )
        .publish(
        'messenger/build/css/messenger.css',
        'public/css/vendor/messenger.css'
    )
        .publish(
        'messenger/build/css/messenger-theme-future.css',
        'public/css/vendor/messenger-theme-future.css'
    )
        .publish(
        'nukacode-admin/css/admin.css',
        'public/css/vendor/nukacode-admin/css/admin.css'
    )
        .styles(
        [
            'public/css/app.css',
            'public/css/vendor/font-awesome.css',
            'public/css/vendor/messenger.css',
            'public/css/vendor/messenger-theme-future.css',
        ]
    )
        .styles(
        [
            'public/css/vendor/nukacode-admin/css/admin.css',
            'public/css/vendor/font-awesome.css',
            'public/css/vendor/messenger.css',
            'public/css/vendor/messenger-theme-future.css',
        ], 'public/', 'public/css/admin'
    )
        // Extras
        .publish(
        'font-awesome/fonts',
        'public/fonts'
    );
});
