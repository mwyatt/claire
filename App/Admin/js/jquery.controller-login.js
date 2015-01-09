

/**
 * app structure
 * simply jumps into if statements and boots functionality where required
 */
var ControllerLogin = function () {

	// magnific forgot password
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
							url: system.getUrl('base') + 'admin/ajax/forgot-password/',
							type: 'get',
							dataType: 'json',
							data: $(this).closest('form').serializeObject(),
							success: function(result) {
								console.log(result);
								var feedbackStream = new FeedbackStream(result);
								$.magnificPopup.close();
							},
							error: function(result) {
								console.log(result);
								var feedbackStream = new FeedbackStream(result);
							}
						});
				});
			}
		}
	});
};
