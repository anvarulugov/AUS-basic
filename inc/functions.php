<?php 

function content_class( $class = '' ) {
	if ( ! empty( $class ) )
		$class = ' '.$class;
	if ( is_active_sidebar( 'left' ) && is_active_sidebar( 'right' ) ) {
		$width = 'class="col-lg-6 col-md-6 col-sm-12' . $class . '"';
	} elseif ( is_active_sidebar( 'left' ) || is_active_sidebar( 'right' ) ) {
		$width = 'class="col-lg-9 col-md-9 col-sm-12' . $class . '"';
	} else {
		$width = 'class="col-sm-12' . $class . '"';
	}

	echo $width;

}

function sidebar_class( $class = '' ) {
	if ( ! empty( $class ) )
		$class = ' '.$class;
	echo 'class="sidebar col-lg-3 col-md-3 col-sm-12' . $class . '"';

}

add_action( 'aus_after_post', 'aus_hit_count' );
function aus_hit_count() {
	global $post;
	$curr_hit = get_post_meta( $post->ID, 'aus_hits', true );
	if ( is_singular() ) {
		update_post_meta( $post->ID, 'aus_hits', ($curr_hit + 1) );
	}
}

add_filter('the_content', 'aus_lightbox_post_image');
function aus_lightbox_post_image ( $content ) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1 data-lightbox="post-image" href=$2$3.$4$5$6</a>';
	$content = preg_replace($pattern, $replacement, $content);
	//$content = str_replace("%LIGHTID%", $post->ID, $content);
	return $content;
}

add_filter( 'wp_link_pages_link',  'aus_link_pages_link' );
function aus_link_pages_link( $link ) {
	$current = strpos( $link, 'href' );
	return '<li ' . ( ! $current ? 'class="active"' : '' ) . '>' . $link . '</li>';
}