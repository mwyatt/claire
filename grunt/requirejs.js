module.exports = {
	compile: {
		options: {
		  appDir: 'js',
		  baseUrl: 'js',
		  dir: 'asset',
		  mainConfigFile:'js/build.js',
		  findNestedDependencies: true,
		  fileExclusionRegExp: /^\./,
		  inlineText: true
		}
	}
};
