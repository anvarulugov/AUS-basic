<?php $layout = aus_item_settings( 'item_layout_style', 'col3' ); ?>
<?php if ( is_active_sidebar( 'right' ) && ( $layout == 'col3' || $layout == 'col2r' ) ) : ?>
<?php do_action( 'aus_before_right' ); ?>
<div <?php sidebar_class('right'); ?>>
	<?php dynamic_sidebar( 'right' ); ?>
</div>
<?php do_action( 'aus_after_right' ); ?>
<?php endif; ?>