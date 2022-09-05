// webpack.mix.js
let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.sass('resources/css/megaphone.scss', 'public/css')
.options({
  processCssUrls: false,
  postCss: [ tailwindcss('./tailwind.config.js') ],
})
