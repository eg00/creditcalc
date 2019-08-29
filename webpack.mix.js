let mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/')
    .postCss('resources/css/app.css', 'public/', [
        require('tailwindcss'),
    ])
    .purgeCss();
mix.extract(['vue', 'axios']);
