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

		/**
		 * Register Layout Section
		 */
		$wp_customize->add_section(
			'aus_basic_options',
			array(
				'title'		  => __( 'Layout', 'aus-basic' ),
				'priority'	  => 200
			)
		);

		/**
		 * Add Container style selector
		 */
		$wp_customize->add_setting(
			'container_width',
			array(
				'default'	  => 'container',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'container_width',
			array(
				'section'	  => 'aus_basic_options',
				'label'		  => __( 'Container type', 'aus-basic' ),
				'type'		  => 'select',
				'choices'	  => array(
					'container'			=> __( 'Boxed', 'aus-basic' ),
					'container-fluid'	=> __( 'Full', 'aus-basic' ),
				)
			)
		);

		/**
		 * Add CSS theme selector
		 */
		$wp_customize->add_setting(
			'css_theme',
			array(
				'default'	  => 'bootstrap',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'css_theme',
			array(
				'section'	  => 'aus_basic_options',
				'label'		  => __( 'CSS Theme', 'aus-basic' ),
				'type'		  => 'select',
				'choices'	  => array(
					'bootstrap'			=> __( 'Bootstrap', 'aus-basic' ),
					'cerulean'			=> __( 'Cerulean', 'aus-basic' ),
					'cosmo'				=> __( 'Cosmo', 'aus-basic' ),
					'cyborg'			=> __( 'Cyborg', 'aus-basic' ),
					'darkly'			=> __( 'Darkly', 'aus-basic' ),
					'flatly'			=> __( 'Flatly', 'aus-basic' ),
					'journal'			=> __( 'Journal', 'aus-basic' ),
					'lumen'				=> __( 'Lumen', 'aus-basic' ),
					'paper'				=> __( 'Paper', 'aus-basic' ),
					'readable'			=> __( 'Readable', 'aus-basic' ),
					'sandstone'			=> __( 'Sandstone', 'aus-basic' ),
					'simplex'			=> __( 'Simplex', 'aus-basic' ),
					'slate'				=> __( 'Slate', 'aus-basic' ),
					'spacelab'			=> __( 'Spacelab', 'aus-basic' ),
					'superhero'			=> __( 'Superhero', 'aus-basic' ),
					'united'			=> __( 'United', 'aus-basic' ),
					'yeti'				=> __( 'Yeti', 'aus-basic' ),
				)
			)
		);

		/**
		 * Add Sidebars selector
		 */
		$wp_customize->add_setting(
			'item_layout_style',
			array(
				'default'	  => 'col3',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'item_layout_style',
			array(
				'section'	  => 'aus_basic_options',
				'label'		  => __( 'Sidebars', 'aus-basic' ),
				'type'		  => 'select',
				'choices'	  => array(
					'col1'				=> __( 'Content Only', 'aus-basic' ),
					'col3'				=> __( 'Three column', 'aus-basic' ),
					'col2l'				=> __( 'Left & Content', 'aus-basic' ),
					'col2r'				=> __( 'Right & Content', 'aus-basic' ),
				)
			)
		);

	}

	public function header_output() {
		echo "
			<script>
			function get_template_directory_uri() {
				return '" . get_template_directory_uri() . "';
			}
			</script>
		";
	}

	public function live_preview() {
		wp_enqueue_script(
			'aus-basic-customizer',
			get_aus_uri() . '/media/js/customizer.js',
			array( 'jquery', 'customize-preview' ),
			'0.3.0',
			true
		);

	}

}
new AUS_Customizer();