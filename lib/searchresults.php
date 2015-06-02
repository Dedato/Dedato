<?php

/* ==========================================================================
   Highlighted Searchresults
   ========================================================================== */
   
/* Exclude specific pages from searchresults */
function filter_where($where = '') {
	if ( is_search() ) {
		$exclude = array();	
		for($x=0; $x<count($exclude); $x++){
		  $where .= " AND ID != ".$exclude[$x];
		}
	}
	return $where;
}
add_filter('posts_where', 'filter_where');

/* Highlight searchresults title */
function searchresults_title_highlight() {
	// Get total searchresults
	global $wp_query;
	$total = $wp_query->found_posts;
	echo '<span class="searchnr">'. $total .'</span>';
	_e('Searchresults for', 'dedato');
	echo ' "<span class="search-highlight">'. get_search_query() .'</span>"';
}

/* Highlight searchresult title */
function search_title_highlight() {
	$title = get_the_title();
	$keys = implode('|', explode(' ', get_search_query()));
	$title = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>', $title);
	echo $title;
}

/* Highlight searchresult in excerpt */
function search_excerpt_highlight() {
	$excerptorg = the_excerpt();
	$excerpt = strip_tags($excerptorg, '<p>');
		
	$keys = implode('|', explode(' ', get_search_query()));
	$excerpt = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>', $excerpt);
	echo $excerpt;
}