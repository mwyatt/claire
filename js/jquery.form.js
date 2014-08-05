

/**
 * emcompassing all form functionality
 * @param {object} options 
 */
var Form = function (options) {
	this.setForms(this);
	this.setSubmitButtons(this);
};


Form.prototype.setForms = function(data) {
	$('form').on('submit.form', function(event) {
		var form = $(this);

		// dont submit if already submitting
		if (form.hasClass('js-is-submitting')) {
			return false;
		}
		form.addClass('js-is-submitting');
		return true;
	});
};


/**
 * setup all submit buttons globally to submit
 * @param {object} data 
 */
Form.prototype.setSubmitButtons = function(data) {
	$('.js-form-button-submit').on('mouseup.form', function() {
		$(this).closest('form').submit();
	});
};
