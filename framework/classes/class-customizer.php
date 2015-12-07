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
		 * Add Content bg color
		 */
		$wp_customize->add_setting(
			'content_background',
			array(
				'default'     => '#fff',
				'transport'   => 'postMessage'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'content_background',
				array(
					'label'      => __( 'Content Backgound Color', 'aus-basic' ),
					'section'    => 'colors',
					'settings'   => 'content_background'
				)
			)
		);

		/**
		 * Add Input bg color
		 */
		$wp_customize->add_setting(
			'input_bg_color',
			array(
				'default'     => '#fff',
				'transport'   => 'postMessage'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'input_bg_color',
				array(
					'label'      => __( 'Input Background Color', 'aus-basic' ),
					'section'    => 'colors',
					'settings'   => 'input_bg_color'
				)
			)
		);

		/**
		 * Add Logo image setting
		 */
		$wp_customize->add_setting(
			'logo_img',
			array(
				'default'	  => '',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control( 
			new WP_Customize_Image_Control( 
				$wp_customize, 
				'logo_img', 
				array(
					'label'    => __( 'Logo', 'aus-basic' ),
					'section'  => 'header_image',
					'settings' => 'logo_img',
				) 
			) 
		);

		/**
		 * Add site description toggle checkbox
		 */
		$wp_customize->add_setting(
			'site_description',
			array(
				'default'	  => true,
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'site_description',
			array(
				'section'	  => 'header_image',
				'label'		  => __( 'Site description', 'aus-basic' ),
				'type'		  => 'checkbox',
			)
		);

		/**
		 * Add Home menu toggle
		 */
		$wp_customize->add_setting(
			'show_home_menu',
			array(
				'default'	  => true,
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'show_home_menu',
			array(
				'section'	  => 'nav',
				'label'		  => __( 'Show Home Menu', 'aus-basic' ),
				'type'		  => 'checkbox',
			)
		);

		/**
		 * Add Home menu text
		 */
		$wp_customize->add_setting(
			'home_menu_text',
			array(
				'default'	  => 'Home',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'home_menu_text',
			array(
				'section'	  => 'nav',
				'label'		  => __( 'Show Menu Text', 'aus-basic' ),
				'type'		  => 'text',
			)
		);
		

		/**
		 * Add header backgound image setting
		 */
		/*
		$wp_customize->add_setting(
			'header_backgorund',
			array(
				'default'	  => get_template_directory_uri() . '/media/img/header_bg.png',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control( 
			new WP_Customize_Image_Control( 
				$wp_customize, 
				'header_backgorund', 
				array(
					'label'    => __( 'Header backgound', 'aus-basic' ),
					'section'  => 'header_image',
					'settings' => 'header_backgorund',
				) 
			) 
		);
		*/
	
		/**
		 * Add Header Background image repeat
		 */
		$wp_customize->add_setting(
			'header_backgorund_repeat',
			array(
				'default'	  => 'repeat',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'header_backgorund_repeat',
			array(
				'section'	  => 'header_image',
				'label'		  => __( 'Header backgound repeat', 'aus-basic' ),
				'type'		  => 'radio',
				'choices'	  => array(
					'no-repeat'			=> __( 'No Repeat', 'aus-basic' ),
					'repeat'			=> __( 'Title', 'aus-basic' ),
					'repeat-x'			=> __( 'Title Horizontally', 'aus-basic' ),
					'repeat-y'			=> __( 'Title Vertically', 'aus-basic' ),
				)
			)
		);

		/**
		 * Add Header Background image position
		 */
		$wp_customize->add_setting(
			'header_backgorund_position_x',
			array(
				'default'	  => 'center',
				'transport'	  => 'postMessage'
			)
		);

		$wp_customize->add_control(
			'header_backgorund_position_x',
			array(
				'section'	  => 'header_image',
				'label'		  => __( 'Header backgound horizontal position', 'aus-basic' ),
				'type'		  => 'radio',
				'choices'	  => array(
					'left'			=> __( 'Left', 'aus-basic' ),
					'center'		=> __( 'Center', 'aus-basic' ),
					'right'			=> __( 'Right', 'aus-basic' ),
				)
			)
		);

		$wp_customize->add_setting(
			'header_backgorund_position_y',
			array(
				'default'	  => 'top',
				'transport'	  => 'postMessage'
			)
		);

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
					'unite'				=> __( 'Unite', 'aus-basic' ),
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