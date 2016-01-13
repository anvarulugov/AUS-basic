<?php 


class AUS_Elements {

	public function __construct() {
		
		/* Define framework, parent theme, and child theme constants. */
		add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );

		/* Load the core functions required by the rest of the framework. */
		add_action( 'after_setup_theme', array( $this, 'core' ), 2 );

		/* Load the framework functions. */
		add_action( 'after_setup_theme', array( $this, 'functions' ), 13 );
		
	}

	public function constants() {
		
		/* Sets the framework version number. */
		define( 'AUS_VERSION', '1.0.0' );

		/* Sets the path to the parent theme directory. */
		define( 'THEME_DIR', get_template_directory() );

		/* Sets the path to the parent theme directory URI. */
		define( 'THEME_URI', get_template_directory_uri() );

		/* Sets the path to the child theme directory. */
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

		/* Sets the path to the child theme directory URI. */
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		/* Sets the path to the core framework directory. */
		define( 'AUS_DIR', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework directory URI. */
		define( 'AUS_URI', trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework classes directory. */
		define( 'AUS_CLASSES', trailingslashit( AUS_DIR ) . 'classes' );

		/* Sets the path to the core framework functions directory. */
		define( 'AUS_FUNCTIONS', trailingslashit( AUS_DIR ) . 'functions' );

		/* Sets the path to the core framework widgets directory. */
		define( 'AUS_WIDGETS', trailingslashit( AUS_DIR ) . 'widgets' );

		/* Sets the path to the core framework shortcodes directory. */
		define( 'AUS_SHORTCODES', trailingslashit( AUS_DIR ) . 'shortcodes' );

	}

	public function core() {

		// Load framework functions
		require_once( trailingslashit( AUS_DIR ) . 'functions.php' );

		// Load input field render class
		require_once( trailingslashit( AUS_CLASSES ) . 'class-input.php' );

		// Load theme elements generator class
		require_once( trailingslashit( AUS_FUNCTIONS ) . 'elements.php' );
	}

	public function functions() {

		/* Load the TGM if supported. */
		require_if_theme_supports( 'tgm', trailingslashit( AUS_CLASSES ) . 'class-tgm.php' );

		/* Load the theme options default configs if supported. */
		require_if_theme_supports( 'theme-options', trailingslashit( AUS_DIR ) . 'defaults.php' );

		/* Load the theme options if supported. */
		require_if_theme_supports( 'theme-options', trailingslashit( AUS_CLASSES ) . 'class-options.php' );

		/* Load the theme options if supported. */
		require_if_theme_supports( 'theme-customizer', trailingslashit( AUS_CLASSES ) . 'class-customizer.php' );

		/* Load the custom metaboxes if supported. */
		require_if_theme_supports( 'custom-metabox', trailingslashit( AUS_CLASSES ) . 'class-metabox.php' );

		/* Load the widgets if supported. */
		require_if_theme_supports( 'aus-core-widgets', trailingslashit( AUS_FUNCTIONS ) . 'core-widgets.php' );

		/* Load the widgets if supported. */
		require_if_theme_supports( 'aus-shortcodes', trailingslashit( AUS_FUNCTIONS ) . 'shortcodes.php' );

	}

	public function shortcodes() {

	}

}
