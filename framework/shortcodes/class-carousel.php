<?php 

class AUS_Carousel {

	private $owl_script;

	public function __construct() {
		add_shortcode( 'aus_carousel', array( $this, 'carousel' ) );
		add_action( 'after_setup_theme', array( $this, 'thumbnails' ) );
		add_action( 'init', array( $this, 'register_scripts' ) );
		add_action( 'wp_footer', array( $this, 'load_scripts' ) );
	}

	public function thumbnails() {
		add_image_size( 'aus-carousel', 394, 210, true );
		add_image_size( 'aus-carousel-thumb', 90, 60, true );
	}

	public function carousel( $atts ) {
		extract( shortcode_atts( array(
			'category' => 3,
			'type' => 1,
			'height' => '400px',
			'width' => '100%',
			'animation' => 'fade',
			'caption_animation' => 'fadeInUp',
			'count' => 4,
		), $atts ) );

		$posts = query_posts( array( 'cat' => $category, 'posts_per_page' => $count ) );
		wp_reset_query();
		if ( ! empty( $posts ) ) {
			ob_start();
			switch ( $type ) {
				case '1':
				default:
					$this->style_1( $posts, $category, $height, $width );
					break;
				case '2':
					$this->style_2( $posts, $category, $height, $width );
					break;
				case '3':
					$this->style_3( $posts, $category, $height, $width );
					break;
				case '4':
					$this->style_4( $posts, $category, $height, $width );
					break;
			}
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}
	}

	public function style_1( $posts, $category, $height, $width ) {
		$carousel_id = 'carousel-'.rand(0,9999);
		?>
		<div id="<?php echo $carousel_id; ?>" class="carousel slide carousel-fade" data-ride="carousel" style="height: <?php echo $height; ?>; width: <?php echo $width; ?>; margin-bottom:15px;">
			<ol class="carousel-indicators">
				<?php $i = 0; foreach ( $posts as $slide ) : ?>
				<li data-target="#<?php echo $carousel_id; ?>" data-slide-to="<?php echo $i; ?>" class="<?php echo ( $i == 0 ? 'active ' : ''); ?>"></li>
				<?php $i++; endforeach; ?>
			</ol>
			<!-- Carousel items -->
			<div class="carousel-inner">
				<?php $i = 0; foreach ( $posts as $slide) : ?>
				<div class="<?php echo ( $i == 0 ? 'active ' : ''); ?>item" style="background-image: url(<?php echo aus_get_thumbnail( 'large', '', $slide->ID, 'src' ); ?>); background-repeat: no-repeat; background-position-x: center; background-size: cover;">
					<div class="carousel-caption animated <?php echo $caption_animation; ?>"> <a href="<?php echo get_permalink( $slide->ID, $slide->name ); ?>"><h3><?php echo get_the_title( $slide->ID ); ?></h3></a> <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> </div>
				</div>
				<?php $i++; endforeach; ?>
			</div>
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#<?php echo $carousel_id; ?>" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only"><?php _e( 'Previous', 'aus-basic' ); ?></span></a>
			<a class="carousel-control right" href="#<?php echo $carousel_id; ?>" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only"><?php _e( 'Next', 'aus-basic' ); ?></span></a>
		</div>
		<?php 
	}

	public function style_2( $posts, $category, $height, $width ) {

	}

	public function style_3( $posts, $category, $height, $width ) {
		
	}

	public function style_4( $posts, $category, $height, $width ) {
		$this->owl_script = true;
		?>
		<!-- Set up your HTML -->
		<div class="owl-carousel">
			<?php foreach ( $posts as $post ) : ?>
				<div>
				<?php aus_thumbnail( null, array( 'class' => 'img-responsive' ), $post->ID ); ?>
				<p><?php echo get_the_title( $post->ID ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<?php 
	}

	public function register_scripts() {
		wp_register_style( 'owl-carousel', get_aus_uri() . '/media/css/owl.carousel.css' );
		wp_register_script( 'owl-carousel', get_aus_uri() . '/media/js/owl.carousel.min.js', array( 'jquery' ), '2.0.0' );
	}

	public function load_scripts() {
		if ( $this->owl_script ) {
			wp_enqueue_script( 'owl-carousel' );
			wp_enqueue_style( 'owl-carousel' );
			echo "
			<script>
			jQuery(document).ready(function($){
				$('.owl-carousel').owlCarousel();
			});
			</script>
			";
		}
	}

}
new AUS_Carousel();