	<div id="sidebar">
		<div id="sidebar_left" class="sidebar_widgets">
			<ul>
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ){
				?>
				<?
				} else { ?>	
				
				<li class="widget_pages">
					<h2 class="widgettitle">Pages</h2>
					<ul>
						<?php wp_list_pages('title_li=' ); ?>
					</ul>
				</li>	
				
				<li class="widget_categories">
					<h2 class="widgettitle">Category</h2>
					<ul>
						<?php wp_list_cats('sort_column=name&optioncount=1'); ?>
					</ul>
				</li>	
				
				<li class="widget_recent_entries">
					<h2 class="widgettitle">recent posts</h2>
					<?php obwp_list_recent_posts(5); ?>
				</li>
				
			<?php } ?>
			</ul>
		</div>
		<div id="sidebar_right" class="sidebar_widgets">
			<div id="sidebar_ads">
				<div id="sidebar_ads_body"><?php theme_ads_show() ?></div>
			</div>
			<ul>
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ){
				?>
				<?
				} else { ?>		
	
				<li class="widget_archives">
					<h2 class="widgettitle">Archives</h2>
					<ul>
					<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</li>
	
				<li class="widget_links">
					<h2 class="widgettitle">Partner Links</h2>
					<ul>
					<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
					</ul>
				</li>
				
			<?php } ?>
			</ul>
		</div>
	</div>

