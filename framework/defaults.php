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
		'id'		=> 'general',
		'title'		=> 'General',
		'icon'		=> 'fa-cog',
		'sections'	=> array(
			array(
				'id'	 => 'layout',
				'title'  => 'Layout Settings',
				'fields' => array(
					array(
						'id'				=> 'container_width',
						'title'			=> __( 'Layout', 'aus-basic' ),
						'type'			=> 'radioimage',
						'options'		=> array(
							'container' 		=> 'boxed.png',
							'container-fluid'		=> 'full.png',
						),
						'description'	=> __( 'Choose layout style', 'aus-basic' ),
					),
				),
			),
			array(
				'id'	 => 'bbpress',
				'title'  => 'bbPress Settings',
				'fields' => array(
					array(
						'id'	=> 'bbpress',
						'title' => 'bbPress Full width',
						'type'	=> 'checkbox',
						'description' 	=> 'Enable bbPress Full width',
					),
				),
			),
			array(
				'id' 	 => 'favicon',
				'title'  => 'Custom Favicon',
				'fields' => array(
					array(
						'id'	=> 'favicon',
						'title' => 'Favicon',
						'type'	=> 'image',
						'description' 	=> 'Enter url or upload favicon icon file',
					),
				),
			),
			array(
				'id'	 => 'gravatar',
				'title'  => 'Custom Gravatar',
				'fields' => array(
					array(
						'id'	=> 'gravatar',
						'title' => 'Custom Gravatar',
						'type'	=> 'image',
						'description' 	=> 'Enter url or upload avatar image file',
					),
				),
			),
		),
	),
	array(
		'id'		=> 'homepage',
		'title'		=> 'Homepage',
		'icon'		=> 'fa-home',
		'sections'	=> array(
			array(
				'id'	 => 'homepage_style',
				'title'  => 'Home page displays',
				'fields' => array(
					array(
						'id'				=> 'homepage_display',
						'title'			=> __( 'Home page displays', 'aus-basic' ),
						'type'			=> 'radio',
						'options'		=> array(
							'latest_posts' 		=> __( 'Latest posts - Blog Layout', 'aus-basic' ),
							'home_builder' 		=> __( 'News Boxes - use Home Builder', 'aus-basic' ),
						),
						//'description'	=> __( 'Choose layout style', 'aus-basic' ),
					),
				),
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
	'menutype'		=> 'toplevel',
	'tabs'			=> $aus_tabs,
	'metaboxes'		=> $aus_metaboxes,
);