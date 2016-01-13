<div <?php content_class( 'content' ); ?> role="main">
<?php do_action( 'aus_before_loop' ); ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php do_action( 'aus_before_post' ); ?>
<section id="post-<?php the_ID(); ?>" <?php post_class( 'article clearfix' ); ?>>
	<header class="entry-header">
		<a href="<?php the_permalink(); ?>"><h1 class="entry-title lead"><?php the_title(); ?></h1></a>
		<div class="entry-meta">
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<i class="fa fa-thumb-tack"></i> <?php _e( 'Sticky', 'aus-basic' ); ?> | 
			<?php endif; ?>
			<time pubdate="pubdate" datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-calendar"></i> <?php aus_date(); ?></time> | <i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
			| <i class="fa fa-folder"></i> <?php aus_categories(); ?> | <i class="fa fa-comments"></i> <?php aus_comments(); ?> | <i class="fa fa-eye"></i> <?php aus_views(); ?>
		</div>
	</header>
	<figure>
		<?php aus_thumbnail('',array( 'class'=>'img-responsive aligncenter' ) ); ?>
	</figure>
	<div class="entry-excerpt">
		<?php aus_excerpt( 300, $post->ID ); ?>...
		<?php aus_readmore( array( 'text'=>'Read more','class'=>'btn btn-primary btn-xs') ); ?>
	</div>
	<footer class="entry-footer"></footer>
</section>
<?php do_action( 'aus_after_post' ); ?>
<?php endwhile; ?>
<?php aus_pager(); ?>
<?php else : ?>
	<p><?php _e('Sorry, no posts matched your criteria.', 'aus-basic'); ?></p>
<?php endif; ?>
<?php do_action( 'aus_after_loop' ); ?>
</div>