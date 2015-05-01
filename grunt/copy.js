module.exports = {
  dist: {
    files: [
      {
        expand: true,
        cwd: 'vendor/bower/mustache/',
        src: 'mustache.js',
        dest: 'js/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/requirejs/',
        src: 'require.js',
        dest: 'js/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/modernizr/',
        src: 'modernizr.js',
        dest: 'asset/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/bourbon/app/assets/stylesheets',
        src: '**',
        dest: 'sass/vendor/bourbon/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/tinymce/',
        src: '**',
        dest: 'asset/vendor/tinymce/'
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
        cwd: 'vendor/bower/magnific-popup/dist/',
        src: 'jquery.magnific-popup.js',
        dest: 'js/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/jquery-serialize-object/dist/',
        src: '**',
        dest: 'js/vendor/'
      },
      {
        expand: true,
        cwd: 'vendor/bower/owlcarousel/owl-carousel/',
        src: 'owl.carousel.js',
        dest: 'js/vendor/'
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
      },
      {
        expand: true,
        cwd: 'vendor/bower/jquery/dist/',
        src: 'jquery.js',
        dest: 'asset/vendor/'
      }
    ]
  }
};
