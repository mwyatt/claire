var url = require('utility/url');
var mustache = require('mustache');
var feedbackStream = require('admin/feedbackStream');


/**
 */
var ControllerContentMeta = function () {
	this.contentId = $('.js-content-single').attr('data-id');
	this.readAll(this);
};


/**
 * get all meta associated with content id
 * @param  {object} data 
 * @return {null}      
 */
ControllerContentMeta.prototype.readAll = function(data) {
	$.ajax({
		url: url.getUrlBase('admin/ajax/content/meta/'),
		type: 'get',
		dataType: 'json',
		data: {
			contentId: data.contentId
		},
		success: function(metas) {
			$('.js-content-meta-container').html(mustache.render($('#admin-content-meta-all').html(), {metas: metas}));
			data.eventsRefresh(data);
			data.getNewRow(data);
		},
		error: function(result) {
			feedbackStream.createMessage({
			  message: 'Network error.',
			  type: 'negative'
			});
		}
	});
};


ControllerContentMeta.prototype.eventsRefresh = function(data) {

	// resource
	var timeout;
	var trigger;

	// editing name / value
	$('.js-content-meta-input-name, .js-content-meta-input-value')
		.off('keyup.content-meta')
		.on('keyup.content-meta', function(event) {
			trigger = this;
			clearTimeout(timeout);
			timeout = setTimeout(function() {
				data.changeInput(data, trigger);
			}, 500);
		});

	// delete a meta
	$('.js-content-meta-delete').on('click.content-meta', function(event) {
		event.preventDefault();
		var $this = $(this);
		var closestRow = $this.closest('.js-content-meta');
		var id = closestRow.attr('data-id');
		$.ajax({
			url: url.getUrlBase('admin/ajax/content/meta/delete/'),
			type: 'get',
			dataType: 'json',
			data: {id: id},
			complete: function(result) {},
			success: function(result) {
				if (result) {
					closestRow.remove();
				};
			},
			error: function(result) {
				feedbackStream.createMessage({
				  message: 'Network error.',
				  type: 'negative'
				});
			}
		});
	});
};


ControllerContentMeta.prototype.changeInput = function(data, trigger) {

	// resource
	var jTrigger = $(trigger);
	var closestRow = jTrigger.closest('.js-content-meta');
	var inputName = closestRow.find('.js-content-meta-input-name');
	var inputValue = closestRow.find('.js-content-meta-input-value');
	var id = closestRow.attr('data-id');

	// remove events
	inputName.off('change.content-meta');
	inputValue.off('change.content-meta');

	// call
	$.ajax({
		url: url.getUrlBase('admin/ajax/content/meta/' + (id ? id : 'create') + '/'),
		type: 'get',
		dataType: 'json',
		data: {
			contentId: data.contentId,
			name: inputName.val(),
			value: inputValue.val()
		},
		complete: function() {
			data.getNewRow(data);
		},
		success: function(meta) {
			closestRow.attr('data-id', meta.id);
			data.eventsRefresh(data);
		},
		error: function(result) {
			feedbackStream.createMessage({
			  message: 'Network error.',
			  type: 'negative'
			});
		}
	});
};


ControllerContentMeta.prototype.getNewRow = function(data) {
	var metas = $('.js-content-meta');
	var newRowNeeded = true;
	for (var index = metas.length - 1; index >= 0; index--) {
		if (! $(metas[index]).attr('data-id')) {
			newRowNeeded = false;
		};
	};
	if (newRowNeeded) {
		metas
			.last()
			.clone()
			.attr('data-id', '')
			.appendTo('.js-content-meta-container');
		option = $('.js-content-meta').last();
		option
			.find('.js-content-meta-input-name')
			.val('');
		option
			.find('.js-content-meta-input-value')
			.val('');
		data.eventsRefresh(data);
	};
};


/**
 * export
 */
module.exports = new ControllerContentMeta;
