<?php if (have_posts()) :
	while (have_posts()) : the_post();
		$clientid 		= get_the_ID();
		$clientslug 	= get_post($post)->post_name;
		$clientimage 	= get_field('client_image');
		$alt 				  = $clientimage['alt'];
		// Sizes
		$img_tn_src 	= $clientimage['sizes']['thumbnail'];
		$img_md_src 	= $clientimage['sizes']['medium'];
		$img_md_w     = $clientimage['sizes']['medium-width'];
		$img_md_h     = $clientimage['sizes']['medium-height'];
		$ratio        = ($img_md_h / $img_md_w) * 100;
		// Retina Images
	  if (function_exists('wr2x_get_retina_from_url')) {
			$img_tn_2x_src 	= wr2x_get_retina_from_url($img_tn_src);
			$img_md_2x_src 	= wr2x_get_retina_from_url($img_md_src);
		}
    // Connected projects
		$projects = new WP_Query(array(
			'post_type' 		=> 'project',
			'connected_type' 	=> 'project-client',
			'connected_items' => $clientid,
			'nopaging' 			=> true	
		)); ?>			
		<article <?php post_class('col-sm-3'); ?> name="<?php echo $post->ID; ?>" data-page="<?php echo $paged; ?>">
			<div class="entry-content">
				<div class="entry-image" style="padding-bottom:<?php echo $ratio; ?>%;">
					<?php if ($projects->have_posts()) { ?>
						<a href="<?php echo get_post_type_archive_link('project') . $clientslug; ?>" title="<?php echo sprintf(__('View all projects for %1$s','dedato'), get_the_title() ); ?>">
					<?php } ?>	
						<picture class="stretch">
							<!--[if IE 9]><video style="display: none;"><![endif]-->
							<source srcset="<?php if ($img_tn_2x_src) { echo $img_tn_2x_src . ' 2x, '; } echo $img_tn_src .' 1x';  ?>" media="(min-width:768px)" />
							<source srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x'; ?>" />
							<!--[if IE 9]></video><![endif]-->
							<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x'; ?>" alt="<?php echo $alt; ?>" />
						</picture>
					<?php if ($projects->have_posts()) { ?></a><?php } ?>	
				</div>
				<div class="entry-details">
		  			<?php if ($projects->have_posts()) { ?>
						<a href="<?php echo get_post_type_archive_link('project') . $clientslug; ?>" title="<?php echo sprintf(__('View all projects for %1$s','dedato'), get_the_title() ); ?>">
					<?php } ?>	
		  					<h3 class="entry-title"><?php the_title(); ?></h3>
		  			<?php if ($projects->have_posts()) { ?></a><?php }
					wp_reset_postdata(); ?>
		  			<!--<ul class="archive-list">
            <?php 
		  		  // All projects
            $projects = new WP_Query(array(
							'post_type' 		=> 'project',
							'connected_type' 	=> 'project-client',
							'connected_items' => $clientid,
							'nopaging' 			=> true	
						));
						if ($projects->have_posts()) { ?>
			  				<li class="all">
								<a class="cat" href="<?php echo get_post_type_archive_link('project') . $clientslug; ?>" title="<?php echo sprintf(__('View all projects for %1$s','dedato'), get_the_title() ); ?>"><?php _e('All', 'dedato'); ?></a>
							</li>
						<?php }
						// Projects by discipline
			  			$terms = get_terms('discipline');
						$count = count($terms);
						if ($count > 0){
							foreach ($terms as $term) {
								$term_link = get_term_link($term, 'discipline');
								// Connected Projects
								$projects = new WP_Query(array(
									'post_type' 		=> 'project',
									'connected_type' 	=> 'project-client',
									'connected_items' => $clientid,
									'discipline' 		=> $term->slug,
									'nopaging' 			=> true	
								));
								if ($projects->have_posts()) { ?>
									<li class="<?php echo $term->slug; ?>">
										<a class="cat" href="<?php echo esc_url($term_link) . $clientslug; ?>" title="<?php echo sprintf(__('View all %1$s projects for %2$s','dedato'), $term->slug, get_the_title() ); ?>"><?php echo $term->name; ?></a>
									</li>
								<?php }
							}
							wp_reset_postdata();
						} ?>
		  			</ul>-->
		  		</div>
			</div>	
		</article>
	<?php endwhile;
	wp_reset_postdata(); ?>
<?php endif; ?>