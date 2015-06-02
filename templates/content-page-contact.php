<?php while (have_posts()) : the_post(); ?>
	<article <?php post_class('row'); ?>>
		<div class="details col-md-6 ">
			<header>
				<h1><?php echo roots_title(); ?></h1>
			</header>
			<div class="entry-content">	
				<?php the_content(); ?>
			</div>
		</div>
		<div class="map col-md-6">
			<?php
			if (get_field('google_map')):
				echo get_field('google_map');
			endif; ?>
		</div>
	</article>	
<?php endwhile; ?>
