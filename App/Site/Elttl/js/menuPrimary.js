

var Menu_Primary = function () {};


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
		if (! $(event.target).closest('.js-menu-primary-container.is-active').length) {
			$('.js-menu-primary-container').removeClass('is-active');
		}
	});
};


module.exports = new Menu_Primary;
