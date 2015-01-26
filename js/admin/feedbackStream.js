define(['jquery'], function ($) {


	/**
	 * accepts a message and displays appropriatly, stacks
	 * them on top of one another, then fades away after a period of time
	 * @param {object} options 
	 */
	var FeedbackStream = function (options) {
		this.createMessage(options);
	};


	/**
	 * builds html required for standard message
	 * @param  {object} config type, message
	 * @return {object}        jquery
	 */
	FeedbackStream.prototype.getMessage = function(config) {
		return $('<div class="feedback-stream-single js-feedback-stream-single is-' + config['type'] + '">' + config['message'] + '</div>');
	};


	/**
	 * prepends message to the loop
	 * the config object has two properties
	 * 		config.type (positive, neutral, negative)
	 * 		config.message string
	 * @param  {object} config 
	 * @return {null}        
	 */
	FeedbackStream.prototype.createMessage = function(config) {
		var message = this.getMessage(config);
		$('.js-feedback-stream-position').prepend(message);
		var timer = setTimeout(function() {
			message.addClass('is-removed');

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
	};
console.log('hi');
	alert(new FeedbackStream);
});
