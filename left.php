<?php if ( is_active_sidebar( 'left' ) ) : ?>
<?php do_action( 'aus_before_left' ); ?>
<div <?php sidebar_class( 'hidden-sm hidden-xs' ); ?>>
	<?php dynamic_sidebar( 'left' ); ?>
</div>
<?php do_action( 'aus_after_left' ); ?>
<?php endif; ?>