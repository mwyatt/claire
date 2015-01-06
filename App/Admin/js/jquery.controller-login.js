

/**
 * app structure
 * simply jumps into if statements and boots functionality where required
 */
var ControllerLogin = function () {
	
	// magnific forgot password
	$('.js-magnific-inline').magnificPopup({
		type: 'inline',
		mainClass: 'magnific-forgot-password',
		callbacks: {
			open: function() {
				$('.js-form-forgot-password')
					.off('submit.forgot-password')
					.on('submit.forgot-password', function(event) {
						event.preventDefault();
						$.ajax({
							url: '../ajax/admin/user/forgot-password/',
							type: 'get',
							dataType: 'json',
							data: $(this).closest('form').serializeObject(),
							complete: function() {
								console.log('always do this');
							},
							success: function(result) {
								var feedbackStream = new FeedbackStream({
									message: result.responseJSON,
									type: 'positive'
								});
							},
							error: function(result) {
								var feedbackStream = new FeedbackStream({
									message: result.responseJSON,
									type: 'negative'
								});
							}
						});
				});
			}
		}
	});
};
