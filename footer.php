			<footer class="footer" role="contentinfo">
				<div id="inner-footer" class="container section row">
					<nav role="navigation">
							<?php smashing_footer_links(); ?>
					</nav>
					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>
				</div>
			</footer>
		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>
	</body>
</html>
