<?php
/* ==========================================================================
   Posts 2 Posts Connections
   ========================================================================== */
   
function my_connection_types() {
	// Project -> Client
	p2p_register_connection_type( array(
		'name' 			=> 'project-client',
		'from' 			=> 'project',
		'to' 				=> 'client',
		'cardinality'	=> 'many-to-many',
		'sortable'		=> 'to',
		'admin_box' 	=> array(
			'show' 			=> 'any',
			'context' 		=> 'side'
		),
		'admin_column' 	=> 'any'
	));
	// Publication -> Project
	p2p_register_connection_type( array(
		'name'			=> 'project-publication',
		'from'			=> 'project',
		'to'				=> 'publication',
		'cardinality'	=> 'many-to-many',
		'sortable'		=> 'to',
		'admin_box' 	=> array(
			'show' 			=> 'any',
			'context' 		=> 'side'
		),
		'admin_column' => 'any',
		'from_labels' 	=> array(
			'column_title' 	=> __('Connected Publications','dedato')
		)
	));
}
add_action('p2p_init', 'my_connection_types');


/* ==========================================================================
   Sidebar Connections
   ========================================================================== */

// Connected Clients   
function get_connected_clients() {
	/* Connected Clients */
	$clients = new WP_Query( array(
		'connected_type' 	=> 'project-client',
		'connected_items' => get_queried_object(),
		'nopaging' 			=> true	
	));
	if ($clients->have_posts()) : ?>
		<div class="clients col-xs-6">
			<?php while ($clients->have_posts() ) : $clients->the_post();
				$clientid 		= get_the_ID();
				$clientslug 	= get_post($post)->post_name;
				$clientimage 	= get_field('client_image');
				$alt 			= $clientimage['alt'];
				$img_src 		= $clientimage['sizes']['medium']; 
				/* Get Retina images */
				if (function_exists('wr2x_get_retina')) {
					$img_2x 		= wr2x_get_retina( trailingslashit( ABSPATH ) . wr2x_get_pathinfo_from_image_src($img_src) );
					$img_2x_src 	= trailingslashit( get_site_url() ) . ltrim( str_replace( ABSPATH, "", $img_2x ), '/' );	
				}
			  // Connected projects
				$projects = new WP_Query(array(
					'post_type' 		  => 'project',
					'connected_type' 	=> 'project-client',
					'connected_items' => $clientid,
					'nopaging' 			  => true	
				)); ?>
				<article <?php post_class(); ?>>
					<div class="entry-content">
						<div class="entry-image">
  						<?php if ($projects->have_posts()) { ?>
  						  <a class="cat" href="<?php echo get_post_type_archive_link('project') . $clientslug; ?>" title="<?php echo sprintf(__('View all projects for %1$s','dedato'), get_the_title() ); ?>">
              <?php } ?>
  							<picture>
  								<!--[if IE 9]><video style="display: none;"><![endif]-->
  								<source srcset="<?php if ($img_2x) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x'; ?>">
  								<!--[if IE 9]></video><![endif]-->
  								<img srcset="<?php echo $img_src; ?>" alt="<?php echo $alt; ?>">
  							</picture>
  						<?php if ($projects->have_posts()) { ?></a><?php } ?>
						</div>
						<div class="entry-details">
			  			<h3 class="entry-title"><?php _e('Other projects for','dedato'); ?> <?php the_title(); ?></h3>
			  			<ul class="archive-list">
					  		<?php if ($projects->have_posts()) { ?>
  				  		  <li class="all">
  									<a class="cat" href="<?php echo get_post_type_archive_link('project') . $clientslug; ?>" title="<?php echo sprintf(__('View all projects for %1$s','dedato'), get_the_title() ); ?>"><?php _e('All disciplines', 'dedato'); ?></a>
  								</li>
  							<?php }
  							// Projects by term
				  			$terms = get_terms('discipline');
                $count = count($terms);
  							if ($count > 0){
  								foreach ($terms as $term) {
  									$term_link = get_term_link($term, 'discipline');
  									// Connected Projects
  									$projects = new WP_Query(array(
  										'post_type' 		  => 'project',
  										'connected_type' 	=> 'project-client',
  										'connected_items' => $clientid,
  										'discipline' 		  => $term->slug,
  										'nopaging' 			  => true	
  									));
  									if ($projects->have_posts()) { ?>
  										<li class="<?php echo $term->slug; ?>">
  											<a class="cat" href="<?php echo esc_url($term_link) . $clientslug; ?>" title="<?php echo sprintf(__('View all %1$s projects for %2$s','dedato'), $term->slug, get_the_title() ); ?>"><?php echo $term->name; ?></a>
  										</li>
  									<?php }
  								}
  								wp_reset_postdata();
  							} ?>
			  			</ul>
			  		</div>
					</div>	
				</article>
			<?php endwhile; 
			wp_reset_postdata(); ?>
		</div>		
	<?php endif;
}


// Connected Publications
function get_connected_publications() {
	$publications = new WP_Query( array(
		'connected_type' 	=> 'project-publication',
		'connected_items' => get_queried_object(),
		'meta_key' 			  => 'publication_date',
		'orderby' 			  => 'meta_value_num',
		'order' 				  => 'DESC',	
		'nopaging' 			  => true	
	));
	if ($publications->have_posts()) : ?>
		<div class="publications col-xs-6">
			<article <?php post_class(); ?>>
				<div class="entry-content">
					<div class="entry-image">
						<?php
						/* Use first image as thumbnail */
						$pubid 		= $publications->posts[0]->ID;
						$pubimage = get_field('publication_image', $pubid);
						if (!$pubimage) $pubimage = get_field('publication_image', $publications->posts[1]->ID);
						if ($pubimage) :
  						$alt 		  = $pubimage['alt'];
  						$img_src 	= $pubimage['sizes']['medium'];
  						$img_srch = $pubimage['sizes']['medium-height'];
  						/* Get Retina images */
  						if (function_exists('wr2x_get_retina')) {
  							$img_2x 		= wr2x_get_retina( trailingslashit( ABSPATH ) . wr2x_get_pathinfo_from_image_src($img_src) );
  							$img_2x_src 	= trailingslashit( get_site_url() ) . ltrim( str_replace( ABSPATH, "", $img_2x ), '/' );	
  						} ?>
  						<picture>
  							<!--[if IE 9]><video style="display: none;"><![endif]-->
  							<source srcset="<?php if ($img_2x) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x';  ?>">
  							<!--[if IE 9]></video><![endif]-->
  							<img srcset="<?php echo $img_src; ?>" alt="<?php echo $alt; ?>">
  						</picture>
  					<?php endif; ?>
					</div>
					<div class="entry-details">
			  			<h3 class="entry-title"><?php _e('Publications about this project','dedato'); ?></h3>
			  			<ul class="archive-list">
			  				<?php while ($publications->have_posts() ) : $publications->the_post(); 
				  				$unixdate 	= strtotime(get_field('publication_date'));
				  				$pubdate		= date_i18n('d F Y', $unixdate);
				  				$pubsource	= get_field('publication_source');
			  					?>
			  					<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?>, <span class="date"><?php echo $pubdate; ?></span></a></li>
			  				<?php endwhile; 
				  			wp_reset_postdata(); ?>
			  			</ul>
			  		</div>
				</div>	
			</article>			
		</div>		
	<?php endif;
}

// Connected Projects
function get_connected_projects( $type ) {
	$clientid = get_the_ID();
	$projects = new WP_Query( array(
		'connected_type' 	=> $type,
		'connected_items' => get_queried_object(),
		'meta_key' 			=> 'project_date',
		'orderby' 			=> 'meta_value_num',
		'order' 				=> 'DESC',
		'posts_per_page' 	=> 5
	));
	if ($projects->have_posts()) : ?>
		<div class="projects col-xs-6">
			<article <?php post_class(); ?>>
				<div class="entry-content">
					<div class="entry-image">
						<?php
						/* Use first image as thumbnail */
						$projectid 		= $projects->posts[0]->ID;
						$projectimage 	= get_field('project_image', $projectid);
						$alt 			= $projectimage['alt'];
						$img_src 		= $projectimage['sizes']['medium'];
						$img_srch 		= $projectimage['sizes']['medium-height'];
						/* Get Retina images */
						if (function_exists('wr2x_get_retina')) {
							$img_2x 		= wr2x_get_retina( trailingslashit( ABSPATH ) . wr2x_get_pathinfo_from_image_src($img_src) );
							$img_2x_src 	= trailingslashit( get_site_url() ) . ltrim( str_replace( ABSPATH, "", $img_2x ), '/' );	
						} ?>
						<picture>
							<!--[if IE 9]><video style="display: none;"><![endif]-->
							<source srcset="<?php if ($img_2x) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x';  ?>">
							<!--[if IE 9]></video><![endif]-->
							<img srcset="<?php echo $img_src; ?>" alt="<?php echo $alt; ?>">
						</picture>
					</div>
					<div class="entry-details">
						<?php if ($type == 'project-client') {
							$title = __('Latest projects for','dedato') .' '. get_the_title($clientid);
						} elseif ($type == 'project-publication') {
							$title = __('Projects regarding this publication', 'dedato');
						} ?>
						<h3 class="entry-title"><?php echo $title; ?></h3>
						<ul class="archive-list">
							<?php while ($projects->have_posts() ) : $projects->the_post();
								$unixdate 		= strtotime(get_field('project_date'));
								$projectdate	= date_i18n('F Y', $unixdate);
								?>
								<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?>, <span class="date"><?php echo $projectdate; ?></span></a></li>
							<?php endwhile; 
							wp_reset_postdata(); ?>	
			  			</ul>
			  		</div>
				</div>	
			</article>
		</div>		
	<?php endif;
}