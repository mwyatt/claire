

var Menu_Primary = function (options) {
	// var defaults = {
	// 	threshold: 100,
	// 	button: '.null',
	// 	classLabel: 'is-active',
	// 	delay: 200
	// };
	// this.options = $.extend(defaults, options);
	this.events(this);
};


Menu_Primary.prototype.events = function(data) {
	
	// toggle
	$('.js-menu-primary-toggle').on('click', function(event) {
		event.preventDefault();
		$(this).closest('.js-menu-primary-container').toggleClass('is-active');
	});
	
	// esc
	$(document).on('keyup.primary-toggle', function(event) {
		if (event.keyCode == 27) {
			$('.js-menu-primary-container').removeClass('is-active');
		};
	});

	// clicking doc
	$(document).on('mouseup.primary-toggle', function(event) {
		if (! $(event.target).closest('.js-menu-primary-container').length) {
			$('.js-menu-primary-container').removeClass('is-active');
		}
	});
};
