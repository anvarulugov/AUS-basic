<?php 

require_once( get_template_directory() . '/framework/aus-elements.php' );
new AUS_Elements();

if ( ! isset( $content_width ) ) $content_width = 850;

if ( ! function_exists( 'aus_basic_basic_setup' ) ) :

function aus_basic_basic_setup() {

	add_filter( 'aus_register_configs', 'aus_basic_configs' );
	// Add TGM Plugin loader
	add_theme_support( 'tgm' );

	// Add Customizer Support
	add_theme_support( 'theme-customizer' );
	//add_theme_support( 'theme-options' );

	// Add Metabox Support
	add_theme_support( 'custom-metabox' );

	// Add AUS Widgets Support
	add_theme_support( 'aus-core-widgets' );

	// Custom background
	add_theme_support( 'custom-background', array( 'default-color' => 'fff' ) );

	// AUS Premium Shortcodes
	add_theme_support( 'aus-shortcodes' );
	
	/* Add support for a custom header image (logo). */
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1140,
			'height'      => 150,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => false
		)
	);

	// Make aus-basic available for translation.
	load_theme_textdomain( 'aus-basic', get_template_directory() . '/languages' );
	
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails and declare necessary sizes.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'gallery-thumbnail', 400, 300, true );

	add_image_size( 'nb-intro-thumb', 394, 210, true );
	add_image_size( 'nb-thumb', 90, 60, true );

	// Enable post formats
	// add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );

	// Register wp_nav_menu() positions
	register_nav_menus(array(
		'primary'=>'Primary Navbar',
		'top-menu'=>'Top Navbar',
	));

	/**
	 * Switch default core markup for search forms, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5',array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
}
endif; //aus_basic_basic_setup
add_action( 'after_setup_theme', 'aus_basic_basic_setup' );

function aus_basic_configs() {
	$metaboxes = array(
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
				array(
					'id'			=> 'item_show_title',
					'title'			=> __( 'Show Item Title', 'aus-basic' ),
					'type'			=> 'radio',
					'description'	=> __( 'Show or Hide Entry Title', 'aus-basic' ),
					'options'		=> array( 'yes' => __( 'Show', 'aus-basic' ), 'no' => __( 'Hide', 'aus-basic' ) ),
					'value'			=> 'yes',
				),
				array(
					'id'			=> 'item_show_meta',
					'title'			=> __( 'Show Item Meta', 'aus-basic' ),
					'type'			=> 'radio',
					'description'	=> __( 'Show or Hide Entry Meta', 'aus-basic' ),
					'options'		=> array( 'yes' => __( 'Show', 'aus-basic' ), 'no' => __( 'Hide', 'aus-basic' ) ),
					'value'			=> 'yes',
				),
				array(
					'id'			=> 'item_content_class',
					'title'			=> __( 'Content Class', 'aus-basic' ),
					'type'			=> 'text',
					'description'	=> __( 'Item body wrapper class', 'aus-basic' ),
					'value'			=> 'content',
				),
			),
		),
	);

	$configs = array(
		'theme_name'	=> 'AUS Basic',
		'theme_slug'	=> 'aus-basic',
		'menutype'		=> 'toplevel',
		'options_type'	=> 'customizer',
		'tabs'			=> array(),
		'metaboxes'		=> $metaboxes,
	);

	return $configs;
}

function aus_basic_widgets_init() {

	register_sidebar( array(
		'name'			=> __( 'Left sidebar', 'aus-basic' ),
		'id'				=> 'left',
		'description'	=> 'Mobile hidden Left column of the theme.',
		'class'			=> '',
		'before_widget'=> '<aside id="%1$s" class="widget panel panel-primary %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="panel-heading"><h3 class="panel-title">',
		'after_title'	=> '</h3></div>'
	) );

	register_sidebar( array(
		'name'			=> __( 'Right sidebar', 'aus-basic' ),
		'id'				=> 'right',
		'description'	=> 'Right column of the theme.',
		'class'			=> '',
		'before_widget'=> '<aside id="%1$s" class="widget panel panel-primary %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="panel-heading"><h3 class="panel-title">',
		'after_title'	=> '</h3></div>'
	) );

}
add_action( 'widgets_init', 'aus_basic_widgets_init');

/**
 * Register Open-Sans and Roboto Google fonts for aus-basic theme
 */ 
function aus_basic_google_fonts() {

	wp_enqueue_style( 'Open-Sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext,cyrillic' );

	wp_enqueue_style( 'Roboto', '//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic-ext,cyrillic,latin-ext' );

}
add_action( 'wp_enqueue_scripts', 'aus_basic_google_fonts' );

function aus_basic_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/media/css/' . aus_settings( 'css_theme', 'bootstrap' ) . '.min.css', array(), '3.3.0' );

	wp_enqueue_style( 'bootstrap-fa-icon', get_template_directory_uri() . '/media/css/font-awesome.min.css', array(), '4.3.0' );

	wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/media/css/lightbox.css', array(), '4.3.0' );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/media/css/animate.css', array(), '3.5.0' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/media/js/bootstrap.min.js', array( 'jquery' ), '3.3.0', true );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_style( 'comments', get_template_directory_uri() . '/media/css/comments.css', array(), '1.0' );
	}

	wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/media/js/lightbox.min.js', array( 'jquery' ), '3.3.0', true );

	wp_enqueue_script( 'aus-basic-script', get_template_directory_uri() . '/media/js/functions.js', array( 'jquery' ), '3.3.0', true );

}
add_action( 'wp_enqueue_scripts', 'aus_basic_scripts' );

function aus_basic_wp_title( $title, $sep ) {

	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
	}

	return $title;

}
add_action( 'wp_title', 'aus_basic_wp_title', 10, 2 );

add_action( 'after_setup_theme', 'aus_woocommerce_support' );
function aus_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}