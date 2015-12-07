/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update content background color
	wp.customize( 'content_background', function( value ) {
		value.bind( function( newval ) {
			$( '.content' ).css( 'background-color', newval );
		} );
	} );

	// Update input background color
	wp.customize( 'input_bg_color', function( value ) {
		value.bind( function( newval ) {
			$( '.form-control, textarea, input' ).css( 'background-color', newval );
		} );
	} );

	// Update container style
	wp.customize( 'container_width', function( value ) {
		value.bind( function( newval ) {
			$( '.container-layout' ).attr('class','container-layout');
			$( '.container-layout' ).addClass( 'container-layout ' + newval );
		} );
	} );

	// Update CSS theme
	wp.customize( 'css_theme', function( value ) {
		value.bind( function( newval ) {
			var new_css;
			switch( newval ) {
				case 'cerulean':
					new_css = 'cerulean';
					break;
				case 'cosmo':
					new_css = 'cosmo';
					break;
				case 'cyborg':
					new_css = 'cyborg';
					break;
				case 'darkly':
					new_css = 'darkly';
					break;
				case 'flatly':
					new_css = 'flatly';
					break;
				case 'journal':
					new_css = 'journal';
					break;
				case 'lumen':
					new_css = 'lumen';
					break;
				case 'paper':
					new_css = 'paper';
					break;
				case 'readable':
					new_css = 'readable';
					break;
				case 'sandstone':
					new_css = 'sandstone';
					break;
				case 'simplex':
					new_css = 'simplex';
					break;
				case 'slate':
					new_css = 'slate';
					break;
				case 'spacelab':
					new_css = 'spacelab';
					break;
				case 'yeti':
					new_css = 'yeti';
					break;
				case 'unite':
					new_css = 'unite';
					break;
				case 'yeti':
					new_css = 'yeti';
					break;
				default:
					new_css = 'bootstrap';
					break;
			}
			$( '#bootstrap-css' ).attr( 'href', get_template_directory_uri() + '/media/css/' + new_css + '.min.css' );
		} );
	} );

	// Update sidebars
	wp.customize( 'item_layout_style', function( value ) {
		value.bind( function( newval ) {
			switch( newval ) {
				case 'col1':
					$( '.left, .right' ).hide();
					$( '.content ' ).attr( 'class', 'content col-sm-12' );
					break;
				case 'col2l':
					$( '.right' ).hide();
					$( '.left' ).show();
					$( '.left' ).attr( 'class', 'sidebar left col-sm-6 col-md-3 col-md-pull-9' );
					$( '.content ' ).attr( 'class', 'content col-lg-9 col-md-push-3 col-md-9 col-sm-12' );
					break;
				case 'col2r':
					$( '.left' ).hide();
					$( '.right' ).show();
					$( '.right' ).attr( 'class', 'sidebar right col-sm-6 col-md-3' );
					$( '.content ' ).attr( 'class', 'content col-lg-9 col-md-9 col-sm-12' );
					break;
				case 'col3':
				default:
					$( '.left' ).show();
					$( '.right' ).show();
					$( '.left' ).attr( 'class', 'sidebar left col-sm-6 col-md-3 col-md-pull-6' );
					$( '.right' ).attr( 'class', 'sidebar right col-sm-6 col-md-3' );
					$( '.content ' ).attr( 'class', 'content col-lg-6 col-md-push-3 col-md-6 col-sm-12' );
					break;
			}
		} );
	} );
	
} )( jQuery );