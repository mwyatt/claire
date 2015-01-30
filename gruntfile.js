
// tasks i will need to do
// grunt copy:admin -> copies all required vendor assets
// grunt copy:site:mwyatt -> copies for site specific
// grunt watch:admin -> watch changes to scss in admin area
// grunt watch:site -> watch changes in site specific
// no need to watch or compile the js as it will be using requirejs
module.exports = function(grunt) {

  // init
  grunt.initConfig({
		config: grunt.file.readJSON('app/config.json')
  });

  // load tasks
  require('load-grunt-tasks')(grunt);

  // measures the time each task takes
  require('time-grunt')(grunt);

  // load grunt config
  require('load-grunt-config')(grunt);

  // shortcuts
  grunt.registerTask('default', ['watch:all']);
  // grunt.registerTask('minify', ['sass:minifyFront', 'sass:minifyAdmin']);
};
