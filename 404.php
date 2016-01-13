<?php get_header(); ?>
<div <?php content_class( 'content' ); ?> role="main">
	<div class="text-center">
		<h2><?php _e( 'Error 404', 'aus-basic' ); ?></h2>
		<img src="<?php echo get_template_directory_uri(); ?>/media/img/404.jpg">
	</div>
</div>
<?php get_template_part( 'left' ); ?>
<?php get_template_part( 'right' ); ?>
<?php get_footer(); ?>