module.exports = {
  front: {
    files: ['js/**'],
    tasks: ['browserify']
  },
  admin: {
    files: ['app/admin/sass/**'],
    tasks: ['sass:admin']
  }
};
