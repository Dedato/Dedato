<?php while (have_posts()) : the_post(); 
	// Date
	$unixdate 			= strtotime(get_field('project_date'));
	$projectdate		= date_i18n('F Y', $unixdate);
	$projectwebsite = get_field('project_website');
	if ($projectwebsite == 'yes') $projecturl = get_field('project_website_url');
	// Architecture Deatils
	$archproject 		= get_field('project_arch_details');
	if ($archproject == 'yes') {
		$archname 		= get_field('project_arch_name');
		$archfunction = get_field('project_arch_function');
		$archaddress 	= get_field('project_arch_address');
		$archsurface 	= get_field('project_arch_surface');
	}
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
          $catoutput  .= ', ';
        }
			} else {
				$catclass 	  .= $category->slug . ' ';
				$catname 		  = $category->name;
				$catlink 		  = get_term_link($category, 'discipline');
				$catoutput    .= '<a class="category" href="'. esc_url($catlink) .'">'. $catname .'</a>';
    		if(end($categories) !== $category){
          $catoutput  .= ', ';
        }
			}
      if (is_wp_error($catlink)) {
		   continue;
		  }
		}
	}
	// Connected Clients
	$clients = new WP_Query( array(
		'connected_type' 	=> 'project-client',
		'connected_items' => get_queried_object(),
		'nopaging' 			=> true	
	)); 
	$tclients =  $clients->post_count; ?>
	<article <?php post_class(); ?>>
		<div class="entry-content">
			<?php 
  		// Slideshow 
  		if ($featured == 'image') {
				$images 	= get_field('project_gallery');
				if ($images) : ?>					
					<div class="flexslider">
						<ul class="slides">
							<?php $i = 0;
							foreach($images as $image):
								// Sizes
								$img_md_src 	= $image['sizes']['medium'];
                $img_md_w     = $image['sizes']['medium-width'];
                $img_md_h     = $image['sizes']['medium-height'];
								$img_lg_src 	= $image['sizes']['large'];
								$img_xl_src 	= $image['sizes']['x-large'];
								$img_xxl_src 	= $image['sizes']['xx-large'];
								$alt 		      = $image['alt'];
								$ratio        = ($img_md_h / $img_md_w) * 100;
								// Portrait / Landscape
								if ($ratio < 100) {
									$orientation = 'landscape';
								} else { 
									$orientation = 'portrait';
								}
								// Retina Images
                if (function_exists('wr2x_get_retina_from_url')) {
              		$img_md_2x_src 	= wr2x_get_retina_from_url($img_md_src);
              		$img_lg_2x_src 	= wr2x_get_retina_from_url($img_lg_src);
              		$img_xl_2x_src 	= wr2x_get_retina_from_url($img_xl_src);
              		$img_xxl_2x_src = wr2x_get_retina_from_url($img_xxl_src);
              	} ?>
								<li class="<?php echo $orientation; ?>">
								  <div class="entry-image" style="padding-bottom:<?php echo $ratio; ?>%;">
  									<?php if ($i == 0) { ?>
  										<picture class="stretch" id="img-<?php echo $i ?>">
  											<!--[if IE 9]><video style="display: none;"><![endif]-->
  											<source srcset="<?php if ($img_xxl_2x_src) { echo $img_xxl_2x_src . ' 2x, '; } echo $img_xxl_src .' 1x';  ?>" media="(min-width:1700px)">
  											<source srcset="<?php if ($img_xl_2x_src) { echo $img_xl_2x_src . ' 2x, '; } echo $img_xl_src .' 1x';  ?>" media="(min-width:1280px)">
  											<source srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x';  ?>" media="(min-width:510px)">
  											<source srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x';  ?>">
  											<!--[if IE 9]></video><![endif]-->
  											<img srcset="<?php echo $img_lg_src; ?>" alt="<?php echo $alt; ?>" />
  										</picture>	
  									<?php } else { ?>
  										<picture class="stretch" id="img-<?php echo $i ?>">
  										  <!--[if IE 9]><video style="display: none;"><![endif]-->
  										  <source data-srcset="<?php if ($img_xxl_2x_src) { echo $img_xxl_2x_src . ' 2x, '; } echo $img_xxl_src .' 1x';  ?>" media="(min-width:1700px)">
  										  <source data-srcset="<?php if ($img_xl_2x_src) { echo $img_xl_2x_src . ' 2x, '; } echo $img_xl_src .' 1x';  ?>" media="(min-width:1280px)">
  											<source data-srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x';  ?>" media="(min-width:510px)">
  											<source data-srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x';  ?>">
  											<!--[if IE 9]></video><![endif]-->
  											<!--[if gte IE 9]><!-->
                          <img class="lazyload" data-srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x'; ?>" alt="<?php echo $alt; ?>" />
  											<!--<![endif]-->
  											<!--[if lt IE 9]><img src="<?php echo $img_lg_src; ?>" alt="<?php echo $alt; ?>" /><![endif]-->
  										</picture>
  									<?php } ?>
								  </div>	   
									<?php $i++; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>	
				<?php endif;
  		// Video		
			} elseif ($featured == 'video') {
				$videourl = add_query_arg(array('title' => '0', 'byline' => '0', 'portrait' => '0'), $projectvideo); ?>
				<div class="entry-video">
					<?php _e(wp_oembed_get($videourl)); ?>
				</div>
			<?php } ?>
  		<div class="entry-details">
  			<h2 class="entry-title"><?php the_title(); ?></h2>
  			<div class="entry-content">
  				<?php the_content(); ?>
  				<?php // Architecture details
  				if ($archproject == 'yes') { ?>
  					<div class="arch-details table-responsive">
	  					<table class="table table-striped table-condensed">
					      <tbody>
					      	<?php if ($archname) { ?>
							      <tr>
							         <td><?php _e('Project','dedato'); ?></td>
						         	<td class="name"><?php echo $archname; ?></td>
						        </tr>
					      	<?php } ?>
					      	<?php if ($clients->have_posts()) : ?>
							      <tr>
							        <td><?php _e('Client','dedato'); ?></td>
						         	<td class="client">
  						         	<?php while ($clients->have_posts() ) : $clients->the_post();
                          $c++;
                          the_title();
                          if ($c < $tclients) echo ', ';
                        endwhile; ?>
						         	</td>
						        </tr>
                    <?php 
                    $c = 0;
  					        wp_reset_postdata();
					      	endif; ?>
					      	<?php if ($archfunction) { ?>
									<tr>  
										<td><?php _e('Function','dedato'); ?></td>
										<td class="function"><?php echo $archfunction; ?></td>
									</tr>
								<?php } ?>
								<?php if ($archaddress) { ?>
									<tr>  
										<td><?php _e('Address','dedato'); ?></td>
										<td class="address">
											<?php 
											// Get post meta field in order to print individual values
											$address = get_post_meta($post->ID, 'project_arch_address'); ?>
											<a href="http://maps.google.nl/?q=<?php echo $address[0]['address1'].','. $address[0]['city'].','.$address[0]['country']; ?>" title="<?php _e('View location in Google Maps','dedato'); ?>" target="_blank"><?php echo $archaddress; ?></a>
										</td>
									</tr>
								<?php } ?>
								<?php if ($archsurface) { ?>	
									<tr>  
										<td><?php _e('Surface','dedato'); ?></td>
										<td class="surface"><?php echo $archsurface; ?></td>
									</tr>
								<?php } ?>	
					      </tbody>
	  					</table>
  					</div>
  				<?php } ?>
  			</div>	
  			<footer class="entry-footer">
  				<?php if ($projecturl) : ?>
  					<a class="btn btn-sm btn-primary" title="<?php echo $projecturl['title']; ?>" href="<?php echo $projecturl['url']; ?>" target="_blank">
		  				<i class="icon-globe"></i><?php echo $projecturl['title']; ?></a>
	  			<?php endif; ?>
	  			<div class="meta">
	  				<?php if ($catoutput): echo $catoutput; ?><span class="divider">|</span><?php endif; ?> 
		  			<span class="date"><?php echo $projectdate; ?></span>
	  				<?php if ($clients->have_posts()) : ?>
						  <span class="divider">|</span>
              <span class="client">
							  <?php _e('Client:','dedato'); echo ' ';
                while ($clients->have_posts() ) : $clients->the_post();
                  $c++;
							    the_title();
							    if ($c < $tclients) echo ', ';
                endwhile; ?>
              </span>	
              <?php $c = 0;
              wp_reset_postdata();
            endif; ?>
	  			</div>	
	  		</footer>
	  	</div>
	  </div>	
	</article>
<?php endwhile; ?>