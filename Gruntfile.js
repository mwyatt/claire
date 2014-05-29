module.exports = function(grunt) {
  grunt.registerTask('default', ['watch']);
  grunt.initConfig({
    // config: grunt.file.readJSON('app/json/config.json'),
    site: 'mwyatt',
    concat: {
	    js: {
        options: {
          separator: ';'
        },
        src: [
          'js/<%= site %>/vendor/*.js',
          'js/<%= site %>/*.js',
          'js/<%= site %>/global/*.js'
        ],
        dest: 'asset/main.js'
      },
      js_admin: {
        options: {
          separator: ';'
        },
        src: [
          'js/admin/*.js'
        ],
        dest: 'asset/admin/main.js'
      },
    },
    compass: {
      dist: {
        options: {
          httpPath: '/',
          require: 'breakpoint',
          cssDir: 'asset',
          sassDir: 'sass/<%= site %>',
          javascriptsDir: 'js',
          imagesDir: 'media',
          relativeAssets: true

// # output_style = :expanded or :nested or :compact or :compressed

        },
        files: {                            
          'screen.css': 'screen.scss',        
          'admin/screen.css': 'admin/screen.scss'
        }
      }
      // dev: {                                  
      //   files: {
      //     'screen.css': 'screen.scss',
      //     'admin/screen.css': 'admin/screen.scss',
      //   }
      // }
    },
    watch: {
      js: {
        files: [
          'js/<%= site %>/*.js'
        ],
        tasks: ['concat:js'],
        options: {
          livereload: true
        }
      },
      js_admin: {
        files: [
          'js/<%= site %>/vendor/*.js',
          'js/<%= site %>/global/*.js',
          'js/admin/vendor/*.js',
          'js/admin/*.js'
        ],
        tasks: ['concat:js_admin'],
        options: {
          livereload: true
        }
      },
      css: {
        files: ['sass/**'],
        tasks: ['compass'],
        options: {
          livereload: true
        }
      },
    },
  });
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
};
