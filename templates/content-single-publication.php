<?php while (have_posts()) : the_post(); 
	// Date
	$unixdate 	= strtotime(get_field('publication_date'));
	$pubdate		= date_i18n('d F Y', $unixdate);
	$pubsource	= get_field('publication_source');
	$pubfile 	= get_field('publication_file');
	// Image / Video
	$featured 		= get_field('publication_feature');
	if ($featured == 'image') $pubimage = get_field('publication_image');
	if ($featured == 'video') $pubvideo = get_field('publication_video');
	// File / URL
	$publink 		= get_field('publication_link');
	if ($publink == 'file') $pubfile = get_field('publication_file');
	if ($publink == 'url') $puburl = get_field('publication_url');
	?>
	<article <?php post_class(); ?>>
		<div class="entry-content">
			<?php
  		// Single Image
  		if ($featured == 'image') {
				// Sizes
				$img_md_src 	= $pubimage['sizes']['medium'];
				$img_md_w     = $pubimage['sizes']['medium-width'];
        $img_md_h     = $pubimage['sizes']['medium-height'];
				$img_lg_src 	= $pubimage['sizes']['large'];
				$img_xl_src 	= $pubimage['sizes']['x-large'];
				$img_xxl_src 	= $pubimage['sizes']['xx-large'];
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
				<div class="entry-image <?php echo $orientation; ?>" style="padding-bottom:<?php echo $ratio; ?>%;">	
					<picture class="stretch">
						<!--[if IE 9]><video style="display: none;"><![endif]-->
						<source srcset="<?php if ($img_xxl_2x_src) { echo $img_xxl_2x_src . ' 2x, '; } echo $img_xxl_src .' 1x';  ?>" media="(min-width:1700px)">
            <source srcset="<?php if ($img_xl_2x_src) { echo $img_xl_2x_src . ' 2x, '; } echo $img_xl_src .' 1x';  ?>" media="(min-width:1280px)">
						<source srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x';  ?>" media="(min-width:510px)">
						<source srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x';  ?>">
						<!--[if IE 9]></video><![endif]-->
						<img srcset="<?php echo $img_lg_src; ?>" alt="<?php echo $alt; ?>" />
					</picture>
				</div>
			<?php
      // Video 
  		} elseif ($featured == 'video') {
				//$videourl = add_query_arg(array('title' => '0', 'byline' => '0', 'portrait' => '0'), $pubvideo); ?>
				<div class="entry-video">
					<?php echo $pubvideo; ?>
				</div>
			<?php } ?>
  		<div class="entry-details">
  			<header class="entry-header row">
  				<h2 class="entry-title col-xs-6"><?php the_title(); ?></h2>
  				<div class="source col-xs-6">
	  				<?php if ($pubsource) {
	  					echo $pubsource . ',';
	  				} ?>
	  				<span class="date"><?php echo $pubdate; ?></span>
  				</div>
  			</header>
  			<div class="entry-content">
  				<?php the_content(); ?>
  			</div>	
  			<footer class="entry-footer">
  				<?php if ($pubfile || $puburl) {
  					// File
  					if ($publink == 'file') {
	  					$linktitle 	= $pubfile['title'];
	  					$linkurl 	= $pubfile['url'];
	  					if ($pubfile['mime_type'] != 'application/pdf') {
		  					$rel = 'lightbox';
		  				}
		  			// URL	
  					} elseif ($publink == 'url') {
	  					$linktitle 	= $puburl['title'];
	  					$linkurl 	= $puburl['url'];
  					} ?>
		  			<a class="btn btn-sm btn-primary" rel="<?php echo $rel; ?>" title="<?php echo $linktitle; ?>" href="<?php echo $linkurl; ?>" target="_blank">
		  			<i class="icon-book"></i><?php _e('Read the original article','dedato'); ?></a>
		  		<?php } ?> 	
	  		</footer>
  		</div>
  	</div>	
	</article>
<?php endwhile; ?>