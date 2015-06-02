<?php while (have_posts()) : the_post();
  if (get_field('page_image')) { ?>
    <article <?php post_class('row has-image'); ?>>
  <?php } else { ?>
    <article <?php post_class('row'); ?>>
  <?php } ?>
  	<div class="content col-md-6 ">
			<header>
				<h1><?php echo roots_title(); ?></h1>
			</header>
			<div class="entry-content">	
				<?php the_content(); ?>
			</div>
		</div>
		<?php if (get_field('page_image')):
  		$pageimage    = get_field('page_image');
			$alt 				  = $pageimage['alt'];
      $img_md_src   = $pageimage['sizes']['medium'];
			$img_lg_src 	= $pageimage['sizes']['page-large'];
			$img_xl_src 	= $pageimage['sizes']['page-x-large'];
			// Retina Images
  	  if (function_exists('wr2x_get_retina_from_url')) {
  			$img_md_2x_src 	= wr2x_get_retina_from_url($img_md_src);
  			$img_lg_2x_src 	= wr2x_get_retina_from_url($img_lg_src);
  			$img_xl_2x_src 	= wr2x_get_retina_from_url($img_xl_src);
  		} ?>
			<div class="entry-image col-md-6">	
				<picture>
					<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="<?php if ($img_xl_2x_src) { echo $img_xl_2x_src . ' 2x, '; } echo $img_xl_src .' 1x';  ?>" media="(min-width:1906px)">
          <source srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x';  ?>" media="(min-width:1205px)">
					<source srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x';  ?>" media="(min-width:992px)">
					<source srcset="<?php if ($img_xl_2x_src) { echo $img_xl_2x_src . ' 2x, '; } echo $img_xl_src .' 1x';  ?>" media="(min-width:806px)">
					<source srcset="<?php if ($img_lg_2x_src) { echo $img_lg_2x_src . ' 2x, '; } echo $img_lg_src .' 1x';  ?>" media="(min-width:526px)">
					<source srcset="<?php if ($img_md_2x_src) { echo $img_md_2x_src . ' 2x, '; } echo $img_md_src .' 1x';  ?>">
					<!--[if IE 9]></video><![endif]-->
					<img srcset="<?php echo $img_lg_src; ?>" alt="<?php echo $alt; ?>" />
				</picture>
			</div>
    <?php endif; ?>
	</article>	
<?php endwhile; ?>
