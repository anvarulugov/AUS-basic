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
		'fields'	=> array(
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
			array(
				'id'	=> 'bbpress',
				'title' => 'bbPress',
				'type'	=> 'checkbox',
				'description' 	=> 'Enable bbPress support',
			),
			array(
				'id'	=> 'favicon',
				'title' => 'Favicon',
				'type'	=> 'image',
				'description' 	=> 'Enter url or upload favicon icon file',
			),
			array(
				'id'	=> 'gravatar',
				'title' => 'Custom Gravatar',
				'type'	=> 'image',
				'description' 	=> 'Enter url or upload avatar image file',
			),
			array(
				'id'	=> 'iphoneicon',
				'title' => 'Apple iPhone Icon',
				'type'	=> 'image',
				'description' 	=> 'Enter url or upload avatar image file',
			),
			array(
				'id'	=> 'iphoneretinaicon',
				'title' => 'Apple iPhone Retina Icon',
				'type'	=> 'image',
				'description' 	=> 'Enter url or upload avatar image file',
			),
			array(
				'id'	=> 'ipadicon',
				'title' => 'Apple iPad Icon',
				'type'	=> 'image',
				'description' 	=> 'Enter url or upload avatar image file',
			),
			array(
				'id'	=> 'ipadretinaicon',
				'title' => 'Apple iPad Retina Icon',
				'type'	=> 'image',
				'description' 	=> 'Enter url or upload avatar image file',
			),
			array(
				'id'	=> 'timeformat',
				'title' => 'Time format',
				'type'	=> 'radio',
				'options' => array(
					'traditional' => __( 'Traditional', 'aus-basic' ),
					'timeago' => __( 'Time Ago Format', 'aus-basic' ),
					'disableall' => __( 'Disable all', 'aus-basic' ),
				),
				'description' 	=> 'Time format for blog posts',
			),
			array(
				'id'	=> 'breadcrumbs',
				'title' => 'Breadcrumbs',
				'type'	=> 'checkbox',
				'description' 	=> 'Enable breadcrumbs',
			),
			array(
				'id'	=> 'breadcrumbsdelimiter',
				'title' => 'Breadcrumbs Delimiter',
				'type'	=> 'text',
				'atts'	=> array( 'size' => 3 ),
				'description' 	=> 'Breadcrumbs Delimiter character',
			),
			array(
				'id'	=> 'headercode',
				'title' => 'Header Code',
				'type'	=> 'textarea',
				'editor' => array( 
					'visual' => false,
					'textarea_rows' => 10,
					'textarea_cols' => 10,
				),
				'atts'	=> array(
					'rows' => 7,
					'style' => 'width:100%;',
				),
				'description' 	=> 'The following code will add to the <head> tag. Useful if you need to add additional scripts such as CSS or JS.',
			),
			array(
				'id'	=> 'footercode',
				'title' => 'Footer  Code',
				'type'	=> 'textarea',
				'editor' => array( 
					'visual' => false,
					'textarea_rows' => 10,
					'textarea_cols' => 10,
				),
				'atts'	=> array(
					'rows' => 7,
					'style' => 'width:100%;',
				),
				'description' 	=> 'The following code will add to the footer before the closing </body> tag. Useful if you need to Javascript or tracking code.',
			),
		),
	),
	array(
		'id'		=> 'homepage',
		'title' 	=> 'Home Page',
		'icon'		=> 'fa-home',
		'fields'	=> array(
			array(
				'id'	=> 'homestyle',
				'title' => 'Home page displays',
				'type'	=> 'radio',
				'options' => array(
					'latesposts' => __( 'Latest posts - Blog Layout', 'aus-basic' ),
					'newsboxes' => __( 'News Boxes - use Home Builder', 'aus-basic' ),
				),
				'description' 	=> 'Choose what to be on home page',
			),
		),
	),
	array(
		'id'		=> 'header',
		'title'		=> 'Header',
		'icon'		=> 'fa-cog',
		'fields'	=> array(
			array(
				'id'	=> 'logosetting',
				'title' => 'Logo Setting',
				'type'	=> 'radio',
				'options' => array(
					'customlogo'	=> __( 'Custom Image Logo', 'aus-basic' ),
					'sitetitle'		=> __( 'Display Site Title', 'aus-basic' ),
					'customtitle'	=> __( 'Custom Title', 'aus-basic' ),
				),
				'description' 	=> 'Choose logo type',
			),
			array(
				'id'				=> 'logo_img',
				'title'			=> __( 'Logo Image', 'aus-basic' ),
				'type'			=> 'image',
				'description'	=> __( 'Insert image url or upload', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_img_retina',
				'title'			=> __( 'Logo Image Retina version', 'aus-basic' ),
				'type'			=> 'image',
				'description'	=> __( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_img_retina_width',
				'title'			=> __( 'Standard Logo Width for Retina Logo', 'aus-basic' ),
				'type'			=> 'text',
				'atts'			=> array( 'size' => 3 ),
				'description'	=> __( 'If retina logo is uploaded, please enter the standard logo (1x) version width, do not enter the retina logo width.', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_img_retina_height',
				'title'			=> __( 'Standard Logo Height for Retina Logo', 'aus-basic' ),
				'type'			=> 'text',
				'atts'			=> array( 'size' => 3 ),
				'description'	=> __( 'If retina logo is uploaded, please enter the standard logo (1x) version height, do not enter the retina logo height.', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_full_width',
				'title'			=> __( 'Full Width Logo', 'aus-basic' ),
				'type'			=> 'checkbox',
				'description'	=> __( 'Recommended logo width : 1045px', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_center',
				'title'			=> __( 'Center the Logo', 'aus-basic' ),
				'type'			=> 'checkbox',
				//'description'	=> __( 'Recommended logo width : 1045px', 'aus-basic' ),
			),
			array(
				'id'				=> 'logo_text',
				'title'			=> __( 'Logo Text', 'aus-basic' ),
				'type'			=> 'text',
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
				'description'	=> __( 'Insert home menu text or leave it blank to show Home menu as icon', 'aus-basic' ),
			),
			
		),
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