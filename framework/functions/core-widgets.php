<?php 

class AUS_Widgets {

	public function __construct() {
		/* Unregister WP widgets. */
		add_action( 'widgets_init', array( $this, 'unregister_widgets' ) );
		/* Register Hybrid widgets. */
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}

	public function register_widgets() {
		/* Load the categories widget class. */
		require_once( trailingslashit( AUS_WIDGETS ) . 'widget-categories.php' );
		/* Register the categories widget. */
		register_widget( 'AUS_Widget_Categories' );
		/* Load the archives widget class. */
		require_once( trailingslashit( AUS_WIDGETS ) . 'widget-archives.php' );
		/* Register the archives widget. */
		register_widget( 'AUS_Widget_Archives' );
		/* Load the nav menu widget class. */
		require_once( trailingslashit( AUS_WIDGETS ) . 'widget-nav-menu.php' );
		/* Register the nav menu widget. */
		register_widget( 'AUS_Widget_Nav_Menu' );
		/* Load the recent comments widget class. */
		require_once( trailingslashit( AUS_WIDGETS ) . 'widget-recent-comments.php' );
		/* Register the recent comments widget. */
		register_widget( 'AUS_Recent_Comments' );
		/* Load the recent posts widget class. */
		require_once( trailingslashit( AUS_WIDGETS ) . 'widget-recent-posts.php' );
		/* Register the recent posts widget. */
		register_widget( 'AUS_Recent_Posts' );
	}

	public function unregister_widgets() {
		/* Unregister the default WordPress widgets. */
		unregister_widget( 'WP_Widget_Archives' );
		// unregister_widget( 'WP_Widget_Calendar' );
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_Recent_Comments' );
		// unregister_widget( 'WP_Widget_Links' );
		unregister_widget( 'WP_Nav_Menu_Widget' );
		// unregister_widget( 'WP_Widget_Pages' );
		// unregister_widget( 'WP_Widget_Search' );
		// unregister_widget( 'WP_Widget_Tag_Cloud' );
	}

}
new AUS_Widgets();