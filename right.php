<?php if ( is_active_sidebar( 'left_mobile' ) ) : ?>
<div <?php sidebar_class('visible-sm visible-xs'); ?>>
	<?php dynamic_sidebar( 'left_mobile' ); ?>
</div>
<?php endif; ?>
<?php if ( is_active_sidebar( 'right' ) ) : ?>
<?php do_action( 'aus_before_right' ); ?>
<div <?php sidebar_class(); ?>>
	<?php dynamic_sidebar( 'right' ); ?>
</div>
<?php do_action( 'aus_after_right' ); ?>
<?php endif; ?>