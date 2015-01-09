

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
	var thisController;

	// 
	if (data.page.hasClass('login')) {
		thisController = new ControllerLogin;
	};

	// 
	if (data.page.hasClass('content-single')) {
		thisController = new ControllerContentSingle;
	};
};


Controller.prototype.global = function(data) {};
