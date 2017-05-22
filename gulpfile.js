var gulp = require('gulp');
var minifyHtml = require('gulp-minify-html');
var angularTemplateCache = require('gulp-angular-templatecache');


gulp.task('templates', function() {

  return cacheTemplates('template/**/*.html', 'app.template.js');

  function cacheTemplates(input, output) {
    return gulp.src(input) // Get all HTML files
      .pipe(minifyHtml({ // Minify HTML content first
        empty: true,
        spare: true,
        quotes: true
      }))
      .pipe(angularTemplateCache(output, { // Save minified strings to cache
        module: 'myApp' // Setup $templateCache for Angular module 'myApp'
      }))
      .pipe(gulp.dest('.tmp/templates/'));

  } // /function cacheTemplates

});

gulp.task('default', [ 'templates' ]);