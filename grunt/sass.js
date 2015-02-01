module.exports = {
  admin: {
    files: [{
      expand: true,
      cwd: 'app/admin/sass',
      src: ['*.scss'],
      dest: 'asset/admin',
      ext: '.css'
    }],
    options: {
      imagePath: 'asset',
      loadPath: 'sass',
      sourceComments: 'normal',
      outputStyle: 'nested'
    }
  },
  site: {
    files: [{
      expand: true,
      cwd: 'app/site/<%= package.site %>/sass',
      src: ['*.scss'],
      dest: 'app/site/<%= package.site %>/asset',
      ext: '.css'
    }],
    options: {
      imagePath: 'asset',
      loadPath: 'sass',
      sourceComments: 'normal',
      outputStyle: 'nested'
    }
  }
};
