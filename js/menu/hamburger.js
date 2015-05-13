var $ = require('jquery');


var Hamburger = function () {
	var html = $('html');

	// toggle menu primary
	$('.js-toggle-menu-primary').on('click', function(event) {
		event.preventDefault();
		html.toggleClass('menu-primary-is-active');
	});
	
	// remove menu when clicked away
	$(document).on('click', function(event) {
		if (! $(event.target).closest('.js-menu-primary').length && ! $(event.target).closest('.js-toggle-menu-primary').length) {
			html.removeClass('menu-primary-is-active');
		}
	});

	// escape key
	$(document).on('keyup', function(event) {
		if (event.keyCode == 27) {
			html.removeClass('menu-primary-is-active');
		} 
	});
};


module.exports = new Hamburger;
