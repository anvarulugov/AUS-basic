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
		// If a menu is already open we close it
		$('ul.dropdown-menu.dropdown-sub-menu [data-toggle=dropdown]').parent().removeClass('open');
		// Re-add .open to parent sub-menu item
		$(this).parent().toggleClass('open');
	});
	
	$('.widget_search').removeClass('panel panel-default');

	$('.aus-recent-comments a').on('mouseover',function() { 
		$(this).addClass('animated flipInX').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
			function() {
				$(this).removeClass('animated flipInX');
			}
	)});
	
});