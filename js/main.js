/* main.js */

// document ready

$(document).ready(function() {

	less.watch();

	$.ajaxSetup ({  
		cache: false  
	});

	var search = $('input[name="search"]');
	console.log(search.val());

	search.on('change', change_search);
	search.on('keyup', change_search);

	/**
	 * returns matching results based on search query
	 * @todo turn this into a timed event so that it is not triggered after all keypresses
	 * @return {[type]} [description]
	 */
	function change_search() {

		if (! search.val())
			return false;

		if (search.val().length < 3)
			return false;
		
		$.getJSON('http://' + window.location.host + '/git/mvc/ajax/search/?default=' + search.val(), function(results) {
			if (results) {
				var ul = search.parent().find('ul').html('');
				$.each(results, function(index, result) {
					$(ul).append('<li class="'+result.type.toLowerCase()+'"><a href="#">'+result.name+'<span>'+result.type+'</span></a></li>');
				});
			}
		});

	}

}); // document ready

// $('input[name="search"]').parent().find('ul').html('')