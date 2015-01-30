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
      cwd: 'app/site/<%= config.site %>/sass',
      src: ['*.scss'],
      dest: 'app/site/<%= config.site %>/asset',
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
