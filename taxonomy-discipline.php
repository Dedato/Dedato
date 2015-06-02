<?php
// Get taxonomy term
$term =	$wp_query->queried_object;
// Get original taxonomy term 
if (ICL_LANGUAGE_CODE != 'nl') {
	remove_all_filters('get_term'); // necessary to get original term
	$termid_org 	= icl_object_id($term->term_id, 'discipline', true, 'nl');
	$term				= get_term($termid_org, 'discipline');
}

// Get client var
if( isset($wp_query->query_vars['klant']) ) {
	$clientslug = $wp_query->query_vars['klant'];
	// Get post ID by slug
	$args = array(
	  'name' 				=> $clientslug,
	  'post_type' 			=> 'client'
	);
	$clients = get_posts($args);
	if ($clients) {
		$clientid = $clients[0]->ID;
		// Get client projects
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$wp_query = new WP_Query( array(
			'connected_type' 	=> 'project-client',
			'connected_items' => $clientid,
			'discipline' 		=> $term->slug,
			'meta_key' 			=> 'project_date',
			'orderby' 			=> 'meta_value_num date',
			'order' 				=> 'DESC',
			'paged' 				=> $paged
		));
	}
} else {
	// Get discipline projects
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$wp_query = new WP_Query( array(	
		'post_type' 		=> 'project',
		'discipline' 		=> $term->slug,
		'meta_key' 			=> 'project_date',
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
	wp_reset_query();  ?>
</div>