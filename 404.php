<?php get_header(); ?>
<?php get_template_part( 'left' ); ?>
<div <?php content_class('content'); ?>>
	<div class="text-center">
		<h2>Error 404</h2>
		<img src="<?php echo get_template_directory_uri(); ?>/media/img/404.jpg">
	</div>
</div>
<?php get_template_part( 'right' ); ?>
<?php get_footer(); ?>