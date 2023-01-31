const mix = require('laravel-mix');

mix.sass('resources/sass/main.scss', 'css/style.css')
    .minify('css/style.css')
   

