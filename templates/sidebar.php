<?php
/* Single Project */
if ( get_post_type() == 'project' ) { ?>
	<div class="connections row">
		<?php get_connected_clients(); ?>
		<?php get_connected_publications(); ?>
	</div>
<?php /* Single Client */
} elseif ( get_post_type() == 'client' ) { ?>
	<div class="connections row">
		<?php get_connected_projects('project-client'); ?>
	</div>			
<?php /* Single Publication */
} elseif ( get_post_type() == 'publication' ) { ?>
	<div class="connections row">
		<?php get_connected_projects('project-publication'); ?>
	</div>
<?php } ?>

<div id="shareme" data-url="<?php echo get_permalink(); ?>" data-text="<?php the_title(); echo ' - '; bloginfo('title'); ?>"></div>

<?php 
/* Widgets */
dynamic_sidebar('sidebar-primary'); 
?>
