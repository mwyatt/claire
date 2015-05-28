var mustache = require('mustache');
var keycode = require('keycode');
var data;
var $dialogue;
var $positionTo;
var intTargetLeftOffset;
var calculatedLeft;
var intPopWidth;
var intWindowWidth;


/**
 * requirements
 * draggable with custom actions
 * built each time mustache
 * can be simple message 'ok'
 * can be ok / cancel with callback
 * 
 */
var Dialogue = function () {};


/**
 * render, bind events, and position new dialogue
 * @param  {object} options 
 * @return {null}         
 */
Dialogue.prototype.create = function(options) {
	var defaults = {
		className: 'foo-bar',
		positionTo: '.selector',
		width: 150,
		title: '',
		description: '',
		actions: [
		  {name: 'Cancel', action: function() {
		    console.log('Cancel');
		  }},
		  {name: 'Ok', action: function() {
		    console.log('Ok');
		  }}
		],
		onComplete: function() {},
		onClose: function() {}
	};
	this.options = $.extend(defaults, options);
	$positionTo = $(this.options.positionTo);
	data = this;

	// render
	$('body').append(mustache.render($('#admin-dialogue').html(), data.options));

	// events
	$('.js-dialogue-close').on('click.dialogue', function() {
		data.close(data);
	});
	$dialogue = $('.js-dialogue');
	$dialogue.on('click.dialogue', function(event) {
		event.stopPropagation();
	});
	$(document).off('keyup.dialogue').on('keyup.dialogue', function(event) {
		if (event.which == keycode.esc) {
			data.close(data);
		} 
	});
	$(document).off('mouseup.dialogue').on('mouseup.dialogue', function(event) {
		if (! $(event.target).closest('.js-dialogue').length) {
			data.close(data);
		}
	});

	// events - actions
	for (var index = data.options.actions.length - 1; index >= 0; index--) {
		$dialogue
			.find('.js-dialogue-action-' + data.options.actions[index]['name']).on('click.dialogue', function() {
				data.options.actions[index]['action'].call();
			});
	};

	// position
	intTargetLeftOffset = parseInt($positionTo.offset().left);
	calculatedLeft = intTargetLeftOffset;
	intPopWidth = parseInt(this.options.width);

	// out of viewport, move just inside
	intWindowWidth = parseInt($(window).width());
	if ((intTargetLeftOffset + intPopWidth) > (intWindowWidth - 20)) {
		calculatedLeft = intWindowWidth - 50;
		calculatedLeft = calculatedLeft - intPopWidth;
	};

	// position
	$dialogue.css({
		width: this.options.width,
		top: $positionTo.offset().top + 20,
		left: calculatedLeft
	});

	// completed build
	this.options.onComplete.call();
};


/**
 * call onclose and remove
 * @param  {object} data 
 * @return {null}      
 */
Dialogue.prototype.close = function(data) {
	data.options.onClose.call();
	$dialogue.remove();
};


module.exports = new Dialogue;
