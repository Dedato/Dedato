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
	
	<?php wp_head(); ?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/respond.min-1.4.2.js"></script>
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
</head>
<body <?php body_class('maintenance'); ?>>
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
					<div class="col-md-10" role="page">
						<div class="content row">
							<main class="main col-md-9" role="main">					
								<article class="maintenance">
									<div class="entry-content">										
										<!-- Slideshow -->
										<?php $ucgallery 	= get_field('under_construction_gallery', 'option');
										if ($ucgallery) { ?>
											<div class="flexslider">
												<ul class="slides">
													<?php foreach($ucgallery as $image):
														$alt 			= $image['alt'];
														$imgwidth 	= $image['width'];
														$imgheight 	= $image['height'];
														$ratio 		= ($imgwidth / $imgheight);
														$imgsrcmd 	= $image['sizes']['medium'];
														$imgsrclg 	= $image['sizes']['large'];
														if ($ratio > 1) {
															$orientation = 'landscape';
														} else { 
															$orientation = 'portrait';
														} ?>
														<li class="<?php echo $orientation; ?>">
															<picture>
																<!--[if IE 9]><video style="display: none;"><![endif]-->
																<source srcset="<?php echo $imgsrclg; ?>" media="(min-width:510px)">
																<source srcset="<?php echo $imgsrcmd; ?>">
																<!--[if IE 9]></video><![endif]-->
																<img srcset="<?php echo $imgsrclg; ?>" alt="<?php echo $alt; ?>" />
															</picture>
														</li>
													<?php endforeach; ?>
												</ul>
											</div>	
										<?php } ?>
										<div class="entry-details">
											<!-- YITH Maintenace Mode values -->
											<?php echo $message; ?>
											<!-- Newsletter -->
											<?php if ( $newsletter['enabled'] ) : ?>				
												<?php if ( $title ) : ?>
													<label><?php echo $title ?></label>
												<?php endif ?>
												<form method="<?php echo $newsletter['form_method'] ?>" action="<?php echo $newsletter['form_action'] ?>" class="newsletter form-inline">					
													<div class="input-group">
														<input type="text" name="<?php echo $newsletter['email_name'] ?>" id="<?php echo $newsletter['email_name'] ?>" class="email-field text-field form-control" placeholder="<?php echo $newsletter['email_label'] ?>" />
														<span class="input-group-btn">
													      <button type="submit" class="search-submit btn btn-primary"><i class="icon-envelope"></i></button>
													    </span>														
														<?php foreach( $newsletter['hidden_fields'] as $field_name => $field_value ) : ?>
															<input type="hidden" id="<?php echo $field_name ?>" name="<?php echo $field_name ?>" value="<?php echo $field_value ?>" />
														<?php endforeach; ?>
													</div>
												</form>
											<?php endif; ?>
											<!-- Social Media -->
											<ul class="socials">
												<?php foreach( $socials as $social => $url ) :
												if ( empty( $url ) ) continue;
													if ( $social == 'email' ) $url = 'mailto:' . $url;
													if ( $social == 'skype' ) $url = 'http://myskype.info/' . str_replace( '@', '', $url );
													?>
													<li class="social <?php echo $social ?>"><a class="btn btn-sm btn-primary" href="<?php echo esc_url( $url ) ?>" target="_blank">
														<i class="icon-<?php echo $social; ?>"></i></a>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>	
									</div>
								</article>								
							</main>
						</div>	
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.wrap -->
		<div id="push"></div>
	</div><!-- / #wrapper -->
	<footer class="content-info" role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-push-2">
				<?php dynamic_sidebar('sidebar-footer'); ?>
				<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
			</div>
		</div>
	</div>	
</footer>
<?php wp_footer(); ?>
</body>
</html>
