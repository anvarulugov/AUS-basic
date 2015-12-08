<?php get_header(); ?>
<div <?php content_class( 'content' ); ?>>
<?php do_action( 'aus_before_loop' ); ?>
<?php woocommerce_content(); ?>
<?php do_action( 'aus_after_loop' ); ?>
</div>
<?php get_template_part( 'left' ); ?>
<?php get_template_part( 'right' ); ?>
<?php get_footer(); ?>