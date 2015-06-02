<?php
/* Single Project */
if ( get_post_type() == 'project' ) {
	get_template_part('templates/content', 'single-project');
/* Single Client */
} elseif ( get_post_type() == 'client' ) {
	get_template_part('templates/content', 'single-client');
/* Single Publication */
} elseif ( get_post_type() == 'publication' ) {
	get_template_part('templates/content', 'single-publication');
/* Everything Else */
} else {
	get_template_part('templates/content', 'single');
} ?>