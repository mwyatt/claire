module.exports = function(grunt) {

	// resource
	var taskLocal = [
		'sass:local',
		'concat:js',
		'concat:jsAdmin',
	];
	var taskRemote = [
		'sass:remote',
		'concat:js',
		'concat:jsAdmin',
		'uglify:js',
	];
	var sassFiles = [{
		expand: true,
		cwd: 'app/site/<%= config.site %>/sass/',
		src: ['*.scss'],
		dest: 'asset/',
		ext: '.css',
	}];
	var watchPaths = [
		'app/site/<%= config.site %>/sass/**',
		'app/site/<%= config.site %>/js/**',
	];

	// dependencies
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-bowercopy');

	// task
	grunt.registerTask('default', ['watch:local']);
	grunt.registerTask('bowercopy', ['bowercopy:scss']);
	grunt.registerTask('local', taskLocal);
	grunt.registerTask('remote', taskRemote);

	// config
	grunt.initConfig({
		config: grunt.file.readJSON('app/config.json'),
		sass: {
			local: {
				files: sassFiles,
				options: {
					imagePath: '../media',
					loadPath: 'sass/',
					sourceComments: 'normal',
					outputStyle: 'nested',
				},
			},
			remote: {
				files: sassFiles,
				options: {
					imagePath: '../media',
					loadPath: 'sass/',
					sourceComments: 'none',
					outputStyle: 'compressed',
				},
			},
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
					'js/*',
				],
				dest: 'asset/main-admin.js',
			},
		},
		uglify: {
			js: {
				files: {
					'asset/main.js': ['asset/main.js'],
					'asset/main-admin.js': ['asset/main-admin.js'],
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
