<?php
/**
 * Roots includes
 */
require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/sidebar.php');         // Sidebar class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/titles.php');          // Page titles
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/gallery.php');         // Custom [gallery] modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/relative-urls.php');   // Root relative URLs
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
/**
 * Custom Post types
 */
require_once locate_template('/lib/cpt-project.php');     // Project Post type
require_once locate_template('/lib/cpt-client.php');      // Client Post type
require_once locate_template('/lib/cpt-publication.php'); // Publication Post type
require_once locate_template('/lib/cpt-rewrite-rules.php'); // Rewrite Rules
/**
 * Other
 */
require_once locate_template('/lib/p2p-connections.php'); // Post 2 Post Connections
require_once locate_template('/lib/searchresults.php'); 	// Searchresults
require_once locate_template('/lib/custom.php');          // Custom functions
