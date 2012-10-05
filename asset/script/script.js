/**
  *	Script
  *	
  *	@package	mvc
  *	@desc		core script package for the control centre
  *	@author 	Martin Wyatt <martin.wyatt@gmail.com> 
  *	@version	0.1.7
  *	@license 	http://www.php.net/license/3_01.txt PHP License 3.01
  */ 

// temp flag
console.log('script.js initiated');  
  
/**
	run when document ready
*/  
$(document).ready(function() {
	
	/**
	  * .flexslider
	  */
	$('.flexslider').flexslider({
		animation: "slide",
		slideshowSpeed: 4000,
		animationSpeed: 400
	});
			
	/**
	  * .btn.search
	  */
	$(".btn.search").click(function() {
		$("form#search").slideToggle(100); // slide form up and down
		$("form#search input").val(null); // clear input
		$(this).toggleClass("close"); // change button
		$("form#search input").focus(); // focus on field
	});	
	
}); // document ready