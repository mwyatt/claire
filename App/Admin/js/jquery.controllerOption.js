

/**
 */
var ControllerOption = function () {
	this.getNewRow(this);
	this.events(this);
};


ControllerOption.prototype.events = function(data) {
	
};


ControllerOption.prototype.getNewRow = function(data) {
	var options = $('.js-option');
	var newRowNeeded = true;
	for (var index = options.length - 1; index >= 0; index--) {
		if (! $(options[index]).data('id')) {
			newRowNeeded = false;
		};
	};
	if (newRowNeeded) {
		options
			.last()
			.clone()
			.data('id', '')
			.appendTo('.js-options tbody');
		option = $('.js-option').last();
		option
			.find('.js-option-input-name')
			.val('');
		option
			.find('.js-option-input-value')
			.val('');
	};
};
