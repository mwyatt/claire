

/**
 * dependencies
 */
var $ = require('jquery');
var serializeObject = require('vendor/jquery/serializeObject');
var magnificPopup = require('vendor/jquery/magnificPopup');
var helper = require('helper');
var feedbackStream = require('admin/feedbackStream');


/**
 * forgot password
 */
var thisMagnific;
$('.js-magnific-inline').magnificPopup({
	type: 'inline',
	mainClass: 'magnific-forgot-password',
	callbacks: {
		open: function() {
			thisMagnific = this;
			$('.js-form-forgot-password')
				.off('submit.forgot-password')
				.on('submit.forgot-password', function(event) {
					event.preventDefault();
					$.ajax({
						url: helper.urlBase('admin/ajax/forgot-password/'),
						type: 'get',
						dataType: 'json',
						data: $(this).closest('form').serializeObject(),
						success: function(result) {
							feedbackStream.createMessage(result);
							$.magnificPopup.close();
						},
						error: function(result) {
							console.log(result);
							feedbackStream.createMessage(result);
						}
					});
			});
		}
	}
});
