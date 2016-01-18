<?php 
/* Publication Archive */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query( array(
	'post_type' 	=> 'publication',
	'meta_key' 		=> 'publication_date',
	'orderby' 		=> 'meta_value_num title',
	'order' 			=> 'DESC',		
	'paged' 			=> $paged
)); ?>

<div id="publications" class="grid">
	<?php get_template_part('templates/loop', 'publication');
	/* Navigation */
	if ($wp_query->max_num_pages > 1) : ?>
		<nav class="post-nav">
			<ul class="pager">
				<li class="next"><?php next_posts_link(__('Older publications <i class="icon-chevron-right"></i>', 'dedato')); ?></li>
				<li class="previous"><?php previous_posts_link(__('<i class="icon-chevron-left"></i> Newer publications', 'dedato')); ?></li>
			</ul>
		</nav>
	<?php endif;
	wp_reset_query(); ?>
</div>