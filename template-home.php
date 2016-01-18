<?php
/*
Template Name: Homepage
*/
$paged    = (get_query_var('page')) ? get_query_var('page') : 1; ?>

<div id="projects" class="grid">
  
	<?php	/* Intro Text */
	if ($paged == 1): ?>
		<article <?php post_class('stamp intro col-sm-6'); ?>>
			<?php while (have_posts()) : the_post(); ?>
				<div class="entry-content">
					<div class="entry-details">
				  		<h4 class="entry-title"><?php the_title(); ?></h4>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</article>
	<?php endif; ?>
	
<?php /* Projects */
$wp_query = new WP_Query( array(
	'post_type' 		  => 'project',
	'meta_key' 			  => 'project_date',
	'meta_query'      => array(
    'key'             => 'project_date',
    'type'            => 'date'
  ),
	'orderby' 			  => 'meta_value_num title',
	'order' 				  => 'DESC',
	'paged' 				  => $paged
));
get_template_part('templates/loop', 'project'); ?>
	
	<?php if ($wp_query->max_num_pages > 1) : ?>
  	<nav class="post-nav">
  		<ul class="pager">
  			<li class="next"><?php next_posts_link(__('Older projects <i class="icon-chevron-right"></i>', 'dedato')); ?></li>
  			<li class="previous"><?php previous_posts_link(__('<i class="icon-chevron-left"></i> Newer projects', 'dedato')); ?></li>
  		</ul>
  	</nav>
  <?php endif;
  wp_reset_query(); ?>

</div>