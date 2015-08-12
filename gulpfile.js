var pkg = require('./package.json');
var gulp = require('gulp');
var gulpPlugin = require('gulp-load-plugins')();
var autoprefixer = require('autoprefixer-core');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var eventStream = require('event-stream');
var glob = require('glob');
var runSequence = require('run-sequence');
 
gulp.task('jscs-check', function () {
  return gulp.src('js/common.bundle.js')
    .pipe(gulpPlugin.jscs({
      "preset": "google"
    }));
});

gulp.task('csscomb', function() {
  return gulp.src('app/site/codex/css/_alert.css')
    .pipe(gulpPlugin.csscomb())
    .pipe(gulp.dest('done-it/'));
});


// js
var actionJs = {
  postcss: function(src) {
    return gulp.src(src)
      .pipe(gulpPlugin.postcss(processes))
      .pipe(gulp.dest('asset'));
  }
};

// css
var minmax = require('postcss-media-minmax');
var colorFunction = require('postcss-color-function');
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
var processes = [
  require('postcss-import'),
  require('postcss-mixins'),
  require('postcss-simple-vars'),
  minmax(),
  colorFunction(),
  autoprefixer({browsers: ['last 1 version']})
];

gulp.task('default', function() {
  runSequence(
    'css',
    'js'
  );
});

gulp.task('clean/asset', function () {  
  return gulp.src(['asset'], {read: false})
    .pipe(gulpPlugin.clean());
});

gulp.task('clean/temporary', function () {  
  return gulp.src(['temporary'], {read: false})
    .pipe(gulpPlugin.clean());
});

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
    .pipe(gulpPlugin.postcss(processes))
    .pipe(gulp.dest('asset'));
});

gulp.task('css/front', function () {
  return gulp.src(cssfront)
    .pipe(gulpPlugin.postcss(processes))
    .pipe(gulp.dest('asset'));
});

gulp.task('css/admin', function () {
  return gulp.src(cssadmin)
    .pipe(gulpPlugin.postcss(processes))
    .pipe(gulp.dest('asset/admin'));
});

gulp.task('css/admin/minify', function () {
  processes.push(require('csswring'));
  return gulp.src(cssadmin)
  .pipe(gulpPlugin.postcss(processes))
    .pipe(gulp.dest('asset/admin'));
});

gulp.task('css/min', function () {
  processes.push(require('csswring'));
  return gulp.src(cssfront)
    .pipe(gulpPlugin.postcss(processes))
    .pipe(gulp.dest('asset'));
});

gulp.task('min', function() {
  runSequence(
    'css/min',
    'js/min'
  );
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

gulp.task('js/copy/vendor', function() {
  gulp.src('bower_components/modernizr/modernizr.js')
    .pipe(gulp.dest('asset/vendor/'));
  gulp.src('bower_components/jquery/dist/jquery.min.js')
    .pipe(gulp.dest('asset/vendor'));
  gulp.src('bower_components/magnific-popup/dist/jquery.magnific-popup.min.js')
    .pipe(gulp.dest('asset/vendor'));
  gulp.src('bower_components/tinymce/**')
    .pipe(gulp.dest('asset/vendor/tinymce'));
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
    .pipe(gulpPlugin.uglify())
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
    eventStream.merge(tasks).on('end', done);
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

gulp.task('image/copy', function () {
  return gulp.src('app/site/' + pkg.site + '/media/**')
    .pipe(gulp.dest('asset'));
});
