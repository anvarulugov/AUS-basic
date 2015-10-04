<?php $layout = aus_item_settings( 'item_layout_style' ); ?>
<?php if ( is_active_sidebar( 'left_mobile' ) && ( $layout == 'col3' || $layout == 'col2l' ) ) : ?>
<div <?php sidebar_class('visible-sm visible-xs'); ?>>
	<?php dynamic_sidebar( 'left_mobile' ); ?>
</div>
<?php endif; ?>
<?php if ( is_active_sidebar( 'right' ) && ( $layout == 'col3' || $layout == 'col2r' ) ) : ?>
<?php do_action( 'aus_before_right' ); ?>
<div <?php sidebar_class(); ?>>
	<?php dynamic_sidebar( 'right' ); ?>
</div>
<?php do_action( 'aus_after_right' ); ?>
<?php endif; ?>