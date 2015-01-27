	// tasks i will need to do
	// grunt copy:admin -> copies all required vendor assets
	// grunt copy:site:mwyatt -> copies for site specific
	// grunt watch:admin -> watch changes to scss in admin area
	// grunt watch:site -> watch changes in site specific
	// no need to watch or compile the js as it will be using requirejs


module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-requirejs')
	// grunt.loadNpmTasks('grunt-contrib-uglify');
	// grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.initConfig({
		config: grunt.file.readJSON('app/config.json'),
		requirejs: {
		  compile: {
		    options: {
		      baseUrl: 'js',
		      mainConfigFile: 'js/build.js',
		      name: "js/admin-main.js",
		      out: 'asset/admin/main.js'
		    }
		  }
		},
		watch: {
			admin: {
				files: ['app/admin/sass/**'],
				tasks: ['sass:admin']
			}
		},
		sass: {
			admin: {
				files: [{
					expand: true,
					cwd: 'app/admin/sass',
					src: ['*.scss'],
					dest: 'asset/admin',
					ext: '.css',
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
			},
		},
		copy: {
			all: {
				files: [
					{
						expand: true,
						cwd: 'vendor/bower/animate.scss/scss/',
						src: '**',
						dest: 'sass/vendor/animate/',
					},
					{
						expand: true,
						cwd: 'vendor/bower/mustache',
						src: 'mustache.js',
						dest: 'js/vendor/mustache'
					},
					{
						expand: true,
						cwd: 'vendor/bower/bourbon/app/assets/stylesheets/',
						src: '**',
						dest: 'sass/vendor/bourbon/',
					},
					{
						expand: true,
						cwd: 'vendor/bower/tinymce',
						src: '**',
						dest: 'js/vendor/tinymce/'
					},
					{
						expand: true,
						cwd: 'vendor/bower/magnific-popup/dist/',
						src: 'magnific-popup.css',
						dest: 'sass/vendor/magnific-popup/',
						rename: function(dest, src) {
							return dest + '_' + src.replace('.css','.scss');
						}
					},
					{
						expand: true,
						cwd: 'vendor/bower/magnific-popup/dist',
						src: 'jquery.magnific-popup.js',
						dest: 'js/vendor/magnific-popup',
					},
					{
						expand: true,
						cwd: 'vendor/bower/jquery-serialize-object/dist',
						src: '**',
						dest: 'js/vendor/jquery-serialize-object',
					},
					{
						expand: true,
						cwd: 'vendor/bower/owlcarousel/owl-carousel/',
						src: '*.css',
						dest: 'sass/vendor/owl-carousel/',
						rename: function(dest, src) {
							return dest + '_' + src.replace('.css','.scss');
						}
					},
					{
						expand: true,
						cwd: 'vendor/bower/normalize-scss/',
						src: '*.scss',
						dest: 'sass/vendor/normalize/',
					},
					{
						expand: true,
						cwd: 'vendor/bower/jquery/dist',
						src: 'jquery.js',
						dest: 'js/vendor/jquery',
					}
				]
			}
		}
	});
};
