<?php while (have_posts()) : the_post(); 
	$clientimage 	= get_field('client_image');
	$clientwebsite = get_field('client_website');
	// Sizes
	$img_md_src 	= $clientimage['sizes']['medium'];
  $img_md_w     = $clientimage['sizes']['medium-width'];
  $img_md_h     = $clientimage['sizes']['medium-height'];
	$img_lg_src 	= $clientimage['sizes']['large'];
  $img_xl_src 	= $clientimage['sizes']['x-large'];
	$img_xxl_src 	= $clientimage['sizes']['xx-large'];
	$alt 		      = $clientimage['alt'];
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
	<article <?php post_class(); ?>>
		<div class="entry-content">
			<div class="entry-image <?php echo $orientation; ?>" style="padding-bottom:<?php echo $ratio; ?>%;">			
				<picture class="stretch">
					<!--[if IE 9]><video style="display: none;"><![endif]-->
          <source srcset="<?php if ($img_xxl_2x_src) { echo $img_xxl_2x_src . ' 2x, '; } echo $img_xxl_src .' 1x';  ?>" media="(min-width:1700px)">
          <source srcset="<?php if ($img_xl_2x_src) { echo $img_xl_2x_src . ' 2x, '; } echo $img_xl_src .' 1x';  ?>" media="(min-width:1280px)">
					<source srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x'; ?>" media="(min-width:510px)">
					<source srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x';  ?>">
					<!--[if IE 9]></video><![endif]-->
					<img srcset="<?php echo $img_lg_src; ?>" alt="<?php echo $alt; ?>" />
				</picture>
			</div>
  		<div class="entry-details">
  			<h2 class="entry-title"><?php the_title(); ?></h2>
  			<div class="entry-summary">
  				<?php the_content(); ?>
  			</div>	
  			<footer class="entry-footer">
  				<?php if($clientwebsite){ ?>
  					<a class="website" href="<?php echo $clientwebsite['url']; ?>" target="_blank"><?php echo preg_replace('#^https?://#', '', $clientwebsite['url']); ?></a>
  				<?php } ?>
	  		</footer>
  		</div>
  	</div>	
	</article>
<?php endwhile; ?>