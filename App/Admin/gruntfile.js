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
		dest: 'asset',
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
						dest: 'js/vendor/jquery',
					},
					{
						expand: true,
						cwd: 'vendor/bower/modernizr',
						src: 'modernizr.js',
						dest: 'asset/vendor',
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
					'js/vendor/**',
					'js/**',
					'../../../js/jquery.button-to-top.js',
					'../../../js/jquery.form.js',
					'../../../js/jquery.function.js',
					'../../../js/jquery.search.js',
					'../../../js/jquery.spinner.js',
					'../../../js/jquery.system.js',
				],
				dest: 'asset/main.js',
			}
		},
		uglify: {
			js: {
				files: {
					'asset/main.js': ['asset/main.js']
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