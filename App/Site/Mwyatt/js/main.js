var buttonToTop = require('buttonToTop');
var smoothScroll = require('smoothScroll');
var scrollDirection = require('scrollDirection');


$(document).ready(function() {
	var html = $('html');

	// to top button
	buttonToTop.init({
		button: '.to-top'
	});

	// smoothscroll
	smoothScroll.init({
		target: '.menu-primary-level-1-link'
	});

	// scroll direction
	scrollDirection.init({
		container: 'html'
	});
});
