/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

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
			var css_theme;
			switch( newval ) {
				case 'yeti':
					css_theme = 'yeti';
					break;
				case 'paper':
					css_theme = 'paper';
					break;
				default:
					css_theme = 'bootstrap';
					break;
			}
			$( '#bootstrap-css' ).attr('href','');
			$( '#bootstrap-css' ).attr('href', get_template_directory_uri() + '/media/css/' + css_theme + '.min.css' );
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