

/**
 * app structure
 * simply jumps into if statements and boots functionality where required
 */
var Controller = function () {
	this.page = system.page;
	this.route(this);
};


Controller.prototype.route = function(data) {

	// always fires
	data.global(data);

	// // 
	// if (system.page.hasClass('js-tennis-fixture-single')) {
	// 	var page = new Page_Tennis_Fixture_Single();
	// };
};


Controller.prototype.global = function(data) {

	// magnific inline
	$('.js-magnific-inline').magnificPopup({
		type: 'inline'
	});
};
