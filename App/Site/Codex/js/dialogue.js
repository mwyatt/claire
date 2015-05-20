var mustache = require('mustache');


/**
 * requirements
 * draggable with custom actions
 * built each time mustache
 * can be simple message 'ok'
 * can be ok / cancel with callback
 * 
 */
var Dialogue = function () {
	this.cache = {
		core: $('.js-pop-over'),
		close: $('.js-pop-over-close'),
		header: $('.js-pop-over-header'),
		title: $('.js-pop-over-header-title'),
		content: $('.js-pop-over-content')
	};
	this.data = this;
};


Dialogue.prototype.create = function(options) {
	var defaults = {
		positionTo: $(''),
		title: '',
		content: '',
		onComplete: function() {},
		width: 200
	};
	this.options = $.extend(defaults, options);
	$(this.cache.close).off('click.pop-over').on('click.pop-over', this, this.close);
	$(this.cache.core).off('click.pop-over').on('click.pop-over', function(event) {
		event.stopPropagation();
	});

	// escape key
	$(document).off('keyup.pop-over').on('keyup.pop-over', this, function(event) {
		if (event.keyCode == 27) {
			event.data.close(event);
		} 
	});

	// document click
	$(document).off('mouseup.pop-over').on('mouseup.pop-over', this, function(event) {
		if (! $(event.target).closest('.pop-over').length) {
			event.data.close(event);
		}
	});

	// paint
	this.cache.title.html(this.options.title);
	this.cache.content.html(this.options.content);
	var intTargetLeftOffset = parseInt(this.options.positionTo.offset().left);
	var calculatedLeft = intTargetLeftOffset;
	var intPopWidth = parseInt(this.options.width);

	// out of viewport, move just inside
	var intWindowWidth = parseInt($(window).width());
	if ((intTargetLeftOffset + intPopWidth) > (intWindowWidth - 20)) {
		calculatedLeft = intWindowWidth - 50;
		calculatedLeft = calculatedLeft - intPopWidth;
	};

	// position
	this.cache.core.css({
		display: 'block',
		width: this.options.width,
		top: this.options.positionTo.offset().top + 20,
		left: calculatedLeft
	});

	// call custom fun
	this.options.onComplete.call();
};


Dialogue.prototype.close = function(event) {
	event.data.cache.core.css({
		display: 'none',
		top: '-999em',
		left: '-999em'
	});
};


module.exports = new Dialogue;
