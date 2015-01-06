

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

	// 
	if (data.page.hasClass('login')) {
		var login = new ControllerLogin;
	};
};


Controller.prototype.global = function(data) {
};
