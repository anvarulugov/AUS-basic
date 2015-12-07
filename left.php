<?php $layout = aus_item_settings( 'item_layout_style', 'col3' ); ?>
<?php if ( is_active_sidebar( 'left' ) && ( $layout == 'col3' || $layout == 'col2l' ) ) : ?>
<?php 
if ( $layout == 'col3' ) {
	$pull_class = 'col-md-pull-6';
} else {
	$pull_class = 'col-md-pull-9';
}
?>
<?php do_action( 'aus_before_left' ); ?>
<div <?php sidebar_class( $pull_class . ' left' ); ?>>
	<?php dynamic_sidebar( 'left' ); ?>
</div>
<?php do_action( 'aus_after_left' ); ?>
<?php endif; ?>