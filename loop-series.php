<?php global $elements; ?>
<div <?php content_class('content'); ?>>
<div class="bs-callout bs-callout-info">
	<h4><?php echo $elements->page_title(); ?></h4>
	<p><?php echo category_description(); ?></p>
</div>
<?php do_action( 'aus_before_loop' ); ?>
<?php if ( have_posts() ) : ?>
<ol>
<?php while ( have_posts() ) : the_post(); ?>
<?php do_action( 'aus_before_post' ); ?>
<li><a href="<?php the_permalink(); ?>"><p class="entry-title"><?php the_title(); ?></p </a></li>
<?php do_action( 'aus_after_post' ); ?>
<?php endwhile; ?>
</ol>
<?php $elements->pager(); ?>
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.', 'themeslug' ); ?></p>
<?php endif; ?>
<?php do_action( 'aus_after_loop' ); ?>
</div>