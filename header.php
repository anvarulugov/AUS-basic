<?php do_action( 'aus_begin_theme' ); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/media/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'aus_before_page' ); ?>
<?php aus_navbar( 'top-menu', array( 'navbar_class' => 'navbar-inverse' ) ); ?>
<div class="header" role="banner">
	<div <?php container_class(); ?>>
		<div class="row">
			<div class="col-md-5">
				<h1><?php aus_logo( array( 'img_class' => 'img-responsive' ) ); ?></h1>
				<small><?php aus_site_description(); ?></small>
			</div>
			<div class="col-md-7">
				<?php do_action( 'aus_in_header' ); ?>
			</div>
		</div>
	</div>
</div>
<?php aus_navbar( 'primary' ); ?>
<?php do_action( 'aus_after_header' ); ?>
<div <?php container_class(); ?>>
	<div class="row">