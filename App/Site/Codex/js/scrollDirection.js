var $ = require('jquery');


var ScrollDirection = function (options) {};


ScrollDirection.prototype.init = function (options) {
	var defaults = {

		// css selector eg .example
		container: ''
	};
	this.options = $.extend(defaults, options);
	this.refreshEvents(this);
};


ScrollDirection.prototype.refreshEvents = function(data) {

	// resources
	var theWindow = $(window);
	var scrollCache = 'up';
	var scrollPositionPrevious = 0;

	// scroll event
	theWindow.scroll(function(event) {
		var scrollPositionNext = $(this).scrollTop();
		if (scrollPositionNext > scrollPositionPrevious){
			scrollCache = 'down';
		} else {
			scrollCache = 'up';
		}
		scrollPositionPrevious = scrollPositionNext;

		// toggle class
		$(data.options.container)
			.removeClass('is-scrolling-down')
			.removeClass('is-scrolling-up')
			.addClass('is-scrolling-' + scrollCache);
	});
};


module.exports = new ScrollDirection;
