var serializeObject = require('jquery-serialize-object/jquery.serialize-object');
var magnificPopup = require('magnific-popup/dist/jquery.magnific-popup');
var feedbackStream = require('admin/feedbackStream');
var url = require('utility/url');


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
						url: url.getUrlBase('admin/ajax/user/forgot-password/'),
						type: 'get',
						dataType: 'json',
						data: $(this).closest('form').serializeObject(),
						success: function(result) {
							feedbackStream.createMessage(result);
							if (result.type == 'positive') {
								$.magnificPopup.close();
							};
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
