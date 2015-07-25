var environment = 'sandbox';
var gulp = require('gulp');
var clean = require('gulp-clean');
var uglify = require('gulp-uglify');
var pkg = require('./package.json');

gulp.task('clean/asset', function () {  
  return gulp.src(['asset'], {read: false})
    .pipe(clean());
});

gulp.task('clean/temporary', function () {  
  return gulp.src(['temporary'], {read: false})
    .pipe(clean());
});

gulp.task('default', function() {
  runSequence(
    'css',
    'js'
  );
});

gulp.task('min', function() {
  runSequence(
    'css/min',
    'js/min'
  );
});


/**
 * css
 */
var postcss = require('gulp-postcss');
var minmax = require('postcss-media-minmax');
var autoprefixer = require('autoprefixer-core');
var cssadmin = [
  'temporary/admin/**/*.css',
  '!temporary/**/_*.css'
];
var cssfront = [
  'temporary/**/*.css',
  '!temporary/admin/**/*.css',
  '!temporary/**/_*.css'
];
var cssGlobal = [
  'temporary/**/*.css',
  '!temporary/**/_*.css'
];
var css = ['css/**/*.css'];
var colorFunction = require('postcss-color-function');
var processes = [
  require('postcss-import'),
  require('postcss-mixins'),
  require('postcss-simple-vars'),
  minmax(),
  colorFunction(),
  autoprefixer({browsers: ['last 1 version']})
];

gulp.task('css/copy/global', function() {
  return gulp.src('css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/copy/admin', function() {
  return gulp.src('app/admin/css/**/**.css')
    .pipe(gulp.dest('temporary/admin'));
});

gulp.task('css/copy/site', function() {
  return gulp.src('app/site/' + pkg.site + '/css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/copy/site/admin', function() {
  return gulp.src('app/site/' + pkg.site + '/admin/css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/copy/codex', function() {
  return gulp.src('app/site/codex/css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/global', function () {
  return gulp.src(cssGlobal)
    .pipe(postcss(processes))
    .pipe(gulp.dest('asset'));
});

gulp.task('css/front', function () {
  return gulp.src(cssfront)
    .pipe(postcss(processes))
    .pipe(gulp.dest('asset'));
});

gulp.task('css/admin', function () {
  return gulp.src(cssadmin)
    .pipe(postcss(processes))
    .pipe(gulp.dest('asset/admin'));
});

gulp.task('css/admin/minify', function () {
  processes.push(require('csswring'));
  return gulp.src(cssadmin)
  .pipe(postcss(processes))
    .pipe(gulp.dest('asset/admin'));
});

gulp.task('css/min', function () {
  processes.push(require('csswring'));
  return gulp.src(cssfront)
    .pipe(postcss(processes))
    .pipe(gulp.dest('asset'));
});

gulp.task('css', function() {
  runSequence(
    'css/copy/global',
    'css/copy/codex',
    'css/copy/admin',
    'css/copy/site',
    'css/global'
  );
});


/**
 * sass
 */
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', function () {
  if (environment == 'sandbox') {
    gulp.src('app/site/' + pkg.site + '/sass/**/**.scss')
      .pipe(sourcemaps.init())
      .pipe(sass().on('error', sass.logError))
      .pipe(autoprefixer())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest('asset'));
  } else {
    gulp.src('app/site/' + pkg.site + '/sass/**/**.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(autoprefixer())
      .pipe(gulp.dest('asset'));
  };
});


/**
 * js
 */
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var es = require('event-stream');
var glob = require('glob');
var runSequence = require('run-sequence');
var gutil = require('gulp-util');
var actionJs = {
  postcss: function(src) {
    return gulp.src(src)
      .pipe(postcss(processes))
      .pipe(gulp.dest('asset'));
  }
};

gulp.task('js/copy/vendor', function() {
  gulp.src('bower_components/modernizr/modernizr.js')
    .pipe(gulp.dest('asset/vendor/'));
  gulp.src('bower_components/jquery/dist/jquery.min.js')
    .pipe(gulp.dest('asset/vendor'));
});

gulp.task('js/copy/unsorted', function() {
  return gulp.src('js/**/**.js')
    .pipe(gulp.dest('temporary'));
});

gulp.task('js/copy/admin', function() {
  return gulp.src('app/admin/js/**/**.js')
    .pipe(gulp.dest('temporary/admin'));
});

gulp.task('js/copy/codex', function() {
  return gulp.src('app/site/codex/js/**/**.js')
    .pipe(gulp.dest('temporary'));
});

gulp.task('js/copy/site', function() {
  return gulp.src('app/site/' + pkg.site + '/js/**/**.js')
    .pipe(gulp.dest('temporary'));
});

gulp.task('js/copy/site/admin', function() {
  return gulp.src('app/site/' + pkg.site + '/admin/js/**/**.js')
    .pipe(gulp.dest('temporary/admin'));
});

gulp.task('js/min', function() {
  gulp.src('asset/**/**.js')
    .pipe(uglify())
    .pipe(gulp.dest('asset'));
});

gulp.task('js/build', function(done) {
  glob('temporary/**/**.bundle.js', function(err, files) {
    if (err) {
      done(err);
    };
    var tasks = files.map(function(entry) {
      return browserify({
        entries: [entry],
        paths: [
          'node_modules',
          'bower_components',
          'temporary'
        ]
      })
      .bundle()
      .pipe(source(entry.replace('temporary/', '').replace('.bundle', '')))
      .pipe(gulp.dest('asset'));
    });

    // create a merged stream
    es.merge(tasks).on('end', done);
  });
});

gulp.task('js', function() {
  runSequence(
    'js/copy/vendor',
    'js/copy/unsorted',
    'js/copy/admin',
    'js/copy/codex',
    'js/copy/site',
    'js/copy/site/admin',
    'js/build'
  );
});


/**
 * images and svgs
 * compress and save them in asset/
 * asset/ not stored in git repo at all
 */
gulp.task('image/copy', function () {
  return gulp.src('app/site/' + pkg.site + '/media/**')
    .pipe(gulp.dest('asset'));
});
