

/**
 * dependencies
 */
var $ = require('jquery');
var mustache = require('vendor/mustache');
var helper = require('helper');


/**
 * accepts a message and displays appropriatly, stacks
 * them on top of one another, then fades away after a period of time
 * @param {object} options 
 */
var FeedbackStream = function () {

	// possible cache for checking?
	this.lastMessage;
};


/**
 * builds html required for standard message
 * @param  {object} config type, message
 * @return {object}        jquery
 */
FeedbackStream.prototype.createMessage = function(config) {
	var newMessage;

	// allow null object, but dont display
	if (! config.message) {
		return;
	};

	// get template
	helper.getMustacheTemplate({
		template: 'admin/feedback',
		success: function (template) {
			$('.js-feedback-stream-position').prepend(mustache.render(template, config));

			// timeout for removal
			var timer = setTimeout(function() {
				$('.js-feedback-stream-single')
					.first()
					.addClass('is-removed');

				// remove single after animation
				// duplication
				$('.js-feedback-stream-single').on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function(event) {
				    $(this).remove();
				});
			}, 5000);

			// refresh message event
			$('.js-feedback-stream-single')
				.off('click.feedback-stream')
				.on('click.feedback-stream', function(event) {
					event.preventDefault();
					$(this).addClass('is-removed');
					
					// remove single after animation
					// duplication
					$('.js-feedback-stream-single').on('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function(event) {
					    $(this).remove();
					});
				});
		}
	});
};


/**
 * instance
 */
module.exports = new FeedbackStream;
