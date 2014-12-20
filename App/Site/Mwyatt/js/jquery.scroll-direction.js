

var Scroll_Direction = function (options) {
	var defaults = {

		// css selector eg .example
		container: '',

		// give for movement before action is taken
		threshhold: 20
	};
	this.options = $.extend(defaults, options);
	this.refreshEvents(this);
};


Scroll_Direction.prototype.refreshEvents = function(data) {

	// resources
	var theWindow = $(window);
	var scrollCache = 'up';
	var scrollPositionPrevious = 0;
	var totalMovement = 0;
	var thisScrollTop;
	var scrollDifference = 0;
	var scrollPositionNext = 0;

	// scroll event
	theWindow.scroll(function(event) {
		thisScrollTop = $(this).scrollTop();

		// work out total movement
		scrollDifference = thisScrollTop > scrollPositionPrevious ? thisScrollTop - scrollPositionPrevious : scrollPositionPrevious - thisScrollTop;

		// work out class required
		if (scrollDifference > data.options.threshhold) {

			// work out class required
			scrollPositionNext = thisScrollTop;
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
		};
	});
};
