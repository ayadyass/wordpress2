		<!-- Sidebar -->
		<div class="sidebar sidebar-left">
		
			<h3>RSS Feed</h3>
			<div id="sidebar-feed">
				<a href="<?php bloginfo('rss_url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/rss_feed.jpg" alt="RSS Feed" width="160" height="60" /></a>
			</div>
			
			<h3>Search</h3>
<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
				<div>
					<input type="text" name="s" id="s" size="15" /><br />
					<input type="submit" value="Search" />
				</div>
			</form>
			
			<h3>Blog Roll</h3>
			<ul>
				<?php wp_list_bookmarks('categorize=0&title_li='); ?>
			</ul>
			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
			
			<?php endif; ?>
		
		</div>
		<!-- Sidebar -->