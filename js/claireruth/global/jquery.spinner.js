


var Spinner = function (options) {
	var defaults = {

		// css selector eg .example
		container: '',

		// block / float
		type: 'float'
	};
	this.options = $.extend(defaults, options);
	this.create(this);
};


Spinner.prototype.getStructure = function(data) {
	var structure = '';
	var isBlock = data.options.type == 'block';
	if (isBlock) {
		structure += '<div class="spinner-block js-spinner">';
	};
	structure += '<div class="spinner js-spinner"></div>';
	if (isBlock) {
		structure += '</div>';
	};
	return structure;
};


Spinner.prototype.create = function(data) {
	var theContainer = $(data.options.container);
	theContainer
		.addClass('is-loading')
		.append(this.getStructure(data));
};


Spinner.prototype.delete = function(instance) {
	var theContainer = $(instance.options.container);
	theContainer
		.removeClass('is-loading')
		.find('.js-spinner')
		.remove();
};
