

/**
 */
var ControllerOption = function () {
	this.getNewRow(this);
	this.events(this);
};


ControllerOption.prototype.events = function(data) {
	
};


ControllerOption.prototype.eventsRefresh = function(data) {
	$('.js-option-input-name, .js-option-input-value')
		.off('change.option')
		.on('change.option', function(event) {
			data.changeInput(data, this);
			data.getNewRow(data);
		});
	$('.js-delete').on('click.option', function(event) {
		event.preventDefault();
		var $this = $(this);
		var closestRow = $this.closest('.js-option');
		var id = closestRow.attr('data-id');
		$.ajax({
			url: system.getUrl('base') + 'admin/ajax/option/delete/',
			type: 'get',
			dataType: 'json',
			data: {id: id},
			complete: function(result) {},
			success: function(result) {
				if (result) {
					closestRow.remove();
				};
			},
			error: function(result) {}
		});
		
	});
};


ControllerOption.prototype.changeInput = function(data, trigger) {

	// resource
	var jTrigger = $(trigger);
	var closestRow = jTrigger.closest('.js-option');
	var inputName = closestRow.find('.js-option-input-name');
	var inputValue = closestRow.find('.js-option-input-value');
	var id = closestRow.attr('data-id');

	// remove events
	inputName.off('change.option');
	inputValue.off('change.option');

	// call
	$.ajax({
		url: system.getUrl('base') + 'admin/ajax/option/' + (id ? id : 'create') + '/',
		type: 'get',
		dataType: 'json',
		data: {
			name: inputName.val(),
			value: inputValue.val()
		},
		complete: function(result) {},
		success: function(option) {
			closestRow.attr('data-id', option.id);
			data.eventsRefresh(data);
		},
		error: function(result) {
			console.log(result);
		}
	});
};


ControllerOption.prototype.getNewRow = function(data) {
	var options = $('.js-option');
	var newRowNeeded = true;
	for (var index = options.length - 1; index >= 0; index--) {
		if (! $(options[index]).attr('data-id')) {
			newRowNeeded = false;
		};
	};
	if (newRowNeeded) {
		options
			.last()
			.clone()
			.attr('data-id', '')
			.appendTo('.js-options tbody');
		option = $('.js-option').last();
		option
			.find('.js-option-input-name')
			.val('');
		option
			.find('.js-option-input-value')
			.val('');
		data.eventsRefresh(data);
	};
};