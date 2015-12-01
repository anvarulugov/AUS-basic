<?php 

class AUS_Customizer {

	protected $options;

	public function __construct() {
		// Setup the Theme Customizer settings and controls...
		add_action( 'customize_register', array( $this, 'register' ) );
		// Output custom CSS to live site
		add_action( 'wp_head', array( $this, 'header_output' ) );
		// Enqueue live preview javascript in Theme Customizer admin screen
		add_action( 'customize_preview_init', array( $this, 'live_preview' ) );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_panel('aus_basic_header',
			array(
				'priority'       => 10,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			    'title'          => '',
			    'description'    => '',
			)
		);
	}

	public function header_output() {

	}

	public function live_preview() {

	}

}
new AUS_Customizer();