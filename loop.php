<div <?php content_class('content'); ?>>
<?php do_action( 'aus_before_loop' ); ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); global $elements; ?>
<?php do_action( 'aus_before_post' ); ?>
<section id="post-<?php the_ID(); ?>" <?php post_class( 'article clearfix' ); ?>>
	<header class="entry-header">
		<a href="<?php the_permalink(); ?>"><h1 class="entry-title lead"><?php the_title(); ?></h1></a>
		<div class="entry-meta">
			<time pubdate="pubdate" datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-calendar"></i> <?php $elements->date() ?></time> | <i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
			| <i class="fa fa-folder"></i> <?php $elements->categories(); ?> | <i class="fa fa-comment"></i> <?php $elements->comments(); ?> | <i class="fa fa-eye"></i> <?php $elements->views(); ?>
		</div>
	</header>
	<figure>
		<?php $elements->thumbnail('large',array( 'class'=>'img-responsive aligncenter' ) ); ?>
	</figure>
	<div class="entry-exerpt">
		<?php $elements->excerpt( 300, $post->ID ); ?>...
		<?php $elements->readmore( array( 'text'=>'Read more','class'=>'btn btn-primary btn-xs') ); ?>
	</div>
	<footer class="entry-footer"></footer>
</section>
<?php do_action( 'aus_after_post' ); ?>
<?php endwhile; ?>
<?php $elements->pager(); ?>
<?php else : ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<?php do_action( 'aus_after_loop' ); ?>
</div>