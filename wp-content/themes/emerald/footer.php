			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap clearfix">

					<nav role="navigation">
							<?php emerald_footer_links(); ?>
									</nav>

					<p class="source-org copyright"><?php global $themename; echo get_option($themename.'_footer_text'); ?></p>
					
					<p class="theme-credits">
						<?php emerald_credit_links(get_option($themename.'_hide_credits')); ?>
					</p>

				</div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->

		</div> <!-- end #container -->
		
		<!-- all js scripts are loaded in library/emerald.php -->
		<?php wp_footer(); ?>

	</body>

</html> <!-- end page. what a ride! -->
