<?php
  
 /* ==========================================================================
   Query Vars
   ========================================================================== */ 
   
function add_query_vars($vars) {
	$vars[] = 'klant'; // Add klant query var for filtering projects by client (Can't be the same as the client post type slug)
	$vars[] = 'pages'; // Add pages var for infiniteScroll back button positioning
	return $vars;
}
add_filter('query_vars', 'add_query_vars');


/* ==========================================================================
   Rewrite Rules
   ========================================================================== */
function eg_add_rewrite_rules() {
	global $wp_rewrite;
	$new_rules = array(
    // InfiniteScroll pages
		'paginas/1-?([0-9]{1,})/?$' 						            => 'index.php?page_id=4&pages=' . $wp_rewrite->preg_index(1),
		// Pagination rewrite rules
		'projecten/pagina/?([0-9]{1,})/?$' 						      => 'index.php?post_type=project&paged=' . $wp_rewrite->preg_index(1),
		'klanten/pagina/?([0-9]{1,})/?$' 							      => 'index.php?post_type=client&paged=' . $wp_rewrite->preg_index(1),
		'actueel/pagina/?([0-9]{1,})/?$' 							      => 'index.php?post_type=publication&paged=' . $wp_rewrite->preg_index(1),
		// Klant var rewrite rules
		'projecten/([^/]+)/?$' 											        => 'index.php?post_type=project&klant=' . $wp_rewrite->preg_index(1),
		'projecten/([^/]+)/pagina/?([0-9]{1,})/?$' 		      => 'index.php?post_type=project&klant=' . $wp_rewrite->preg_index(1). '&paged=' . $wp_rewrite->preg_index(2),
		'discipline/([^/]+)/([^/]+)/?$' 								    => 'index.php?discipline=' . $wp_rewrite->preg_index(1) .'&klant=' . $wp_rewrite->preg_index(2),
		'discipline/([^/]+)/([^/]+)/pagina/?([0-9]{1,})/?$' => 'index.php?discipline=' . $wp_rewrite->preg_index(1) .'&klant=' . $wp_rewrite->preg_index(2). '&paged=' . $wp_rewrite->preg_index(3)
	);
   $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'eg_add_rewrite_rules' );
