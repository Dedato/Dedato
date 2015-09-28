<?php if (have_posts()) :
	while (have_posts()) : the_post();
		// Date
		$unixdate 		= strtotime(get_field('project_date'));
		$projectdate	= date_i18n('F Y', $unixdate);
		// Size
		$gridsize 		= get_field('project_grid_size');
		if ($gridsize == 'small') 	$size = 'col-sm-3';
		if ($gridsize == 'normal')  $size = 'col-sm-6';
		if ($gridsize == 'large') 	$size = 'col-sm-9';
		// Image /Video
		$featured 		= get_field('project_feature');
		if ($featured == 'image') $projectimage = get_field('project_image');
		if ($featured == 'video') $projectvideo = get_field('project_video');
		// Categories				
		$categories 	= get_the_terms($post->ID, 'discipline');
		$catclass 		= null;
		$catoutput    = null;
		if($categories) {
			foreach($categories as $category) {
				// If it's not original language
				if (ICL_LANGUAGE_CODE != 'nl') {					
					$catid_en 		= icl_object_id($category->term_id, 'discipline', true);
					$category_en 	= get_term($catid_en, 'discipline');
					$catclass 		.= $category_en->slug . ' ';
					$catname 		  = $category_en->name;
					$catname 		  = str_replace(' @'.ICL_LANGUAGE_CODE, '', $catname); // remove @en from term title if it's the same
					$catlink 		  = get_term_link($category_en, 'discipline');
					$catoutput    .= '<a class="category" href="'. esc_url($catlink) .'">'. $catname .'</a>';
					if(end($categories) !== $category){
            $catoutput .= ', ';
          }
				} else {
					$catclass 	.= $category->slug . ' ';
					$catname 		= $category->name;
					$catlink 		= get_term_link($category, 'discipline');
					$catoutput  .= '<a class="category" href="'. esc_url($catlink) .'">'. $catname .'</a>';
      		if(end($categories) !== $category){
            $catoutput .= ', ';
          }
				}
        if (is_wp_error($catlink)) {
			   continue;
			  }
			}
		}
		/* Connected Clients 
		$clients = new WP_Query( array(
			'connected_type' 	=> 'project-client',
			'connected_items' => get_queried_object(),
			'nopaging' 			  => true	
		));*/ ?>
		<article <?php post_class($catclass . $size); ?> id="<?php echo $post->ID; ?>" name="<?php echo $post->ID; ?>" data-page="<?php echo $paged; ?>">
			<div class="entry-content">
				<?php if ($featured == 'image') {
					$alt 				= $projectimage['alt'];
					$img_xs_src = $projectimage['sizes']['medium'];
					$img_xs_w   = $projectimage['sizes']['medium-width'];
					$img_xs_h   = $projectimage['sizes']['medium-height'];
					$ratio      = ($img_xs_h / $img_xs_w) * 100;
					if ($gridsize == 'small') {
						// Images
						$img_src 	= $projectimage['sizes']['grid-small'];
						$img_w    = $projectimage['sizes']['grid-small-width'];
						$img_h    = $projectimage['sizes']['grid-small-height'];
						$ratio    = ($img_h / $img_w) * 100;
					}
					if ($gridsize == 'normal') {
						$img_src 	= $projectimage['sizes']['grid-normal'];
						$img_w 	  = $projectimage['sizes']['grid-normal-width'];
						$img_h 	  = $projectimage['sizes']['grid-normal-height'];
						$ratio    = ($img_h / $img_w) * 100;
					}
					if ($gridsize == 'large') {
						$img_src 	= $projectimage['sizes']['grid-large'];
						$img_w    = $projectimage['sizes']['grid-large-width'];
						$img_h    = $projectimage['sizes']['grid-large-height'];
						$ratio    = ($img_h / $img_w) * 100;
					}
					// Retina Images
					if (function_exists('wr2x_get_retina_from_url')) {
						$img_xs_2x_src 	= wr2x_get_retina_from_url($img_xs_src);
						$img_2x_src 	  = wr2x_get_retina_from_url($img_src);
					} ?>
					<div class="entry-image" style="padding-bottom:<?php echo $ratio; ?>%;">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="permalink">
							<picture class="stretch">
								<!--[if IE 9]><video style="display: none;"><![endif]-->
								<source srcset="<?php if ($img_2x_src) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x'; ?>" width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" media="(min-width:480px)" />
								<source srcset="<?php if ($img_xs_2x_src) { echo $img_xs_2x_src . ' 2x, '; } echo $img_xs_src .' 1x'; ?>" width="<?php echo $img_xs_w; ?>" height="<?php echo $img_xs_h; ?>" />
								<!--[if IE 9]></video><![endif]-->
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" srcset="<?php if ($img_2x_src) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x'; ?>" alt="<?php echo $alt; ?>" />
							</picture>
						</a>
					</div>
				<?php } elseif ($featured == 'video') { ?>
					<div class="entry-video">
						<?php _e(wp_oembed_get($projectvideo)); ?>
					</div>
				<?php } ?>
		  		<div class="entry-details">
		  			<h4 class="entry-title">
		  				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="permalink"><?php the_title(); ?></a>
		  			</h4>
		  			<div class="entry-summary">
		  				<?php the_excerpt(); ?>
		  			</div>	
		  			<footer class="entry-footer">
		  				<?php if ($catoutput): echo $catoutput; ?><!--<span class="divider">|</span>--><?php endif; ?>
			  			<span class="date"><?php //echo $projectdate; ?></span>
			  		</footer>
		  		</div>
			</div>
		</article>
	<?php	endwhile;
	wp_reset_postdata(); ?>
<?php endif; ?>