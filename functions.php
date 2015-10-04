<?php 
require_once(TEMPLATEPATH.'/framework/includes.php');

/* Activate Theme Options Class */
new AUS_theme_options( $aus_config );

/* Activate Theme Elements Class */
$aus_elements = new AUS_theme_elements( $aus_config );

if ( ! isset( $content_width ) ) $content_width = 850;

if ( ! function_exists('aus_basic_setup') ) :

function aus_basic_setup() {

	// Make aus-basic available for translation.
	load_theme_textdomain( 'aus-basic', get_template_directory() . '/languages' );
	
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails and declare necessary sizes.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'gallery-thumbnail', 400, 300, true );

	// Enable post formats
	add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );

	// Register wp_nav_menu() positions
	register_nav_menus(array(
		'primary'=>'Themeslug Primary horizontal menu',
		'top-menu'=>'Themeslug top horizontal menu',
	));

	/**
	 * Switch default core markup for search forms, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5',array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
}

endif; //aus_basic_setup
add_action( 'after_setup_theme', 'aus_basic_setup' );

function aus_widgets_init() {

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
		'name'			=> __( 'Left sidebar mobile', 'aus-basic' ),
		'id'				=> 'left_mobile',
		'description'	=> 'Mobile visible Left column of the theme.',
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

	register_sidebar( array(
		'name'			=> __( 'Page buttom', 'aus-basic' ),
		'id'				=> 'page_bottom',
		'description'	=> 'Page bottom of the theme.',
		'class'			=> '',
		'before_widget'=> '',
		'after_widget' => '',
		'before_title' => '',
		'after_title'	=> ''
	) );

	register_sidebar( array(
		'name'			=> __( 'Home Primary', 'aus-basic' ),
		'id'				=> 'home_primary',
		'description'	=> __( 'Top of the home page', 'aus-basic' ),
		'class'			=> '',
		'before_widget'=> '',
		'after_widget' => '',
		'before_title' => '',
		'after_title'	=> ''
	) );

	register_sidebar( array(
		'name'			=> __( 'Home Content left', 'aus-basic' ),
		'id'				=> 'home_half1',
		'description'	=> __( 'Half left content width', 'aus-basic' ),
		'class'			=> '',
		'before_widget'=> '',
		'after_widget' => '',
		'before_title' => '',
		'after_title'	=> ''
	) );

	register_sidebar( array(
		'name'			=> __( 'Home Content right', 'aus-basic' ),
		'id'				=> 'home_half2',
		'description'	=> __( 'Half right content width', 'aus-basic' ),
		'class'			=> '',
		'before_widget'=> '',
		'after_widget' => '',
		'before_title' => '',
		'after_title'	=> ''
	) );

	register_sidebar( array(
		'name'			=> __( 'Home Bottom', 'aus-basic' ),
		'id'				=> 'home_bottom_full',
		'description'	=> __( 'Full content width', 'aus-basic' ),
		'class'			=> '',
		'before_widget'=> '',
		'after_widget' => '',
		'before_title' => '',
		'after_title'	=> ''
	) );
}
add_action( 'widgets_init', 'aus_widgets_init');

/**
 * Register Open-Sans and Roboto Google fonts for aus-basic theme
 */ 
function aus_google_fonts() {

	wp_enqueue_style( 'Open-Sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext,cyrillic' );

	wp_enqueue_style( 'Roboto', '//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic-ext,cyrillic,latin-ext' );

}
add_action( 'wp_enqueue_scripts', 'aus_google_fonts' );

function aus_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/media/css/yeti.min.css', array(), '3.3.0' );

	wp_enqueue_style( 'bootstrap-fa-icon', get_template_directory_uri() . '/media/css/font-awesome.min.css', array(), '4.3.0' );

	wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/media/css/lightbox.css', array(), '4.3.0' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/media/js/bootstrap.min.js', array( 'jquery' ), '3.3.0', true );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_style( 'comments', get_template_directory_uri() . '/media/css/comments.css', array(), '1.0' );
	}

	wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/media/js/lightbox.min.js', array( 'jquery' ), '3.3.0', true );

	wp_enqueue_script( 'aus-basic-script', get_template_directory_uri() . '/media/js/functions.js', array( 'jquery' ), '3.3.0', true );

}
remove_action('wp_enqueue_scripts', 'osc_add_frontend_ebs_scripts',-100);
add_action( 'wp_enqueue_scripts', 'aus_scripts' );

function aus_wp_title( $title, $sep ) {

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
add_action( 'wp_title', 'aus_wp_title', 10, 2 );

add_action( 'aus_before_footer', 'page_bottom_widget' );
function page_bottom_widget() {
	if ( is_active_sidebar( 'page_bottom' ) ) : ?>
	<div class="page-bottom">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php dynamic_sidebar( 'page_bottom' ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif;
}