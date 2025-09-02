const mix = require('laravel-mix');

mix.js('src/js/app.js', 'js')
   .postCss('src/css/app.css', 'css', [
      require('postcss-import'),
      require('tailwindcss'),
      require('autoprefixer'),
   ])
   .options({
      processCssUrls: false
   })
   .copyDirectory('src/fonts', 'fonts')
   .copyDirectory('src/images', 'images')
   .browserSync({
      proxy: 'localhost',
      open: false,
      files: [
         '**/*.php',
         'templates/**/*.html',
         'parts/**/*.html',
         'patterns/**/*.html',
         'js/**/*.js',
         'css/**/*.css'
      ]
   });

// Production settings
if (mix.inProduction()) {
   mix.version();
}
