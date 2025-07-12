const mix = require('laravel-mix');

// jQuery (sao chép thư mục 'dist')
mix.copyDirectory('node_modules/jquery/dist', 'public/vendor/jquery');

// Bootstrap (sao chép thư mục 'dist' - bao gồm CSS và JS bundle với Popper.js)
mix.copyDirectory('node_modules/bootstrap/dist', 'public/vendor/bootstrap');

// SweetAlert2 (sao chép thư mục 'dist')
mix.copyDirectory('node_modules/sweetalert2/dist', 'public/vendor/sweetalert2');

// Font Awesome (sao chép thư mục 'css' và 'webfonts')
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/css', 'public/vendor/fontawesome/css');
mix.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/vendor/fontawesome/webfonts');
// webpack.mix.cjs
mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
       require('autoprefixer'),
   ]);
