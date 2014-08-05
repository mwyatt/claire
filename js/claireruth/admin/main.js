/**  
 * rules
 * all blocks of functionaltiy seperated into 'module**'
 */
$(document).ready(function() {
	console.log('admin->ready');
	system = new System();
	var form = new Form();

	// try adding all logic for manipulating objects here...
	if (system.getPage().hasClass('content-create-update')) {
		var wysihtml5News = new wysihtml5.Editor('form_html', {
			toolbar: 'toolbar',
			parserRules: wysihtml5ParserRules,
			useLineBreaks: false
		});
		var modelMediaBrowser = new Model_Media_Browser();
		var modelTagBrowser = new Model_Tag_Browser();
		var modelContentSlug = new Model_Content_Slug();
	};

	// watch for dismissers
	var dismiss = new Dismiss();
});