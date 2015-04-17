<?php 

function content_class( $class = '' ) {
	if ( ! empty( $class ) )
		$class = ' '.$class;
	if ( is_active_sidebar( 'left' ) && is_active_sidebar( 'right' ) ) {
		$width = 'class="col-lg-6 col-md-6 col-sm-12' . $class . '"';
	} elseif ( is_active_sidebar( 'left' ) || is_active_sidebar( 'right' ) ) {
		$width = 'class="col-lg-9 col-md-9 col-sm-12' . $class . '"';
	} else {
		$width = 'class="col-sm-12' . $class . '"';
	}
	echo $width;
}

function sidebar_class( $class = '' ) {
	if ( ! empty( $class ) )
		$class = ' '.$class;
	echo 'class="sidebar col-lg-3 col-md-3 col-sm-12' . $class . '"';
}

add_action( 'aus_after_post', 'aus_hit_count' );
function aus_hit_count() {
	global $post;
	$curr_hit = get_post_meta( $post->ID, 'aus_hits', true );
	if ( is_singular() ) {
		update_post_meta( $post->ID, 'aus_hits', ($curr_hit + 1) );
	}
}

add_filter('the_content', 'aus_lightbox_post_image');
function aus_lightbox_post_image ( $content ) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1 data-lightbox="post-image" href=$2$3.$4$5$6</a>';
	$content = preg_replace($pattern, $replacement, $content);
	//$content = str_replace("%LIGHTID%", $post->ID, $content);
	return $content;
}

add_filter( 'wp_link_pages_link',  'aus_link_pages_link' );
function aus_link_pages_link( $link ) {
	$current = strpos( $link, 'href' );
	return '<li ' . ( ! $current ? 'class="active"' : '' ) . '>' . $link . '</li>';
}

add_action( 'tgmpa_register', 'aus_register_required_plugins' );
function aus_register_required_plugins() {
	$plugins = array(
 
		array(
			'name'               => 'AUS Basic Utils',
			'slug'               => 'aus-basic-utils',
			'source'             => 'aus-basic-utils.zip',
			'required'           => true,
			'version'            => '0.0.1',
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