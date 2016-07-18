<?php 

class AUS_NewsBox {
	
	public function __construct() {
		add_shortcode( 'aus_newsbox', array( $this, 'newbox' ) );
		add_action( 'after_setup_theme', array( $this, 'thumbnails' ) );
	}

	public function thumbnails() {
		add_image_size( 'nb-intro-thumb', 394, 210, true );
		add_image_size( 'nb-thumb', 90, 60, true );
	}

	public function newbox( $atts ) {
		extract( shortcode_atts( array(
			'category' => 3,
			'count' => 5,
			'type' => 1,
		), $atts ) );

		$wpposts = query_posts( array( 'cat' => $category, 'posts_per_page' => $count ) );
		wp_reset_query();
		if ( ! empty( $wpposts ) && isset( $wpposts[0] ) ) {
			$posts = array(
				'intro' => $wpposts[0]
			);
			unset($wpposts[0]);
			if ( ! empty( $wpposts ) ) {
				$posts['posts'] = $wpposts;
			}

			ob_start();
			switch ( $type ) {
				case '1':
				default:
					$this->style_1( $posts, $category );
					break;
				case '2':
					$this->style_2( $posts, $category );
					break;
				case '3':
					$this->style_3( $posts, $category );
					break;
				case '4':
					$this->style_4( $posts, $category );
					break;
			}
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
			
		}
	}

	public function style_1( $posts, $cat_id ) {
	?>
	<div class="panel panel-primary aus-news-box aus-nb-style1">
		<div class="panel-heading aus-news-box-heading">
			<h3 class="panel-title"><?php echo esc_attr( get_cat_name( $cat_id ) ); ?></h3>
		</div>
		<div class="panel-body aus-news-box-body">
			<div class="row">
				<div class="col-md-6 aus-nb-big-post">
					<?php aus_thumbnail( 'nb-intro-thumb', array( 'class' => 'img-responsive nb-intro-thumb' ), $posts['intro']->ID ); ?>
					<!-- <img class="img-responsive" src="http://termiz.click/wp-content/uploads/2013/03/featured-image-horizontal.jpg"> -->
					<h3><a href="<?php echo get_permalink( $posts['intro']->ID, $posts['intro']->name ); ?>"><?php echo get_the_title( $posts['intro']->ID ); ?></a></h3>
					<div class="">
						<span datetime="2014-05-17T21:15:22+00:00" class="entry-date"><?php aus_date('', $posts['intro']->ID ); ?></span>
						<?php aus_comments( $posts['intro']->ID ); ?>
					</div>
					<p>
					<?php aus_excerpt( 40, $posts['intro']->ID ); ?>...<?php aus_readmore( array( 'class' => 'btn btn-primary btn-xs' ), $posts['intro']->ID, $posts['intro']->name ); ?>
				</p>
				</div>
				<div class="col-md-6 aus-nb-posts-list">
					<ul>
						<?php foreach ( $posts['posts'] as $post ) : ?>
							<li class="panel-default">
								<?php aus_thumbnail( 'nb-thumb', array( 'class' => 'img-responsive nb-thumb' ), $post->ID ); ?>
								<div class="">
									<h4><a href="<?php echo get_permalink( $post->ID, $post->name ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
									<div class="">
										<span datetime="2014-05-17T10:38:14+00:00" class="entry-date"><?php aus_date( $post->ID ); ?></span>
										<?php aus_comments( $post->ID ); ?>
									</div> <!--meta-->
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="panel-footer aus-news-box-footer text-center"><a class="btn btn-default btn-xs" href="<?php echo get_category_link( $cat_id ); ?>">Show more news <i class="fa fa-long-arrow-right"></i></a></div>
	</div>
	<?php 
	}

	public function style_2( $posts, $cat_id ) {
	?>
	<div class="panel panel-primary aus-news-box aus-nb-style2">
		<div class="panel-heading aus-news-box-heading">
			<h3 class="panel-title"><?php echo esc_attr( get_cat_name( $cat_id ) ); ?></h3>
		</div>
		<div class="panel-body aus-news-box-body">
			<div class="row">
				<div class="col-md-12 aus-nb-big-post-title">
					<h3><a href="<?php echo get_permalink( $posts['intro']->ID, $posts['intro']->name ); ?>"><?php echo get_the_title( $posts['intro']->ID ); ?></a></h3>
					<div class="">
						<span datetime="2014-05-17T21:15:22+00:00" class="entry-date"><?php aus_date('', $posts['intro']->ID ); ?></span>
						<?php aus_comments( $posts['intro']->ID ); ?>
					</div>
				</div>
				<div class="col-md-6 aus-nb-big-post">
					<?php aus_thumbnail( 'nb-intro-thumb', array( 'class' => 'img-responsive nb-intro-thumb' ), $posts['intro']->ID ); ?>
				</div>
				<div class="col-md-6 aus-nb-big-post-content">
					<p>
						<?php aus_excerpt( 550, $posts['intro']->ID ); ?>...
						<?php aus_readmore( array( 'class' => 'btn btn-primary btn-xs' ), $posts['intro']->ID, $posts['intro']->name ); ?>
					</p>
				</div>
			</div>
			<div class="row">
				<?php foreach ( $posts['posts'] as $post ) : ?>
				<div class="col-md-6 aus-nb-post">
					<?php aus_thumbnail( 'nb-thumb', array( 'class' => 'img-responsive nb-thumb' ), $post->ID ); ?>
					<div class="">
						<h4><a href="<?php echo get_permalink( $post->ID, $post->name ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h4>
						<div class="">
							<span datetime="2014-05-17T10:38:14+00:00" class="entry-date"><?php aus_date( $post->ID ); ?></span>
								<?php aus_comments( $post->ID ); ?>
						</div> <!--meta-->
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="panel-footer aus-news-box-footer text-center"><a class="btn btn-default btn-xs" href="<?php echo get_category_link( $cat_id ); ?>">Show more news <i class="fa fa-long-arrow-right"></i></a></div>
	</div>
	<?php 
	}

	public function style_3( $posts, $cat_id ) {
	?>
	<div class="panel panel-primary aus-news-box aus-nb-style3">
		<div class="panel-heading aus-news-box-heading">
			<h3 class="panel-title"><?php echo esc_attr( get_cat_name( $cat_id ) ); ?></h3>
		</div>
		<div class="panel-body aus-news-box-body">
			<div class="row">
				<div class="col-md-12 aus-nb-big-post-title">
					<h3><a href="<?php echo get_permalink( $posts['intro']->ID, $posts['intro']->name ); ?>"><?php echo get_the_title( $posts['intro']->ID ); ?></a></h3>
					<div class="">
						<span datetime="2014-05-17T21:15:22+00:00" class="entry-date"><?php aus_date('', $posts['intro']->ID ); ?></span>
						<?php aus_comments( $posts['intro']->ID ); ?>
					</div>
				</div>
				<div class="col-md-6 aus-nb-big-post">
					<?php aus_thumbnail( 'nb-intro-thumb', array( 'class' => 'img-responsive nb-intro-thumb' ), $posts['intro']->ID ); ?>
				</div>
				<div class="col-md-6 aus-nb-big-post-content">
					<p>
					<?php aus_excerpt( 550, $posts['intro']->ID ); ?>...
						<?php aus_readmore( array( 'class' => 'btn btn-primary btn-xs' ), $posts['intro']->ID, $posts['intro']->name ); ?>
					</p>
				</div>
			</div>
			<div class="aus-nb-post row">
				<ul class="two-col">
					<?php foreach ( $posts['posts'] as $post ) : ?>
					<li>
						<i class="fa fa-angle-double-right"></i>
						<a href="<?php echo get_permalink( $post->ID, $post->name ); ?>"><?php echo get_the_title( $post->ID ); ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="panel-footer aus-news-box-footer text-center"><a class="btn btn-default btn-xs" href="<?php echo get_category_link( $cat_id ); ?>">Show more news <i class="fa fa-long-arrow-right"></i></a></div>
	</div>
	<?php 
	}

	public function style_4( $posts, $cat_id ) {
	?>
	<?php 
	}

}
new AUS_NewsBox();