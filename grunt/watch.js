module.exports = {
  sassFront: {
    files: ['sass/**'],
    tasks: ['sass:front']
  },
  all: {
    files: [
      'sass/**',
      'js/**'
    ],
    tasks: [
      'newer:sass:front',
      'newer:sass:admin',
      'newer:concat:front',
      'newer:concat:admin'
    ]
  }
};
