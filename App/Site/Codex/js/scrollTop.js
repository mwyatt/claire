

var ScrollTop = function(options) {
	var defaults = {
		minHeight: 500
	}
	var options = $.extend(defaults, options);
	if (! $('.to-top').length) {
		$(body).append('<a href="#" class="to-top hide">Top</a>');
	}
	setEvents();
};


module.exports = new ScrollTop;
