<?php $layout = aus_item_settings( 'item_layout_style' ); ?>
<?php if ( is_active_sidebar( 'left' ) && ( $layout == 'col3' || $layout == 'col2l' ) ) : ?>
<?php do_action( 'aus_before_left' ); ?>
<div <?php sidebar_class( 'hidden-sm hidden-xs' ); ?>>
	<?php dynamic_sidebar( 'left' ); ?>
</div>
<?php do_action( 'aus_after_left' ); ?>
<?php endif; ?>