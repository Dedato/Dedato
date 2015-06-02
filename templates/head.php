<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js ie ie6 lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js ie ie7 lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js ie ie8 lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>     <html class="no-js ie ie9 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title('-'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="IzUoy8v0Ze-GWqcCwO666J8UwKYb61iqQI4-zTpjsNQ" />
  <?php if(get_query_var('page') > 1) { echo '<meta name="robots" content="noindex,follow">'; } ?>
	<?php wp_head(); ?>
  <!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/respond.min.js"></script>
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
</head>