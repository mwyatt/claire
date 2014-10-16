

var taskLocal = [
  'sass:local',
  'concat:js',
  'concat:js_admin'
];


var taskRemote = [
  'sass:remote',
  'concat:js',
  'concat:js_admin',
  'uglify:js'
]


/**
 * tasks
 */
module.exports = function(grunt) {

  // dep
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-sass');

  // task
  grunt.registerTask('default', ['watch:local']);
  grunt.registerTask('local', taskLocal);
  grunt.registerTask('remote', taskRemote);
  grunt.registerTask('watch-local', ['watch:local']);
  grunt.registerTask('watch-remote', ['watch:remote']);

  // config
  grunt.initConfig({
    config: grunt.file.readJSON('config.json'),
    sass: {
      local: {
        files: [{
          expand: true,
          cwd: 'sass/<%= config.siteName %>/',
          src: ['*.scss'],
          dest: 'asset/',
          ext: '.css'
        }],
        options: {
          imagePath: '../media/<%= config.siteName %>',
        	loadPath: 'sass/',
          sourceComments: 'normal',
          outputStyle: 'nested'
        }
      },
      remote: {
        files: [{
          expand: true,
          cwd: 'sass/<%= config.siteName %>/',
          src: ['*.scss'],
          dest: 'asset/',
          ext: '.css'
        }],
        options: {
          sourceComments: 'none',
          outputStyle: 'compressed'
        }
      }
    },
    concat: {
      js: {
        options: {
          separator: ';'
        },
        src: [
          'js/<%= config.siteName %>/*.js',
          'js/<%= config.siteName %>/vendor/*.js',
          'js/*.js',
          '!js/<%= config.siteName %>/jquery.js',
          '!js/<%= config.siteName %>/modernizr.js',
        ],
        dest: 'asset/main.js'
      },
      js_admin: {
        options: {
          separator: ';'
        },
        src: [
          'js/<%= config.siteName %>/admin/*.js',
          'js/<%= config.siteName %>/admin/vendor/*.js',
          'js/*.js',
          '!js/<%= config.siteName %>/jquery.js',
          '!js/<%= config.siteName %>/modernizr.js',
        ],
        dest: 'asset/admin-main.js'
      }
    },
    uglify: {
      js: {
        files: {
          'asset/main.js': ['asset/main.min.js'],
        }
      },
    },
    watch: {
      local: {
        files: [
          'sass/**',
          'js/**',
        ],
        tasks: taskLocal
      },
      remote: {
        files: [
          'sass/**',
          'js/**',
        ],
        tasks: taskRemote
      },
    },
  });
};

