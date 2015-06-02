<?php get_template_part('templates/head'); ?>
<body <?php body_class(ICL_LANGUAGE_CODE); ?>>
	<div id="wrapper" role="document">
		<!--[if lt IE 8]>
		<div class="alert alert-warning">
			<?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
		</div>
		<![endif]-->
		<?php do_action('get_header');
		// Use Bootstrap's navbar if enabled in config.php
		if (current_theme_supports('bootstrap-top-navbar')) {
			get_template_part('templates/header-top-navbar');
		} else {
			get_template_part('templates/header');
		} ?>
		<div class="wrap" role="document">
			<div class="container">
				<div class="row">
					<aside class="side-nav navbar col-md-2" role="complementary">
						<nav class="collapse navbar-collapse" role="navigation" data-spy="affix" data-offset-top="0">
							<?php if (has_nav_menu('primary_navigation')) :
								wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills nav-stacked'));
							endif; ?>
						</nav>
					</aside>
					<div class="site col-md-10" role="page">
						<div class="content row">
							<main class="main <?php echo roots_main_class(); ?>" role="main">
								<?php include roots_template_path(); ?>
							</main><!-- /.main -->
							<?php if (roots_display_sidebar()) : ?>
								<aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
									<?php include roots_sidebar_path(); ?>
								</aside><!-- /.sidebar -->
							<?php endif; ?>
						</div>	
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.wrap -->
		<div id="push"></div>
	</div><!-- / #wrapper -->
	<?php get_template_part('templates/footer'); ?>
</body>
</html>
