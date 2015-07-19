

/**
 * global
 */
var gulp = require('gulp');
var clean = require('gulp-clean');
var uglify = require('gulp-uglify');
var pkg = require('./package.json');
var dest = 'asset';
var action = {
  copy: function(src, dest) {
    return gulp.src(src)
      .pipe(gulp.dest(dest));
  }
};

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
var actionCss = {
  postcss: function(src) {
    return gulp.src(src)
      .pipe(postcss(processes))
      .pipe(gulp.dest(dest));
  }
};

gulp.task('css/copy/admin', function() {
  return gulp.src('app/admin/css/**/**.css')
    .pipe(gulp.dest('temporary/admin'));
});

gulp.task('css/copy/site', function() {
  return gulp.src('app/site/' + pkg.name + '/css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/copy/site/admin', function() {
  return gulp.src('app/site/' + pkg.name + '/admin/css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/copy/codex', function() {
  return gulp.src('app/site/codex/css/**/**.css')
    .pipe(gulp.dest('temporary'));
});

gulp.task('css/global', function () {
  return actionCss.postcss('temporary/**/**.css');
});

gulp.task('css/front', function () {
  return actionCss.postcss(cssfront);
});

gulp.task('css/admin', function () {
  return gulp.src(cssadmin)
    .pipe(postcss(processes))
    .pipe(gulp.dest('asset/admin'));
});

gulp.task('css/admin/minify', function () {
  dest = 'asset/admin';
  processes.push(require('csswring'));
  return actionCss.postcss(cssadmin);
});

gulp.task('css/minify', function () {
  processes.push(require('csswring'));
  return actionCss.postcss(cssfront);
});

gulp.task('css/uglify', function() {
  gulp.src('asset/**/**.css')
    .pipe(uglify())
    .pipe(gulp.dest('asset'));
});

gulp.task('css', function() {
  runSequence(
    'css/copy/codex',
    'css/copy/admin',
    'css/copy/site',
    'css/global',
    'clean/temporary'
  );
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
      .pipe(gulp.dest(dest));
  }
};

gulp.task('js/copy/admin', function() {
  return gulp.src('app/admin/js/**/**.js')
    .pipe(gulp.dest('temporary/admin'));
});

gulp.task('js/copy/site', function() {
  return gulp.src('app/site/' + pkg.name + '/js/**/**.js')
    .pipe(gulp.dest('temporary'));
});

gulp.task('js/copy/codex', function() {
  return gulp.src('app/site/codex/js/**/**.js')
    .pipe(gulp.dest('temporary'));
});

gulp.task('js/uglify', function() {
  gulp.src('asset/**/**.js')
    .pipe(uglify())
    .pipe(gulp.dest('asset'));
});

gulp.task('js/browserify', function(done) {
  glob('temporary/**/**.bundle.js', function(err, files) {
    if (err) {
      done(err);
    };
    var tasks = files.map(function(entry) {
      return browserify({
        entries: [entry],
        paths: ['node_modules', 'temporary']
      })
      .bundle()
      .pipe(source(entry.replace('temporary/', '')))
      .pipe(gulp.dest('asset'));
    });

    // create a merged stream
    es.merge(tasks).on('end', done);
  });
});

gulp.task('js', function() {
  runSequence(
    'clean/asset',
    'clean/temporary',
    'js/copy/codex',
    'js/copy/admin',
    'js/copy/site',
    'js/browserify',
    'clean/temporary'
  );
});




/**
 * js
 */
// var browserify = require('gulp-browserify');


// gulp.task('js', function() {
//   gulp.src('app/site/' + pkg.site + '/js/common.js')
//     .pipe(browserify({
//       insertGlobals : true,
//       paths: ['node_modules', 'js/', 'app/site/' + pkg.site + '/js/**/*.js']
//     }))
//     .pipe(gulp.dest('asset'));
// });

// var shimSettings = {
//   jquery: {
//     path: 'vendor/bower/jquery/dist/jquery.js',
//     exports: '$'
//   }
// };

// gulp.task('js/a', function() {
//   gulp.src('js/admin/common.js')
//     .pipe(browserify({
//       paths: ['node_modules', 'js/'],
//       shim: shimSettings
//     }))
//     .pipe(gulp.dest('asset/admin'));
//   gulp.src('js/admin/user/single.js')
//     .pipe(browserify({
//       paths: ['node_modules', 'js/'],
//       shim: shimSettings
//     }))
//     .pipe(gulp.dest('asset/admin/user'));
// });

// // how do i make this good?
// gulp.task('js/a/tennis', function() {
//   gulp.src('app/site/elttl/js/admin/tennis/common.js')
//     .pipe(browserify({
//       paths: ['node_modules', 'js/', 'app/site/elttl/js/admin/tennis/common.js']
//     }))
//     .pipe(gulp.dest('asset/admin/tennis'));
// });

// // this will get out of control
// gulp.task('js/a/tennis/fixture/single', function() {
//   gulp.src('app/site/elttl/js/admin/tennis/fixture/single.js')
//     .pipe(browserify({
//       paths: ['node_modules', 'js/']
//     }))
//     .pipe(gulp.dest('asset/admin/tennis/fixture'));
// });