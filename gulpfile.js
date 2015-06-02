var gulp = require('gulp');
var browserify = require('gulp-browserify');
var pkg = require('./package.json');
var postcss = require('gulp-postcss');
var minmax = require('postcss-media-minmax');
var autoprefixer = require('autoprefixer-core');
var cssadmin = ['app/admin/css/**/*.css', '!app/admin/css/**/_*.css'];
var cssfront = ['app/site/' + pkg.site + '/css/**/*.css', '!app/site/' + pkg.site + '/css/**/_*.css'];
var colorFunction = require('postcss-color-function');
var processes = [
  require('postcss-import'),
  require('postcss-mixins'),
  require('postcss-simple-vars'),
  minmax(),
  colorFunction(),
  autoprefixer({browsers: ['last 1 version']})
];
var cssDest = 'asset';

var action = {
  postcss: function(src) {
    return gulp.src(src)
      .pipe(postcss(processes))
      .pipe(gulp.dest(cssDest));
  }
}

gulp.task('css', function () {
  return action.postcss(cssfront);
});

gulp.task('cssa', function () {
  cssDest = 'asset/admin';
  return action.postcss(cssadmin);
});

gulp.task('cssam', function () {
  cssDest = 'asset/admin';
  processes.push(require('csswring'));
  return action.postcss(cssadmin);
});

gulp.task('cssm', function () {
  processes.push(require('csswring'));
  return action.postcss(cssfront);
});
 
gulp.task('js', function() {
  gulp.src('app/site/' + pkg.site + '/js/common.js')
    .pipe(browserify({
      paths: ['node_modules','js/']
    }))
    .pipe(gulp.dest('asset'));
});

gulp.task('jsa', function() {
  gulp.src('js/admin/common.js')
    .pipe(browserify({
      paths: ['node_modules','js/']
    }))
    .pipe(gulp.dest('asset/admin'));
});

// gulp.task('jsm', function() {
//   return gulp.src('asset/**/*.js')
//     .pipe(require('gulp-uglify'))
//     .pipe(gulp.dest('asset'));
// });

// gulp.task('imagemin', function () {
//   return gulp.src('media/*')
//     .pipe(imagemin())
//     .pipe(gulp.dest('asset'));
// });
