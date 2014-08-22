

/**
 * app structure
 * simply jumps into if statements and boots functionality where required
 */
var Page = function () {
	this.global();
	if (system.page.hasClass('js-tennis-fixture-single')) {
		var page = new Page_Tennis_Fixture_Single();
	};
	if (system.page.hasClass('js-tennis-player-list')) {
		var page = new Page_Grid({
			table: 'player'
		});
	};
	if (system.page.hasClass('js-tennis-team-list')) {
		var page = new Page_Grid({
			table: 'team'
		});
	};
};


Page.prototype.global = function(data) {

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
};
