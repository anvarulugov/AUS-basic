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
		'title'		=> 'Generals',
		'icon'		=> 'fa-cog',
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
					'container' 		=> 'boxed.png',
					'container-fluid'		=> 'full.png',
				),
				'description'	=> __( 'Logo text description', 'aus-basic' ),
			),
			array(
				'id'				=> 'home_menu_text',
				'title'			=> __( 'Home menu text', 'aus-basic' ),
				'type'			=> 'text',
				'description'	=> __( 'Insert home menu text', 'aus-basic' ),
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

			array(
				'id'				=> 'home_menu_text',
				'title'			=> __( 'Home menu text', 'aus-basic' ),
				'type'			=> 'text',
				'description'	=> __( 'Insert home menu text', 'aus-basic' ),
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
			array(
				'id'				=> 'home_menu_text',
				'title'			=> __( 'Home menu text', 'aus-basic' ),
				'type'			=> 'text',
				'description'	=> __( 'Insert home menu text', 'aus-basic' ),
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
		'id'		=> 'homepage',
		'title' 	=> 'Home Page',
		'icon'		=> 'fa-home',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'header',
		'title' 	=> 'Header',
		'icon'		=> 'fa-facebook',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'archive',
		'title' 	=> 'Archives',
		'icon'		=> 'fa-list',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'article',
		'title' 	=> 'Article',
		'icon'		=> 'fa-file',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'homepage',
		'title' 	=> 'Home Page',
		'icon'		=> 'fa-twitter',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'header',
		'title' 	=> 'Header',
		'icon'		=> 'fa-youtube',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'archive',
		'title' 	=> 'Archives',
		'icon'		=> 'fa-google',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'article',
		'title' 	=> 'Article',
		'icon'		=> 'fa-th',
		'fields'	=> array(),
	),
	array(
		'id'		=> 'typography',
		'title'	=> 'Typography',
		'icon'		=> 'fa-text-width',
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
	'page' => array(
		'id' 		=> 'aus_post_settings',
		'title' 	=> __( 'Post Settings', 'aus-basic' ),
		'context' 	=> 'normal',
		'priority' 	=> 'high',
		'fields' 	=> array(
			array(
				'id'			=> 'item_layout_style',
				'title'			=> __( 'Layout', 'aus-basic' ),
				'type'			=> 'radioimage',
				'description'	=> __( 'Logo text description', 'aus-basic' ),
				'value'			=> 'col3',
				'options'		=> array(
					'col1'	=> 'content-1c.png',
					'col3' 	=> 'content-3c.png',
					'col2l'	=> 'content-2c-l.png',
					'col2r'	=> 'content-2c-r.png',
					
				),
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