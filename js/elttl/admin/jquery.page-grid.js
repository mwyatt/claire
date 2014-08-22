

/**
 * completely removed from any ajax, works independently and quickly
 * @param {object} options 
 */
var Page_Grid = function (options) {
	var defaults = {}
	this.options = $.extend(defaults, options);
	this.setEvents(this);
};


/**
 * simple array of sides definition
 * @param  {object} data 
 * @return {array}      
 */
Page_Grid.prototype.setEvents = function(data) {
	
	$('.js-grid-button-save').off('click.page-grid').on('click.page-grid', function(event) {
		event.preventDefault();
		data.modifyRow(data, $(this), 'create');
	});
	$('.js-grid-button-delete').off('click.page-grid').on('click.page-grid', function(event) {
		event.preventDefault();
		var trigger = $(this);
		data.modifyRow(data, trigger, 'delete');
		trigger.closest('.js-table-crud-row').remove();
	});
	$('.js-grid-button-create').off('click.page-grid').on('click.page-grid', function(event) {
		event.preventDefault();
		data.copyRow(data, $(this));
	});
};


Page_Grid.prototype.copyRow = function(data, trigger) {
	var firstRow = $('.js-table-crud-row').first();
	var cloned = firstRow.clone();
	$('.js-grid-table-headings').after(cloned);
	var cells = cloned.find('.js-grid-cell');
	var cell;
	for (var index = cells.length - 1; index >= 0; index--) {
		cell = $(cells[index]);
		cell.val('');
	};
	data.setEvents(data);
};


Page_Grid.prototype.modifyRow = function(data, trigger, action) {
	var row = trigger.closest('.js-table-crud-row');
	var cells = row.find('.js-grid-cell');
	var cell;
	var values = {};
	for (var index = cells.length - 1; index >= 0; index--) {
		cell = $(cells[index]);
		values[cell.attr('name')] = cell.val();
	};
	if (values.id.length && action != 'delete') {
		action = 'update';
	};
	var sendData = {};
	sendData[data.options.table] = values;
	$.ajax({
		url: system.url.adminAjax + data.options.table +'/' + action + '/',
		data: sendData,
		dataType: 'html',
		success: function(result) {
			if (result) {
				console.log('modifyRow->success');
				if (action == 'create') {
					row.find('.js-grid-cell[name="id"]').val(result);
				};
			} else {
				console.log('modifyRow->failure');
			}
		},
		error: function() {
			console.log('modifyRow->failure');
		}
	});
};
