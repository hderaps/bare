			<footer class="footer" role="contentinfo">
				<div id="inner-footer" class="container row">
					<nav role="navigation">
							<?php bare_footer_links(); ?>
					</nav>
					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>
				</div>
			</footer>
		</div>
		<?php // all js scripts are loaded in library/bare.php ?>
		<?php wp_footer(); ?>
	</body>
</html>
