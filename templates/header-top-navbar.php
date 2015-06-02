<?php // Get option values
$socials		= get_field('social_media', 'option');
?>

<header class="banner navbar navbar-fixed-top" role="banner">
	<div class="container">
		<div class="header row">
			<a class="logo col-sm-2" href="<?php echo home_url(); ?>/" title="<?php bloginfo('name'); ?>">
				<h1><i class="icon-dd-logo"></i></h1>
			</a>
			<div class="navbar-brand col-sm-6 hidden-xs">
				<span class="name"><?php bloginfo('name'); ?></span>
				<span class="tagline"><?php bloginfo('description'); ?></span>
			</div>
			<div class="social-media col-sm-2 hidden-sm hidden-xs">
				<div class="box taphover">
					<div class="toggle"><i class="icon-share"></i></div>
					<div class="middle">
						<?php if(have_rows('social_media', 'option')): ?>
							<!--<span class="title"><?php _e('Follow us on:','dedato'); ?></span>-->
							<ul class="socials">
								<?php while (have_rows('social_media', 'option')) : the_row(); 
									$url 	= get_sub_field('social_media_url');
									$icon = get_sub_field('social_media_icon');
									?>
									<li><a class="btn btn-primary btn-sm" href="<?php echo $url['url']; ?>" title="<?php echo $url['title']; ?>" target="_blank">
									<i class="icon-<?php echo $icon; ?>"></i></a></li>
								<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>		
			<div class="search col-sm-2 hidden-sm hidden-xs">
				<?php get_search_form(); ?>
			</div>			
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only"><?php _e('Toggle Navigation','dedato'); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
	</div>
</header>