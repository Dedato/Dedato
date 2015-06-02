<?php

/* ==========================================================================
   Add body classes to call JS
   ========================================================================== */
   
function my_body_class($classes) {
  // Isotope
  if (is_front_page() || is_tax('discipline') || is_post_type_archive(array('project', 'publication', 'client')) ) {
    $classes[] = 'isotope';
  }
  if (is_front_page() || is_tax('discipline') || is_post_type_archive(array('project', 'publication')) ) {
    $classes[] = 'infinitescroll';
  }
  return $classes;
}
add_filter('body_class','my_body_class');


/* Add rel to next and previous posts link */
add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');

if (!function_exists('get_next_posts_link_attributes')){
	function get_next_posts_link_attributes($attr){
		$attr = 'rel="next" title="'. __("Next posts","dedato") .'"';
		return $attr;
	}
}
if (!function_exists('get_previous_posts_link_attributes')){
	function get_previous_posts_link_attributes($attr){
		$attr = 'rel="prev" title="'. __("Previous posts","dedato") .'"';
		return $attr;
	}
}


/* ==========================================================================
   Non-translatable Slug Rewrites Rules
   ========================================================================== */ 

function re_rewrite_rules() {
    global $wp_rewrite;
    $wp_rewrite->author_base        = 'auteur';
    $wp_rewrite->search_base        = 'zoeken';
    $wp_rewrite->comments_base      = 'reacties';
    $wp_rewrite->pagination_base    = 'pagina';
}
add_action('init', 're_rewrite_rules');



/* ==========================================================================
   Custom Wordpress Login & Admin Page
   ========================================================================== */  
   
/* Custom style Wordpress login page */
function wp_custom_login() { 
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/assets/css/wp-admin.css" />'; 
}
// Change url logo Wordpress login page
function put_my_url(){
	return (get_home_url());
}
// Custom style Wordpress dashboard
function wp_custom_admin() { 
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/assets/css/wp-admin.css" />'; 
}
add_action('login_head', 'wp_custom_login');
add_filter('login_headerurl', 'put_my_url');
add_action('admin_head', 'wp_custom_admin');



/* ==========================================================================
   Yoast SEO plugin tweaks
   ========================================================================== */

/* 
 *  Add query var on projects archive page 
 */
add_filter('wpseo_title', 'add_client_var_archive_wpseo_title'); 
function add_client_var_archive_wpseo_title( $content ) {
  global $wp_query;
  if ( is_post_type_archive('project') ) {
    $clientslug = get_query_var('klant');
    if ($clientslug) {
      $args = array(
    	  'name' 		  => $clientslug,
    	  'post_type' => 'client'
    	);
    	$clients = get_posts($args);
    	if ($clients) {
    		$client_id    = $clients[0]->ID;
    		$client_title = $clients[0]->post_title;
    		$seo_titles   = get_option( 'wpseo_titles' );
        $seo_title    = $seo_titles['title-ptarchive-project'];
        $content      = $client_title .' '. $content;
    	}
    }
  }
  return $content;
}

/* 
 *  Lowercase WordPress SEO titles 
 */
add_filter('wpseo_title', 'strtolower_wpseo_title');
function strtolower_wpseo_title( $content ) {
	return strtolower( $content );
}

/*
 *  Replace facebook og:image based upon page type
 *  Only works if default image is set in Social Media > Facebook settings
 */
//function custom_og_image() {
add_filter('wpseo_opengraph_image', function() use($ogimage){
  
  global $wp_query;
  $post_id = get_the_ID();
  
  // Homepage    
  if(is_front_page()) {
    $wp_query = new WP_Query( array(
  		'post_type' 		  => 'project',
  		'meta_key' 			  => 'project_date',
  		'meta_query'      => array(
        'key'             => 'project_date',
        'type'            => 'date'
      ),
  		'orderby' 			  => 'meta_value_num date',
  		'order' 				  => 'DESC'
  	));
    $first_project  = $wp_query->posts[0];
    $featured       = get_field('project_feature', $first_project->ID);
    if ($featured == 'image') $projectimage = get_field('project_image', $first_project->ID);
    $ogimage        = $projectimage['sizes']['large'];
    wp_reset_query();
    
  // Project archive    
  } elseif(is_post_type_archive('project')) {
    // Get client projects
    $clientslug = get_query_var('klant');
    if ($clientslug) {
    	$args = array(
    	  'name' 		  => $clientslug,
    	  'post_type' => 'client'
    	);
    	$clients = get_posts($args);
    	if ($clients) {
    		$clientid = $clients[0]->ID;
    		$wp_query = new WP_Query( array(
    			'connected_type' 	=> 'project-client',
    			'connected_items' => $clientid,
    			'meta_key' 			  => 'project_date',
    			'meta_query'      => array(
            'key'             => 'project_date',
            'type'            => 'date'
          ),
    			'orderby' 			  => 'meta_value_num date',
    			'order' 				  => 'DESC'
    		));
    	}
    } else {
    	// Get all projects
    	$wp_query = new WP_Query( array(	
    		'post_type' 		=> 'project',
    		'meta_key' 			=> 'project_date',
    		'meta_query'    => array(
          'key'           => 'project_date',
          'type'          => 'date'
        ),
    		'orderby' 			=> 'meta_value_num date',
    		'order' 				=> 'DESC'
    	));
    }
    $first_project  = $wp_query->posts[0];
    $featured       = get_field('project_feature', $first_project->ID);
    if ($featured == 'image') $projectimage = get_field('project_image', $first_project->ID);
    $ogimage        = $projectimage['sizes']['large'];
    wp_reset_query();
  
  // Discipline archive    
  } elseif(is_tax('discipline')) {
    $term       = $wp_query->get_queried_object();
    if (ICL_LANGUAGE_CODE != 'nl') {
    	remove_all_filters('get_term');
    	$termid_org = icl_object_id($term->term_id, 'discipline', true, 'nl');
    	$term				= get_term($termid_org, 'discipline');
    }
    $clientslug = get_query_var('klant');
    // Get client term projects
    if ($clientslug) {
    	$args = array(
    	  'name' 		  => $clientslug,
    	  'post_type' => 'client'
    	);
    	$clients = get_posts($args);
    	if ($clients) {
    		$clientid = $clients[0]->ID;
    		$wp_query = new WP_Query( array(
    			'connected_type' 	=> 'project-client',
    			'connected_items' => $clientid,
          'discipline' 		  => $term->slug,
    			'meta_key' 			  => 'project_date',
    			'meta_query'      => array(
            'key'             => 'project_date',
            'type'            => 'date'
          ),
    			'orderby' 			  => 'meta_value_num date',
    			'order' 				  => 'DESC'
    		));
    	}
    } else {
    	// Get all term projects
    	$wp_query = new WP_Query( array(	
    		'post_type' 		=> 'project',
    		'discipline' 		=> $term->slug,
    		'meta_key' 			=> 'project_date',
    		'meta_query'    => array(
          'key'           => 'project_date',
          'type'          => 'date'
        ),
    		'orderby' 			=> 'meta_value_num date',
    		'order' 				=> 'DESC'
    	));
    }
    $first_project  = $wp_query->posts[0];
    $featured       = get_field('project_feature', $first_project->ID);
    if ($featured == 'image') $projectimage = get_field('project_image', $first_project->ID);
    $ogimage        = $projectimage['sizes']['large'];
    wp_reset_query();
    
  // Client archive  
  } elseif(is_post_type_archive('client')) {
    $wp_query = new WP_Query( array(
  		'post_type' => 'client',
  		'orderby'	  => 'name',
  		'order'		  => 'ASC',
  		'nopaging'	=> true
  	));
    $first_client = $wp_query->posts[0];
    $clientimage  = get_field('client_image', $first_client->ID);
    $ogimage 	    = $clientimage['sizes']['large'];
    wp_reset_query();
    
  // Publication archive  
  } elseif(is_post_type_archive('publication')) {
    $wp_query = new WP_Query( array(
    	'post_type' 	=> 'publication',
    	'meta_key' 		=> 'publication_date',
    	'orderby' 		=> 'meta_value_num date',
    	'order' 			=> 'DESC'
    ));
    $first_pub  = $wp_query->posts[0];
    $featured   = get_field('publication_feature', $first_pub->ID);
    if ($featured == 'image') $pubimage = get_field('publication_image', $first_pub->ID);
    $ogimage 	  = $pubimage['sizes']['large'];
    wp_reset_query();
    
  // Single project  
  } elseif (is_singular('project')) {
    $featured = get_field('project_feature', $post_id);
    if ($featured == 'image') $projectimage = get_field('project_image');
    $ogimage  = $projectimage['sizes']['large'];
    
  // Single client  
  } elseif(is_singular('client')) {
    $clientimage = get_field('client_image', $post_id);
    $ogimage 	   = $clientimage['sizes']['large'];
    
  // Single publication  
  } elseif(is_singular('publication')) {
    $featured = get_field('publication_feature', $post_id);
    if ($featured == 'image') $pubimage = get_field('publication_image');
    $ogimage 	= $pubimage['sizes']['large'];
  }
  
  // Use default if custom image is not set
  if ($ogimage) {
    //$GLOBALS['wpseo_og']->image_output($ogimage);
  } else {
    $ogimage 	= $GLOBALS['wpseo_og']->options['og_default_image'];
  }
  return $ogimage;
});
//add_action('wpseo_opengraph', 'custom_og_image', 29);



/* ==========================================================================
   Disable JPEG Compression
   ========================================================================== */
   
add_filter('jpeg_quality', create_function('', 'return 100;'));