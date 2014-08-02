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
  grunt.registerTask('watch-local', ['watch:local']);
  grunt.registerTask('watch-remote', ['watch:remote']);

  // config
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      local: {
        files: [{
          expand: true,
          cwd: 'sass/<%= pkg.name %>/',
          src: ['*.scss'],
          dest: 'asset/',
          ext: '.css'
        }],
        options: {
          imagePath: '../media/<%= pkg.name %>',
        	loadPath: 'sass/',
          sourceComments: 'normal',
          outputStyle: 'nested'
        }
      },
      remote: {
        files: [{
          expand: true,
          cwd: 'sass/<%= pkg.name %>/',
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
          'js/<%= pkg.name %>/*.js',
          'js/<%= pkg.name %>/vendor/*.js',
          'js/<%= pkg.name %>/global/*.js',
          '!js/<%= pkg.name %>/jquery.js',
          '!js/<%= pkg.name %>/modernizr.js',
        ],
        dest: 'asset/main.js'
      },
      js_admin: {
        options: {
          separator: ';'
        },
        src: [
          'js/<%= pkg.name %>/admin/*.js',
          'js/<%= pkg.name %>/admin/vendor/*.js',
          'js/<%= pkg.name %>/global/*.js',
          '!js/<%= pkg.name %>/jquery.js',
          '!js/<%= pkg.name %>/modernizr.js',
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
        tasks: [
          'sass:local',
          'concat:js',
          'concat:js_admin',
        ]
      },
      remote: {
        files: [
          'sass/**',
          'js/**',
        ],
        tasks: [
          'sass:remote',
          'concat:js',
          'concat:js_admin',
          'uglify:js',
        ]
      },
    },
  });
};

