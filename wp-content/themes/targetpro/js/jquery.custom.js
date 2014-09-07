/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/
 


jQuery(document).ready(function() {
								
								
 if (jQuery().cycle) {	
 
 jQuery('#slideshow').after('<div id="nav">').cycle({ 
   		fx: 'scrollLeft',
        speed:  'slow',
		easing: 'easeInOutQuad',
        timeout: 5000,
        pager:  '#nav'

});

}


jQuery('ul.dropdown ul').css('display', 'none');

	jQuery('ul.dropdown li').hover(
		function () {
			//show its submenu
			jQuery('ul', this).slideDown(250);
		}, 
		function () {
			//hide its submenu
			jQuery('ul', this).slideUp(250);	
		}
	);
							

});