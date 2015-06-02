<?php if (have_posts()) :
	while (have_posts()) : the_post();
		// Date
		$unixdate 	= strtotime(get_field('publication_date'));
		$pubdate		= date_i18n('d F Y', $unixdate);
		$pubsource	= get_field('publication_source');
		$pubfile 	= get_field('publication_file');
		// Image /Video
		$featured 		= get_field('publication_feature');
		if ($featured == 'image') $pubimage = get_field('publication_image');
		if ($featured == 'video') $pubvideo = get_field('publication_video');		
		// Size
		$gridsize 		= get_field('publication_grid_size');
		if ($gridsize == 'small') 	$size = 'col-sm-3';
		if ($gridsize == 'normal') $size = 'col-sm-6';
		if ($gridsize == 'large') 	$size = 'col-sm-9';
		?>
		<article <?php post_class($size); ?> name="<?php echo $post->ID; ?>" data-page="<?php echo $paged; ?>">
			<div class="entry-content">
				<?php if ($featured == 'image') {
					$alt 				= $pubimage['alt'];
					$img_xs_src = $pubimage['sizes']['medium'];
					$img_xs_w   = $pubimage['sizes']['medium-width'];
					$img_xs_h   = $pubimage['sizes']['medium-height'];
					$ratio      = ($img_xs_h / $img_xs_w) * 100;
					if ($gridsize == 'small') {
						$img_src 	= $pubimage['sizes']['grid-small'];
						$img_w    = $pubimage['sizes']['grid-small-width'];
						$img_h    = $pubimage['sizes']['grid-small-height'];
						$ratio    = ($img_h / $img_w) * 100;
					}
					if ($gridsize == 'normal') {
						$img_src 	= $pubimage['sizes']['grid-normal'];
						$img_w 	  = $pubimage['sizes']['grid-normal-width'];
						$img_h 	  = $pubimage['sizes']['grid-normal-height'];
						$ratio    = ($img_h / $img_w) * 100;
					}
					if ($gridsize == 'large') {
						$img_src 	= $pubimage['sizes']['grid-large']; 
            $img_w    = $pubimage['sizes']['grid-large-width'];
						$img_h    = $pubimage['sizes']['grid-large-height'];
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
								<source srcset="<?php if ($img_2x_src) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x';  ?>" width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" media="(min-width:480px)" />
								<source srcset="<?php if ($img_xs_2x_src) { echo $img_xs_2x_src . ' 2x, '; } echo $img_xs_src .' 1x';  ?>" width="<?php echo $img_xs_w; ?>" height="<?php echo $img_xs_h; ?>" />
								<!--[if IE 9]></video><![endif]-->
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" srcset="<?php if ($img_2x_src) { echo $img_2x_src . ' 2x, '; } echo $img_src .' 1x';  ?>" alt="<?php echo $alt; ?>" />
							</picture>
						</a>
					</div>
				<?php } elseif ($featured == 'video') { 
					//$videourl = add_query_arg(array('title' => '0', 'byline' => '0', 'portrait' => '0'), $pubvideo); ?>
					<div class="entry-video">
						<?php echo $pubvideo; ?>
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
			  			<?php echo $pubsource; ?>, <span class="date"><?php echo $pubdate; ?></span>
			  		</footer>
		  		</div>
			</div>
		</article>
	<?php endwhile;
	wp_reset_postdata(); ?>
<?php endif; ?>
