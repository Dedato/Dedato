<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// Get client var
if ( isset($wp_query->query_vars['klant']) ) {
	$clientslug = $wp_query->query_vars['klant'];
	// Get post ID by slug
	$args = array(
	  'name' 		  => $clientslug,
	  'post_type' => 'client'
	);
	$clients = get_posts($args);
	if ($clients) {
		$clientid = $clients[0]->ID;
		// Get client projects
		$wp_query = new WP_Query( array(
			'connected_type' 	=> 'project-client',
			'connected_items' => $clientid,
			//'discipline' 		  => $term->slug,
			'meta_key' 			  => 'project_date',
			'meta_query'      => array(
        'key'             => 'project_date',
        'type'            => 'date'
      ),
			'orderby' 			  => 'meta_value_num date',
			'order' 				  => 'DESC',
			'paged' 				  => $paged
		));
	}
} else {
	// Get projects
	$wp_query = new WP_Query( array(	
		'post_type' 		=> 'project',
		'meta_key' 			=> 'project_date',
		'meta_query'    => array(
      'key'           => 'project_date',
      'type'          => 'date'
    ),
		'orderby' 			=> 'meta_value_num date',
		'order' 				=> 'DESC',
		'paged' 				=> $paged
	));
} ?>
	
<div id="projects" class="grid">
	<?php get_template_part('templates/loop', 'project');
	/* Navigation */
	if ($wp_query->max_num_pages > 1) : ?>
		<nav class="post-nav">
			<ul class="pager">
				<li class="next"><?php next_posts_link(__('Older projects <i class="icon-chevron-right"></i>', 'dedato')); ?></li>
				<li class="previous"><?php previous_posts_link(__('<i class="icon-chevron-left"></i> Newer projects', 'dedato')); ?></li>
			</ul>
		</nav>
	<?php endif;
	wp_reset_query(); ?>
</div>