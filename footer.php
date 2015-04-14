<?php global $elements; ?>
	</div><!--row-->
</div><!--container-->
<?php do_action( 'aus_before_footer' ); ?>
<div class="footer">
	<div class="container">
		<div class="text-center">&copy; <?php echo date('Y'); ?> <?php $elements->site_name(); ?></div>
	</div>
</div>
<?php do_action( 'aus_after_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>