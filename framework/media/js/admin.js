jQuery(document).ready(function($){

	/**
	 * Height fix
	 */
	$(function() {
		var minHeight = $('.aus-panel-sidebar').height();
		$('.aus-panel').css('min-height', minHeight);
	});

	/**
	 * Save settings
	 */
	$(function() {
		$('body .aus-panel-section').on('click','#submit', function(e) {
			e.preventDefault();
			alert('Options are saved!');
		});
	});

	/**
	 * Magnificent theme options tabs switcher
	 */
	$(function() {
		$('body').on('click','.aus-panel-nav > li > a',function(e) {
			e.preventDefault();
			var tab = $(this).attr('href');
			$('.aus-panel-nav > li > a').removeClass('active');
			$(this).addClass('active');
			$('.aus-panel-section > li').removeClass('active');
			$('.aus-panel-section > li').hide();
			$(tab).fadeIn();
			$(tab).addClass('active');
		});
	});

	/**
	 * Simple theme options tabs switcher
	
	$(function() {
		$('body').on('click','.nav-tab-wrapper a',function(e) {
			e.preventDefault();
			var tab = $(this).attr('href')
			$('.nav-tab-wrapper a').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active');
			// $('.tab-content').fadeOut();
			$('.tab-content').removeClass('active');
			// $(tab).fadeIn();
			$(tab).addClass('active');
		});
	});
	 */
	
	$('.image-upload').click(function(e) {
		var image_field = $(this).data('field');
		var custom_uploader;
		e.preventDefault();
		//If the uploader object has already been created, reopen the dialog
		// if (custom_uploader) {
		//     custom_uploader.open();
		//     return;
		// }
		//Extend the wp.media object
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		//When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();
			$(image_field).val(attachment.url);
		});
		//Open the uploader dialog
		custom_uploader.open();
	});
	$(function() {
		$('.color-field').wpColorPicker();
	});
});