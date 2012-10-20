console.log('cc-script.js');
  
/**
	run when document ready
*/
$(document).ready(function() {
	
	// Spinner
	var opts = {
		lines: 13, // The number of lines to draw
		length: 2, // The length of each line
		width: 2, // The line thickness
		radius: 6, // The radius of the inner circle
		corners: 1, // Corner roundness (0..1)
		rotate: 0, // The rotation offset
		color: '#000', // #rgb or #rrggbb
		speed: 2.2, // Rounds per second
		trail: 100, // Afterglow percentage
		shadow: false, // Whether to render a shadow
		hwaccel: false, // Whether to use hardware acceleration
		className: 'spinner', // The CSS class to assign to the spinner
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		top: 'auto', // Top position relative to parent in px
		left: 'auto' // Left position relative to parent in px
	};

	// Variable(s)
	var $urlBase = $("header.base .profile a").attr("href");
	var $resultRows = $(".results .row"); // store rows
	var $resultRowsType = $(".results .row").attr("data-type"); // store rows type		
	
	/**
	  * .js-visibility
	  */
	$(".js-visibility").click(function() {
						
		// row
		var row = $(this).closest("li");
	
		// data-id
		var id = $(this)
					.closest("li")
					.attr("data-id");
					
		// data-type
		var type = $(this)
					.closest("li")
					.attr("data-type");

		// ajax
		$.post(
			'http://localhost/mvc/app/cc/model/ajax/visibility.php',
			{
				id: id,
				type: type
			},
			function(result){
				if (result) {
					$(row).toggleClass("status-invisible");
					console.log(result);
				} else {
					console.log('Failure');
				}
			},  
			"html"  
		);			
	});	
	

	/**
	  * .js-liveSearch
	  */
	$('.js-liveSearch').bind('keyup', function() { 
		$(this)
			.closest("form")
			.delay(200, 0)
			.submit();
		// Live
		$(".js-delete").on("click", mvcDelete);	
		$(".js-tick").on("click", mvcTick);				
	});
	
	$('.liveSearch input').blur(function() {
		if( !$(this).val() ) {
			$(".results").html(""); // remove all rows
			$(".results").append($resultRows); // remove all rows
		}
		
		// Live
		$(".js-delete").on("click", mvcDelete);	
		$(".js-tick").on("click", mvcTick);	
	});	

	$(".liveSearch").submit(function (event) {
	
		$(".results .row").remove(); // remove all rows
	
		event.preventDefault();
		var $search = $('.liveSearch input').val();
		
		// ajax
		$.post(
			$urlBase + "app/cc/model/ajax-posts-liveSearch.php",
			{ type: $resultRowsType, search: $search },
			function(result){
				if (result) {
					$(".results").append(result);
					console.log("Success!");					
				} else {
					$(".results").append("No Results");
					console.log('Failure');
				}
			},  
			"html"  
		);			
	
	});	
	
	/**
	  * .results .row
	 
	function postEdit() {
		console.log($(this));
		$(this)
			.closest("li")
			.toggleClass("ticked");
	} */
	
	/**
	  * .results .row .tick
	  */
	function mvcTick() {
		console.log($(this));
		$(this)
			.closest("li")
			.toggleClass("ticked");
	}	

	/**
	  * .js-delete
	  */	
	function mvcDelete() {
		
		if (confirm('Delete this permanently?')) {
			
			// row
			var row = $(this).closest(".row");
		
			// id
			var id = row.attr("data-id");
						
			// ajax
			$.post(
				$urlBase + "app/cc/model/ajax-content-delete.php",
				{ id: id },
				function(result) {
					if (result) {
					
						console.log(result);
						
						// remove table row
						$(row).remove();
							
					} else {
					
						console.log('Failure');
					
					}
				},  
				"html"  
			);			
			
		}
		
	}

	/**
	  * .user dropdown
	  * @todo how to make dynamic?
	  */
	$(".user").click(function() {
	
		var drop = $(this).find('.drop');
		$(this).toggleClass('active');
		
		if ($(this).hasClass('active') == true) {
			drop.show();
		} else {
			drop.hide();
		}
		
		//var visibility = $(this).find('.drop').is(":visible");
		
		/*
		if (visibility == true) {
			drop.hide();
		} else {
			drop.show();
		}*/
	});
	
	// Clicking Away from the Panel
	$(document).mouseup(function() {
		$(".user").removeClass('active');	
		$(".drop").hide();
	});
	
	
	// Detect Mouse Clicks which are OK
	$(".drop").mouseup(function() {
		return false;
	});
	$(".user").mouseup(function() {
		return false
	});



	
	
	
	
	
	
	
	
	
	// Live
	$(".js-delete").on("click", mvcDelete);	
	$(".js-tick").on("click", mvcTick);				
	
});