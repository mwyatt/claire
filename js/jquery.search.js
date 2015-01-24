

/**
 * handles the header quicksearch
 * @todo is the module name too generic? time will tell
 * @param {object} options 
 */
var Search = function (options) {
	this.timer;
	this.xhr;
	this.headerSearch = $('.js-header-search');
	this.headerSearchDropContainer = $('.js-search-quick-append-drop');
	this.headerSearchInput = $('.js-header-form-search-input');
	this.setEvents(this);
};


Search.prototype.clearDrop = function(data) {
	data.headerSearchDropContainer.html('');
};


Search.prototype.setEvents = function(data) {

	// esc
	$(document).on('keyup.header-search', function(event) {
		if (event.keyCode == 27) {
			data.clearDrop(data);
		};
	});

	// clicking doc
	$(document).off('mouseup.header-search').on('mouseup.header-search', function(event) {
		if (! $(event.target).closest('.js-drop').length) {
			data.clearDrop(data);
		}
	});

	// search box
	data.headerSearchInput.on('keyup.header-search', function(event) {

		// esc
		if (event.keyCode == 27) {
			return;
		};
		data.poll(data);
	});
};


Search.prototype.poll = function(data) {
	data.clearDrop(data);
	clearTimeout(data.timer);

	// no null value
	if (data.headerSearchInput.val().length < 1) {
		return;
	}

	// 300ms
	data.timer = setTimeout(function() {
		data.pollRequest(data);
	}, 300);
};


Search.prototype.pollRequest = function(data) {
	data.xhr = $.ajax({
		type: 'get',
		url: config.url.ajax,
		data: {
			m: 'Ajax_Modules_Search',
			query: data.headerSearchInput.val(),
			type: 'quick'
		},
		success: function(result) {
			if (result) {
				data.headerSearchDropContainer.html(result);

				// clicking search button
				$('.js-quick-search-submit').on('click.header-search', function(event) {
					$(data.headerSearchInput).val(data.headerSearchInput.val())
					$('.header-search-form').submit();
				});
			}
		}
	});
};
