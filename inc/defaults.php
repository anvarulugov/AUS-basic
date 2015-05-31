<?php 

$aus_options = array(
	'featured_cat' => false,
	'thumbnail_size' => 'thumbnail',
	'thumbnail_img' => '',//get_template_directory_uri() . '/media/img/thumbnail.png',
	'logo_img' => '',//get_template_directory_uri() . '/media/img/logo.png',
	'show_home_menu' => true,
	'home_menu_text' => '',
);

$aus_tabs = array(
	array(
		'id'		=> 'generals',
		'title'	=> 'Generals',
		'fields'	=> array(
			array(
				'id'				=> 'logo_img',
				'title'			=> __( 'Logo Image', 'aus-basic' ),
				'type'			=> 'image',
				'description'	=> __( 'Insert image url or upload', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_text',
				'title'			=> __( 'Logo Text', 'aus-basic' ),
				'type'			=> 'text',
				'description'	=> __( 'Logo text description', 'aus-basic' ),
			),
			array(
				'id'				=> 'layout',
				'title'			=> __( 'Layout', 'aus-basic' ),
				'type'			=> 'radioimage',
				'options'		=> array(
					'box' 		=> 'http://localhost/wpdemo/wp-content/themes/jarida_2.0.0/panel/images/boxed.png',
					'full'		=> 'http://localhost/wpdemo/wp-content/themes/jarida_2.0.0/panel/images/full.png',
				),
				'description'	=> __( 'Logo text description', 'aus-basic' ),
			),
		),
	),
	array(
		'id'		=> 'typography',
		'title'	=> 'Typography',
		'fields'	=> array(
			array(
				'id'				=> 'fonts',
				'title'			=> __( 'Fonts', 'aus-basic' ),
				'type'			=> 'select',
				'options'		=> array( 'one' => 'One', 'two' => 'Two' ),
				'atts'			=> array( 'class' => 'test-class' ),
				'description'	=> __( 'Select fonts', 'aus-basic' ),
			),
			array(
				'id'				=> 'font_color',
				'title'			=> __( 'Font color', 'aus-basic' ),
				'type'			=> 'text',
				'atts'			=> array( 'class' => 'color-field' ),
				'description'	=> __( 'Logo text description', 'aus-basic' ),
			),
		),
	),
);

$aus_config = array(
	'theme_name'	=> 'AUS Basic',
	'theme_slug'	=> 'aus-basic',
	'menutype'		=> '',
	'tabs'			=> $aus_tabs,
);