<div id="clients" class="grid row">
	<?php
	/* Client Archive */
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$wp_query = new WP_Query( array(
		'post_type' => 'client',
		'orderby'	  => 'name',
		'order'		  => 'ASC',
		//'paged' 		=> $paged
		'nopaging'	=> true
	));
	get_template_part('templates/loop', 'client'); 
	/* Navigation */
	if ($wp_query->max_num_pages > 1) : ?>
		<nav class="post-nav">
			<ul class="pager">
				<li class="next"><?php next_posts_link(__('Older clients <i class="icon-chevron-right"></i>', 'dedato')); ?></li>
				<li class="previous"><?php previous_posts_link(__('<i class="icon-chevron-left"></i> Newer clients', 'dedato')); ?></li>
			</ul>
		</nav>
	<?php endif;
	wp_reset_query(); ?>
</div>