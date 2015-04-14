<?php 
require_once(TEMPLATEPATH.'/inc/defaults.php');
require_once(TEMPLATEPATH.'/inc/functions.php');
require_once(TEMPLATEPATH.'/inc/elements.php');
require_once(TEMPLATEPATH.'/inc/widget-category-posts.php');

$theme_name = 'ThemeName';
$theme_slug = 'themeslug';


/* Activate Theme Elements Class */
$elements = new AUS_theme_elements($theme_name,$theme_slug);
global $elements;

if ( ! isset( $content_width ) ) $content_width = 850;

if ( ! function_exists('themeslug_on_bootstrap_setup') ) :

function themeslug_on_bootstrap_setup() {

	// Make themeslug available for translation.
	load_theme_textdomain( 'themeslug', get_template_directory() . '/languages' );
	
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails and declare necessary sizes.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured-post', 282, 192, true );
	add_image_size( 'home-loop-post', 252, 172, true );
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

endif; //themeslug_on_bootstrap_setup
add_action( 'after_setup_theme', 'themeslug_on_bootstrap_setup' );

function themeslug_widgets_init() {

	register_sidebar( array(
		'name'			=> __( 'Left sidebar', 'themeslug' ),
		'id'				=> 'left',
		'description'	=> 'Left column of the theme.',
		'class'			=> '',
		'before_widget'=> '<aside id="%1$s" class="widget panel panel-default %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="panel-heading"><h3 class="panel-title">',
		'after_title'	=> '</h3></div>'
	) );

	register_sidebar( array(
		'name'			=> __( 'Right sidebar', 'themeslug' ),
		'id'				=> 'right',
		'description'	=> 'Right column of the theme.',
		'class'			=> '',
		'before_widget'=> '<aside id="%1$s" class="widget panel panel-default %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<div class="panel-heading"><h3 class="panel-title">',
		'after_title'	=> '</h3></div>'
	) );

	register_sidebar( array(
		'name'			=> __( 'Page buttom', 'themeslug' ),
		'id'				=> 'page_bottom',
		'description'	=> 'Page bottom of the theme.',
		'class'			=> '',
		'before_widget'=> '',
		'after_widget' => '',
		'before_title' => '',
		'after_title'	=> ''
	) );
}
add_action( 'widgets_init', 'themeslug_widgets_init');

/**
 * Register Open-Sans and Roboto Google fonts for themeslug theme
 */ 
function themeslug_google_fonts() {

	wp_enqueue_style( 'Open-Sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext,cyrillic' );

	wp_enqueue_style( 'Roboto', '//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic-ext,cyrillic,latin-ext' );

}
add_action( 'wp_enqueue_scripts', 'themeslug_google_fonts' );

function themeslug_scripts() {

	wp_enqueue_style( 'bootstrap-min', get_template_directory_uri() . '/media/css/bootstrap.min.css', array(), '3.3.0' );

	wp_enqueue_style( 'fontawesome-min', get_template_directory_uri() . '/media/css/font-awesome.min.css', array(), '4.3.0' );

	wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/media/css/lightbox.css', array(), '4.3.0' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/media/js/bootstrap.min.js', array( 'jquery' ), '3.3.0', true );

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/media/js/lightbox.min.js', array( 'jquery' ), '3.3.0', true );

	wp_enqueue_script( 'themeslug-script', get_template_directory_uri() . '/media/js/functions.js', array( 'jquery' ), '3.3.0', true );

}
add_action( 'wp_enqueue_scripts', 'themeslug_scripts' );

function themeslug_settings($option) {

	global $themeslug_options;
	$options = get_option('themeslug_options',$themeslug_options);
	if(isset($options[$option]))
		return $options[$option];
	else
		return false;

}

function themeslug_wp_title( $title, $sep ) {

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
add_action( 'wp_title', 'themeslug_wp_title', 10, 2 );

if ( ! function_exists( 'themeslug_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post
 *
 * @since Themeslug on Bootstrap 1.1
 */
function themeslug_list_authors() {
	$authors_ids = get_users( array(
		'fields'		=> 'ID',
		'order_by'	=> 'post_count',
		'order'		=> 'DESC',
		'who'			=> 'authors',
	) );

	?>

	<div class="autorsmenu">
		<H2 class="blue7 text-center"><?php _e( 'Our contributors', 'themeslug'); ?></H2>
		<ul class="authors">
	<?php 

	foreach ($authors_ids as $authors_id) :
		$post_count = count_user_posts( $authors_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>
	<li class="a-menu-item col-md-2 col-sm-3">
		<a href="<?php echo esc_url( get_author_posts_url( $authors_id ) ); ?>" class="img-thumbnail">
			<?php echo get_avatar( $authors_id, 101 ); ?>
			<p><?php echo get_the_author_meta( 'display_name',$authors_id ); ?></p>
		</a>
	</li>
	<?php 
	endforeach;
	?>
		</ul>
	</div>
	<?php 
}
endif;

add_action( 'aus_before_footer', 'page_bottom_widget' );
function page_bottom_widget() {
	if ( is_active_sidebar( 'page_bottom' ) ) : ?>
	<div class="page-bottom">
		<?php dynamic_sidebar( 'page_bottom' ); ?>
	</div>
	<?php endif;
}