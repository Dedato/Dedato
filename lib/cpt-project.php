<?php
/* ==========================================================================
   Post Type
   ========================================================================== */
function project_init() {
	register_post_type('project', array(
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'menu_position'		 => 5,
		'supports'            => array('title', 'editor', 'excerpt'),
		'has_archive'         => 'projecten',
		'query_var'           => true,
		'rewrite'             => array('slug' => 'project'),
		'labels'              => array(
			'name'                => __( 'Projects', 'dedato' ),
			'singular_name'       => __( 'Project' ),
			'add_new'             => __( 'Voeg project toe' ),
			'all_items'           => __( 'Projecten' ),
			'add_new_item'        => __( 'Voeg nieuw project toe' ),
			'edit_item'           => __( 'Bewerk project' ),
			'new_item'            => __( 'Nieuw project' ),
			'view_item'           => __( 'Bekijk project' ),
			'search_items'        => __( 'Zoek projecten' ),
			'not_found'           => __( 'Geen projecten gevonden' ),
			'not_found_in_trash'  => __( 'Geen projecten gevonden in prullenbak' ),
			'parent_item_colon'   => __( 'Hoofd project' ),
			'menu_name'           => __( 'Projecten' ),
		),
	));
}
/* Messages */
function project_updated_messages( $messages ) {
	global $post;
	$permalink = get_permalink( $post );
	$messages['project'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Project bijgewerkt. <a target="_blank" href="%s">Bekijk project</a>'), esc_url( $permalink ) ),
		2 => __('Aangepast veld bijgewerkt.'),
		3 => __('Aangepast veld verwijderd.'),
		4 => __('Project bijgewerkt.'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Project hersteld tot revisie van %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Project gepubliceerd. <a href="%s">Bekijk project</a>'), esc_url( $permalink ) ),
		7 => __('Project bewaard.'),
		8 => sprintf( __('Project ingediend. <a target="_blank" href="%s">Voorvertoning project</a>'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Project gepland voor: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Voorvertoning project</a>'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Project concept bijgewerkt. <a target="_blank" href="%s">Voorvertoning project</a>'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);
	return $messages;
}
add_action( 'init', 'project_init' );
add_filter( 'post_updated_messages', 'project_updated_messages' );



/* ==========================================================================
   Taxonomies
   ========================================================================== */

/* Discipline taxonomy */
function discipline_taxonomy() {
  $labels = array(
    'name'              => __('Disciplines'),
    'singular_name'     => __('Discipline'),
    'search_items'      => __('Zoek disciplines'),
    'all_items'         => __('Alle disciplines'),
    'parent_item'       => __('Hoofddiscipline'),
    'parent_item_colon' => __('Hoofddiscipline:'),
    'edit_item'         => __('Bewerk discipline'),
    'update_item'       => __('Werk discipline bij'),
    'add_new_item'      => __('Voeg nieuwe discipline toe'),
    'new_item_name'     => __('Nieuwe discipline naam'),
    'menu_name'         => __('Disciplines')
  );
  $args = array(
    'labels'       		=> $labels,
    'public'            => true,
    'show_ui'      		=> true,
    'show_in_nav_menus'	=> true,
    'show_admin_column'	=> true,
    'hierarchical' 		=> true,
    'query_var'    		=> true,
    'rewrite'      		=> array('slug' => 'discipline')
  );
  register_taxonomy('discipline', 'project', $args);
}
add_action( 'init', 'discipline_taxonomy' );



/* ==========================================================================
   Sortable Admin Columns
   ========================================================================== */

/*
 * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
 * https://gist.github.com/906872
 */
add_filter('manage_edit-project_sortable_columns', 'projects_sort');
function projects_sort($columns) {
	$columns['column-meta'] = 'project_date';
	return $columns;
}

/*
 * ADMIN COLUMN - SORTING - ORDERBY
 * http://scribu.net/wordpress/custom-sortable-columns.html#comment-4732
 */
add_filter('request', 'project_date_column_orderby');
function project_date_column_orderby($vars) {
	if ( isset( $vars['orderby'] ) && 'project_date' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'project_date',
			'orderby' => 'meta_value_num',
			//'order' => 'asc' // don't use this; blocks toggle UI
		) );
	}
	return $vars;
}