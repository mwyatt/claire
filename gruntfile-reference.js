

module.exports = function(grunt) {

	// dependencies
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass');

	// tasks i will need to do
	// grunt copy:admin -> copies all required vendor assets
	// grunt copy:site:mwyatt -> copies for site specific
	// grunt watch:admin -> watch changes to scss in admin area
	// grunt watch:site -> watch changes in site specific
	// no need to watch or compile the js as it will be using requirejs

	// config
	grunt.initConfig({
		config: grunt.file.readJSON('app/config.json'),
		taskLocal: [
			'sass:admin',
			'concat:jsAdmin'
		],
		taskRemote: [
			'sass:remote',
			'concat:js',
			'concat:jsAdmin',
			'uglify:js'
		],
		sassFiles: [{
			expand: true,
			cwd: 'app/site/<%= config.site %>/sass',
			src: ['*.scss'],
			dest: 'app/site/<%= config.site %>/asset',
			ext: '.css'
		}],
		watchPaths: [
			'app/sass/**',
			'app/js/**',
			'app/admin/sass/**',
			'app/admin/js/**',
			'app/site/<%= config.site %>/sass/**',
			'app/site/<%= config.site %>/js/**'
		],
		copy: {
			dist: {
				files: [
					{
						expand: true,
						cwd: 'vendor/bower/animate.scss/scss/',
						src: '**',
						dest: 'sass/vendor/animate/',
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
						dest: 'asset/admin/vendor/tinymce/'
					},
					{
						expand: true,
						cwd: 'vendor/bower/magnific-popup/dist/',
						src: 'magnific-popup.css',
						dest: 'sass/vendor/magnific-popup/',
						rename: function(dest, src) {
							return dest + '_' + src.replace('.css','.scss');
						},
					},
					{
						expand: true,
						cwd: 'vendor/bower/owlcarousel/owl-carousel/',
						src: '*.css',
						dest: 'sass/vendor/owl-carousel/',
						rename: function(dest, src) {
							return dest + '_' + src.replace('.css','.scss');
						},
					},
					{
						expand: true,
						cwd: 'vendor/bower/normalize-scss/',
						src: '*.scss',
						dest: 'sass/vendor/normalize/',
					},
				]
			}
		},
		sass: {
			site: {
				files: grunt.sassFiles,
				options: {
					imagePath: '../asset',
					loadPath: 'sass/',
					sourceComments: 'normal',
					outputStyle: 'nested'
				}
			},
			admin: {
				files: grunt.sassFiles,
				options: {
					imagePath: '../asset',
					loadPath: 'sass/',
					sourceComments: 'none',
					outputStyle: 'compressed'
				}
			}
		},
		concat: {
			js: {
				options: {
					separator: ';',
				},
				src: [
					'js/*',
					'app/site/<%= config.site %>/js/*',
				],
				dest: 'asset/main.js',
			},
			jsAdmin: {
				options: {
					separator: ';',
				},
				src: [
					'app/admin/js/*',
					'js/*'
				],
				dest: 'asset/main-admin.js'
			}
		},
		uglify: {
			site: {
				files: {
					'asset/main.js': ['asset/main.js'],
					'asset/main-admin.js': ['asset/main-admin.js'],
				},
			},
		},
		watch: {
			local: {
				files: grunt.watchPaths,
				tasks: grunt.taskLocal
			},
			remote: {
				files: grunt.watchPaths,
				tasks: grunt.taskRemote
			}
		}
	});

	// tasks
	// grunt.registerTask('default', ['watch:local']);
	grunt.registerTask('local', grunt.taskLocal);
	grunt.registerTask('remote', grunt.taskRemote);
};
