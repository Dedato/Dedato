<?php
global $paged;
if(empty($paged)) $paged = 1;
$resultspp 	= get_query_var('posts_per_page');
$counter 	= 1;
?>

<article class="searchresults row">
	<div class="col-md-12">
		<div class="entry-content">
			<h1><?php searchresults_title_highlight(); ?></h1>
			<?php if (have_posts()) { ?>
				<div class="list">
					<?php while (have_posts()) : the_post();
						// Numbered Searchresults
						if($paged == 1) {
							$count = $counter;
						} else {
							$count = $counter + ($paged * $resultspp - $resultspp);
						} ?>
						<article <?php post_class(); ?>>
						  <header>
						    <h2 class="entry-title">
							    <span class="searchnr"><?php echo $count; ?>.</span><a href="<?php the_permalink(); ?>"><?php search_title_highlight(); ?></a>
						    </h2>
						  </header>
						  <div class="entry-summary">
						    <?php search_excerpt_highlight(); ?>
						  </div>
						</article>
						<?php $counter++;
					endwhile; ?>
				</div>	
			<?php } else { ?>
				<div class="alert alert-warning">
			    <?php _e('Sorry, no results were found.', 'roots'); ?>
			  </div>
			  <?php get_search_form();
			} ?>

			<?php /* Navigation */
			if ($wp_query->max_num_pages > 1) : ?>
				<nav class="post-nav">
					<ul class="pager">
						<li class="next"><?php next_posts_link(__('<i class="icon-chevron-right"></i>', 'dedato')); ?></li>
						<li class="previous"><?php previous_posts_link(__('<i class="icon-chevron-left"></i>', 'dedato')); ?></li>
					</ul>
				</nav>
			<?php endif;
			wp_reset_query(); ?>
		</div>
	</div>
</article>			
