<?php 

if ( ! function_exists( 'get_aus_uri' ) ) :
function get_aus_uri() {
	$url = get_template_directory_uri() . '/' . basename(__DIR__);
	return $url;
}
endif;

function aus_configs( $key = false ) {
	$aus_config = '';
	if ( has_filter( 'aus_register_configs' ) ) {
		$aus_config = apply_filters( 'aus_register_configs', $aus_config );
	}
	if ( $aus_config[ $key ] ) {
		return $aus_config[ $key ];
	}
	return $aus_config;
}

function aus_options( $key = false ) {
	$aus_options = '';
	if ( has_filter( 'aus_register_options' ) ) {
		$aus_options = apply_filters( 'aus_register_options', $aus_options );
	}
	if ( $aus_options[ $key ] ) {
		return $aus_options[ $key ];
	}
	return $aus_options;
}

function aus_settings( $option, $default = false ) {
	
	$aus_config = aus_configs();
	$aus_options = aus_options();

	if ( 'customizer' == $aus_config['options_type'] ) {
		return get_theme_mod( $option, $default );
	} else {
		$options = get_option( $aus_config['theme_slug'] . '_theme_options', $aus_options );
		if( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}
	}
	
	return $default;

}

function aus_is_active_menu( $type, $id ) {
	switch ($type) {
		case 'page':
		default:
			if( is_page( $id ) )
				return true;
			break;
		case 'category':
			if( is_category( $id ) )
				return true;
			break;
	}
	return false;
}

if ( ! function_exists( 'aus_item_settings' ) ) :
function aus_item_settings( $option, $default = false ) {
	global $post;
	if ( get_post_meta( $post->ID, $option, true ) ) {
		return get_post_meta( $post->ID, $option, true );
	} elseif ( aus_settings( $option, $default ) ) {
		return aus_settings( $option, $default );
	}
	return $default;
}
endif;

if ( ! function_exists( 'container_class' ) ) :
function container_class( $class = '' ) {
	echo get_container_class( $class );
}
endif;

if ( ! function_exists( 'get_container_class' ) ) :
function get_container_class( $class = '' ) {
	if ( ! empty( $class ) )
		$class = ' '.$class;

	return 'class="container-layout ' . aus_settings( 'container_width', 'container' ) . $class . '"';
}
endif;

if ( ! function_exists( 'content_class' ) ) :
function content_class( $class = '' ) {

	$layout = aus_item_settings( 'item_layout_style', 'col3' );

	if ( ! empty( $class ) )
		$class = ' '.$class;
	if ( $layout == 'col3' ) {
		$width = 'class="col-lg-6 col-md-push-3 col-md-6 col-sm-12' . $class . '"';
	} elseif ( $layout == 'col2l' ) {
		$width = 'class="col-lg-9 col-md-push-3 col-md-9 col-sm-12' . $class . '"';
	} elseif ( $layout == 'col2r' ) {
		$width = 'class="col-lg-9 col-md-9 col-sm-12' . $class . '"';
	} else {
		$width = 'class="col-sm-12' . $class . '"';
	}
	echo $width;
}
endif;

if ( ! function_exists( 'sidebar_class' ) ) :
function sidebar_class( $class = '' ) {
	if ( ! empty( $class ) )
		$class = ' '.$class;
	echo 'class="sidebar col-sm-6 col-md-3' . $class . '"';
}
endif;

add_action( 'aus_after_post', 'aus_hit_count' );
function aus_hit_count() {
	global $post;
	$curr_hit = get_post_meta( $post->ID, 'aus_hits', true );
	if ( is_singular() ) {
		update_post_meta( $post->ID, 'aus_hits', ($curr_hit + 1) );
	}
}

//add_filter('the_content', 'aus_lightbox_post_image');
if ( ! function_exists( 'aus_lightbox_post_image' ) ) :
function aus_lightbox_post_image ( $content ) {
	global $post;
	$pattern = "/<a(.*)href=('|\")(.*?).(jpg|jpeg|gif|png|bmp)('|\")(.*?)><img/i";
	$replacement = '<a$1data-lightbox="post-image" href=$2$3.$4$5$6><img';
	$content = preg_replace($pattern, $replacement, $content);
	//$content = str_replace("%LIGHTID%", $post->ID, $content);
	return $content;
}
endif;

add_filter( 'wp_link_pages_link',  'aus_link_pages_link' );
if ( ! function_exists( 'aus_link_pages_link' ) ) :
function aus_link_pages_link( $link ) {
	$current = strpos( $link, 'href' );
	return '<li ' . ( ! $current ? 'class="active"' : '' ) . '>' . $link . '</li>';
}
endif;

add_action( 'tgmpa_register', 'aus_register_required_plugins' );
if ( ! function_exists( 'aus_register_required_plugins' ) ) :
function aus_register_required_plugins() {
	$plugins = array(
 
		array(
			'name'               => 'AUS Basic Utils',
			'slug'               => 'aus-basic-utils',
			'source'             => 'aus-basic-utils.zip',
			'required'           => false,
			'version'            => '0.0.1',
			'force_activation'   => false,
			'force_deactivation' => false,
		),

		array(
			'name'               => 'Page Builder by WooRockets.com',
			'slug'               => 'wr-pagebuilder',
			'required'           => false,
			'version'            => '2.5.3',
			'force_activation'   => false,
			'force_deactivation' => false,
		),
 
	);

	$config = array(
		'default_path' => get_stylesheet_directory() . '/plugins/', // Default absolute path to pre-packaged plugins.
		'menu'         => 'aus-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'aus-basic' ),
			'menu_title'                      => __( 'Install Plugins', 'aus-basic' ),
			'installing'                      => __( 'Installing Plugin: %s', 'aus-basic' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'aus-basic' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'aus-basic' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'aus-basic' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'aus-basic' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}
endif;

/**
 * Adding default widgets markup Bootstrap classes
 */
add_filter( 'get_search_form' , 'aus_search_form' , 2 ) ;
if ( ! function_exists( 'aus_search_form' ) ) :
function aus_search_form( $markup ) {
	$markup = str_replace( 'class="search-form"' , 'class="search-form row"' , $markup ) ;
	$markup = str_replace( '<label' , '<label class="col-xs-12"' , $markup ) ;
	$markup = str_replace( '<input type="search"' , '<input type="search" class="form-control search-input"' , $markup ) ;
	$markup = preg_replace( '/(<span class="screen-reader-text">.*?>)/' , '' , $markup ) ;
	$markup = preg_replace( '/(<input type="submit".*?>)/' , '' , $markup ) ;
	return $markup;
}
endif;

add_filter( 'get_calendar' , 'aus_calendar' , 2 ) ;
if ( ! function_exists( 'aus_calendar' ) ) :
function aus_calendar( $markup ) {
	$markup = str_replace( '<table id="wp-calendar"' , '<table id="wp-calendar" class="table table-stripped"' , $markup ) ;
	return $markup;
}
endif;

function aus_isajax() {
	if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
		return true;
	} else {
		return false;
	}
}

add_action( 'wp_head', 'aus_dynamic_css' );
if ( ! function_exists( 'aus_dynamic_css' ) ) :
function aus_dynamic_css() {
	$header_background = aus_settings( 'header_background', '#fff' );
	$content_background = aus_settings( 'content_background', '#fff' );
	$header_bg = aus_settings( 'header_backgorund' );
	$header_bg_repeat = aus_settings( 'header_backgorund_repeat', 'repeat' );
	$header_bg_position_x = aus_settings( 'header_backgorund_position_x', 'center' );
	$input_background = aus_settings( 'input_bg_color', '#fff' );
	?>
	<style>
	.header {
		background-color: <?php echo esc_attr($header_background); ?>;
		background-image: url(<?php echo esc_url( get_header_image() ); ?>);
		background-repeat: <?php echo esc_attr( $header_bg_repeat ); ?>;
		background-position-x: <?php echo esc_attr( $header_bg_position_x ); ?>;
		background-size: cover;
	}
	.content {
		background-color: <?php echo esc_attr( $content_background ); ?>;
	}
	.form-control,
	textarea,
	input {
		background-color: <?php echo esc_attr( $input_background ); ?>;
	}
	</style>
	<?php
}
endif;