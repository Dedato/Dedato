<article class="error row">
	<div class="col-md-6">
		<div class="entry-content">
			<h1><?php echo roots_title(); ?></h1>
			<div class="alert alert-warning">
				<?php _e('Sorry, but the page you were trying to view does not exist.', 'roots'); ?>
			</div>
			<p><?php _e('It looks like this was the result of either:', 'roots'); ?></p>
			<ul>
				<li><?php _e('a mistyped address', 'roots'); ?></li>
				<li><?php _e('an out-of-date link', 'roots'); ?></li>
			</ul>
			<?php get_search_form(); ?>
		</div>
	</div>	
</article>