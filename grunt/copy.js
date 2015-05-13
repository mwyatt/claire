module.exports = {
  plugin: {
    files: [
      {
        expand: true,
        cwd: 'vendor/bower/modernizr/',
        src: 'modernizr.js',
        dest: 'asset/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/tinymce/',
        src: '**',
        dest: 'asset/vendor/tinymce/'
      }
    ]
  },
  js: {
    files: [
      {
        expand: true,
        cwd: 'vendor/bower/rainbow/js/',
        src: 'rainbow.min.js',
        dest: 'asset/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/rainbow/js/language/',
        src: '**',
        dest: 'asset/vendor/rainbow/language/'
      }
    ]
  },
  sass: {
    files: [
      {
        expand: true,
        cwd: 'vendor/bower/rainbow/themes/',
        src: '**',
        dest: 'asset/vendor/rainbow/theme/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/bourbon/app/assets/stylesheets',
        src: '**',
        dest: 'sass/vendor/bourbon/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/magnific-popup/dist/',
        src: 'magnific-popup.css',
        dest: 'sass/vendor/',
        rename: function(dest, src) {
          return dest + '_' + src.replace('.css','.scss');
        }
      },
      {
        expand: true,
        cwd: 'vendor/bower/owlcarousel/owl-carousel/',
        src: '*.css',
        dest: 'sass/vendor/owl-carousel/',
        rename: function(dest, src) {
          return dest + '_' + src.replace('.css','.scss');
        }
      },
      {
        expand: true,
        cwd: 'vendor/bower/normalize-scss',
        src: '*.scss',
        dest: 'sass/vendor/'
      }
    ]
  }
};
