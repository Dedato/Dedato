<footer class="content-info" role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-push-2">
				<?php dynamic_sidebar('sidebar-footer'); ?>
				<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
			</div>
		</div>
	</div>	
</footer>
<?php wp_footer(); ?>