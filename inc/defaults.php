<?php 

$aus_options = array(
	'featured_cat' => false,
	'thumbnail_size' => 'thumbnail',
	'thumbnail_img' => '',//get_template_directory_uri() . '/media/img/thumbnail.png',
	'logo_img' => '',//get_template_directory_uri() . '/media/img/logo.png',
	'show_home_menu' => 'on',
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
				'id'				=> 'container_width',
				'title'			=> __( 'Layout', 'aus-basic' ),
				'type'			=> 'radioimage',
				'options'		=> array(
					'container' 		=> 'http://localhost/wpdemo/wp-content/themes/jarida_2.0.0/panel/images/boxed.png',
					'container-fluid'		=> 'http://localhost/wpdemo/wp-content/themes/jarida_2.0.0/panel/images/full.png',
				),
				'description'	=> __( 'Logo text description', 'aus-basic' ),
			),
			array(
				'id'			=> 'show_home_menu',
				'title'			=> __( 'Home menu', 'aus-basic' ),
				'type'			=> 'select',
				'options'		=> array(
					'on'		=> __( 'Show', 'aus-basic' ),
					'off'		=> __( 'Hide', 'aus-basic' ),
				),
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

$aus_metaboxes = array(
	'post' => array(
		'id' 		=> 'aus_post_settings',
		'title' 	=> __( 'Post Settings', 'aus-basic' ),
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'fields' 	=> array(
			array(
				'id'			=> 'content_width',
				'title'			=> __( 'Layout', 'aus-basic' ),
				'type'			=> 'radioimage',
				'description'	=> __( 'Logo text description', 'aus-basic' ),
				'options'		=> array(
					'container' 		=> 'http://localhost/wpdemo/wp-content/themes/jarida_2.0.0/panel/images/boxed.png',
					'container-fluid'	=> 'http://localhost/wpdemo/wp-content/themes/jarida_2.0.0/panel/images/full.png',
				),
			),
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
	'metaboxes'		=> $aus_metaboxes,
);