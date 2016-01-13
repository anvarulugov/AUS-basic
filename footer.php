	</div><!--row-->
</div><!--container-->
<?php do_action( 'aus_before_footer' ); ?>
<div class="footer" role="contentinfo">
	<hr />
	<div class="container">
		<div class="text-center">&copy; <?php echo date('Y'); ?> <?php aus_site_name(); ?></div>
	</div>
</div>
<?php do_action( 'aus_after_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>