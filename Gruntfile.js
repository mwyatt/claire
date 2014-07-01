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
          'js/*.js',
          'js/vendor/*.js',
          '!js/jquery-1.8.2.js',
        ],
        dest: 'asset/main.min.js'
      }
    },
    js: {
      options: {
        separator: ';'
      },
      src: [
        'js/<%= pkg.name %>/vendor/*.js',
        'js/<%= pkg.name %>/*.js',
        'js/<%= pkg.name %>/global/*.js'
      ],
      dest: 'asset/main.min.js'
    },
    uglify: {
      js: {
        files: {
          'asset/main.min.js': ['asset/main.min.js'],
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
          'uglify:js',
        ]
      },
    },
  });
};

