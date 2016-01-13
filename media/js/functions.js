jQuery(document).ready(function($){
	
	/**
	  * NAME: Bootstrap 3 Triple Nested Sub-Menus
	  * This script will active Triple level multi drop-down menus in Bootstrap 3.*
	  */
	$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
		// Avoid following the href location when clicking
		event.preventDefault(); 
		// Avoid having the menu to close when clicking
		event.stopPropagation(); 
		// Re-add .open to parent sub-menu item
		$(this).parent().toggleClass('open');
	});
	
	$('.widget_search').removeClass('panel panel-default');

});