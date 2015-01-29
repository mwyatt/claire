module.exports = {
  front: {
    files: [{
      expand: true,
      cwd: 'sass',
      src: ['*.scss'],
      dest: 'asset',
      ext: '.css'
    }],
    options: {
      imagePath: '../image/<%= package.name %>',
      sourceComments: 'normal',
      outputStyle: 'nested'
    }
  },
  admin: {
    files: [{
      expand: true,
      cwd: 'sass/admin',
      src: ['*.scss'],
      dest: 'asset/admin',
      ext: '.css'
    }],
    options: {
      imagePath: '../image/<%= package.name %>',
      sourceComments: 'normal',
      outputStyle: 'nested'
    }
  },
  minifyFront: {
    files: [{
      expand: true,
      cwd: 'sass',
      src: ['*.scss'],
      dest: 'asset',
      ext: '.css'
    }],
    options: {
      imagePath: 'image/<%= package.name %>',
      sourceComments: 'none',
      outputStyle: 'compressed'
    }
  },
  minifyAdmin: {
    files: [{
      expand: true,
      cwd: 'sass/admin',
      src: ['*.scss'],
      dest: 'asset/admin',
      ext: '.css'
    }],
    options: {
      imagePath: 'image/<%= package.name %>',
      sourceComments: 'none',
      outputStyle: 'compressed'
    }
  }
};
