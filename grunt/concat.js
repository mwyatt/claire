module.exports = {
  front: {
    options: {
      separator: ';'
    },
    src: [
      'js/vendor/*.js',
      'js/global/*.js',
      'js/*.js',
      '!js/vendor/respond.js',
      '!js/vendor/modernizr-*',
      '!js/*.min.js'
    ],
    dest: 'asset/main.min.js'
  },
  admin: {
    options: {
      separator: ';'
    },
    src: [
      'js/vendor/*.js',
      'js/global/*.js',
      'js/admin/*.js',
      'js/admin/vendor/*.js',
      'js/admin/vendor/*/*.js'
    ],
    dest: 'asset/admin/main.min.js'
  },
  ebay: {
    options: {
      separator: ';'
    },
    src: [
      'js/ebay/*.js'
    ],
    dest: 'asset/ebay/main.min.js'
  }
};
