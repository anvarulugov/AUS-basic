<?php if ( is_active_sidebar( 'right' ) ) : ?>
<?php do_action( 'aus_before_right' ); ?>
<div class="sidebar col-md-4 col-lg-4 col-sm-12">
	<?php dynamic_sidebar( 'right' ); ?>
</div>
<?php do_action( 'aus_after_right' ); ?>
<?php endif; ?>