

/**
 * app structure
 * simply jumps into if statements and boots functionality where required
 */
var Controller = function () {
	this.page = system.page;
	this.route(this);
};


Controller.prototype.route = function(data) {

	// always fires
	data.global(data);

	// // 
	// if (system.page.hasClass('js-tennis-fixture-single')) {
	// 	var page = new Page_Tennis_Fixture_Single();
	// };
};


Controller.prototype.global = function(data) {
	var feedbackStream = new FeedbackStream;

	// magnific inline
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
								feedbackStream.createMessage(result.responseJSON);
							},
							error: function(result) {
								feedbackStream.createMessage(result.responseJSON);
							}
						});
				});
			}
		}
	});
};
