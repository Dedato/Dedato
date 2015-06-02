<?php
/* ==========================================================================
   Post Type
   ========================================================================== */
function client_init() {
	register_post_type( 'client', array(
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'menu_position'		    => 6,
		'supports'            => array( 'title', 'editor' ),
		'has_archive'         => 'klanten',
		'query_var'           => true,
		'rewrite'             => array('slug' => 'client'),
		'labels'              => array(
			'name'                => __( 'Clients', 'dedato' ),
			'singular_name'       => __( 'Client', 'dedato' ),
			'add_new'             => __( 'Voeg klant toe' ),
			'all_items'           => __( 'Klanten' ),
			'add_new_item'        => __( 'Voeg nieuwe klant toe' ),
			'edit_item'           => __( 'Bewerk klant' ),
			'new_item'            => __( 'Nieuwe klant' ),
			'view_item'           => __( 'Bekijk klant' ),
			'search_items'        => __( 'Zoek klanten' ),
			'not_found'           => __( 'Geen klanten gevonden' ),
			'not_found_in_trash'  => __( 'Geen klanten gevonden in prullenbak' ),
			'parent_item_colon'   => __( 'Hoofd klant' ),
			'menu_name'           => __( 'Klanten' ),
		),
	));
}
/* Messages */
function client_updated_messages( $messages ) {
	global $post;
	$permalink = get_permalink( $post );
	$messages['client'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Klant bijgewerkt. <a target="_blank" href="%s">Bekijk klant</a>'), esc_url( $permalink ) ),
		2 => __('Aangepast veld bijgewerkt.'),
		3 => __('Aangepast veld verwijderd.'),
		4 => __('Klant bijgewerkt.'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Klant hersteld tot revisie van %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Klant gepubliceerd. <a href="%s">Bekijk klant</a>'), esc_url( $permalink ) ),
		7 => __('Klant bewaard.'),
		8 => sprintf( __('Klant ingediend. <a target="_blank" href="%s">Voorvertoning klant</a>'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Klant gepland voor: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Voorvertoning klant</a>'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Klant concept bijgewerkt. <a target="_blank" href="%s">Voorvertoning klant</a>'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);
	return $messages;
}
add_action( 'init', 'client_init' );
add_filter( 'post_updated_messages', 'client_updated_messages' );