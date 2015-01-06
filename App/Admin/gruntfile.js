module.exports = function(grunt) {

	// resource
	var taskLocal = [
		'sass:local',
		'concat:js',
	];
	var taskRemote = [
		'sass:remote',
		'concat:js',
		'uglify:js',
	];
	var sassFiles = [{
		expand: true,
		cwd: 'sass',
		src: ['*.scss'],
		dest: '../../asset/admin',
		ext: '.css',
	}];
	var watchPaths = [
		'../../../sass/**',
		'../../../js/**',
		'sass/**',
		'js/**'
	];

	// dependencies
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass');

	// task
	grunt.registerTask('default', ['watch:local']);
	grunt.registerTask('local', taskLocal);
	grunt.registerTask('remote', taskRemote);

	// config
	grunt.initConfig({
		taskLocal: taskLocal,
		taskRemote: taskRemote,
		sassFiles: sassFiles,
		watchPaths: watchPaths,
		copy: {
			dist: {
				files: [
					{
						expand: true,
						cwd: 'vendor/bower/animate.scss/scss',
						src: '**',
						dest: 'sass/vendor/animate',
						rename: function(dest, src) {
							if (src == 'animate.scss') {
								return dest + '_' + src;
							};
							return dest + src;
						},
					},
					{
						expand: true,
						cwd: 'vendor/bower/bourbon/app/assets/stylesheets',
						src: '**',
						dest: 'sass/vendor/bourbon',
					},
					{
						expand: true,
						cwd: 'vendor/bower/normalize-scss',
						src: '*.scss',
						dest: 'sass/vendor/normalize',
					},
					{
						expand: true,
						cwd: 'vendor/bower/jquery/dist',
						src: 'jquery.js',
						dest: 'js/vendor/jquery',
					},
					{
						expand: true,
						cwd: 'vendor/bower/jquery/dist',
						src: 'jquery.js',
						dest: '../../asset/admin/vendor/jquery',
					},
					{
						expand: true,
						cwd: 'vendor/bower/modernizr',
						src: 'modernizr.js',
						dest: '../../asset/admin/vendor/modernizr',
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
						cwd: 'vendor/bower/magnific-popup/dist',
						src: 'magnific-popup.css',
						dest: 'sass/vendor/magnific-popup/',
						rename: function(dest, src) {
							if (src == 'magnific-popup.css') {
								return dest + '_' + src.replace('.css', '.scss');
							};
						},
					},
				]
			}
		},
		sass: {
			local: {
				files: sassFiles,
				options: {
					imagePath: 'asset',
					loadPath: 'sass',
					sourceComments: 'normal',
					outputStyle: 'nested'
				},
			},
			remote: {
				files: sassFiles,
				options: {
					imagePath: 'asset',
					loadPath: 'sass',
					sourceComments: 'none',
					outputStyle: 'compressed'
				},
			},
		},
		concat: {
			js: {
				options: {
					separator: ';',
				},
				src: [
					'js/vendor/jquery/jquery.js',
					'js/vendor/jquery-serialize-object/jquery.serialize-object.min.js',
					'js/vendor/magnific-popup/jquery.magnific-popup.js',
					'../../js/jquery.button-to-top.js',
					'../../js/jquery.form.js',
					'../../js/jquery.function.js',
					'../../js/jquery.search.js',
					'../../js/jquery.spinner.js',
					'../../js/jquery.system.js',
					'js/jquery.scrollfollow.js',
					'js/jquery.content-meta.js',
					'js/jquery.controller.js',
					'js/jquery.controller-login.js',
					'js/jquery.dismiss.js',
					'js/jquery.feedback-stream.js',
					'js/jquery.hover.class.js',
					'js/jquery.mediabrowser.js',
					'js/jquery.model-content-meta.js',
					'js/jquery.model-content-slug.js',
					'js/jquery.model-example.js',
					'js/jquery.model-media.js',
					'js/jquery.model-media-browser.js',
					'js/jquery.model-tag-browser.js',
					'js/jquery.page-grid.js',
					'js/jquery.page-tennis-fixture-single.js',
					'js/jquery.prompt.js',
					'js/main.js'
				],
				dest: '../../asset/admin/main.js',
			}
		},
		uglify: {
			js: {
				files: {
					'../../asset/admin/main.js': ['asset/main.js']
				},
			},
		},
		watch: {
			local: {
				files: watchPaths,
				tasks: taskLocal,
			},
			remote: {
				files: watchPaths,
				tasks: taskRemote,
			},
		},
	});
};
