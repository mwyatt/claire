module.exports = {
  dist: {
    files: [
      {
        expand: true,
        cwd: 'vendor/bower/bourbon/dist',
        src: '**',
        dest: 'sass/vendor/bourbon'
      },
      {
        expand: true,
        cwd: 'vendor/bower/magnific-popup/dist/',
        src: 'magnific-popup.css',
        dest: 'sass/vendor/magnific-popup/',
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
        cwd: 'vendor/bower/mustache',
        src: 'mustache.js',
        dest: 'js/admin/vendor/mustache'
      },
      {
        expand: true,
        cwd: 'vendor/bower/normalize-scss/',
        src: '*.scss',
        dest: 'sass/vendor/normalize/'
      }
    ]
  }
};
