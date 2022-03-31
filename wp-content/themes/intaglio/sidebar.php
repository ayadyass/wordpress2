		<div id="sidebar">
			<div id="rss">
				<a href="http://www.feedburner.com/fb/a/emailverifySubmit?feedId=<?php feedburner();?>" target="_blank">Subscribe to our RSS!</a>
			</div>
			<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :?>			
				<li>
				<h3 class="widget_title">Categories</h3>
				<div class="widget_content">
					<ul>
					<?php
					wp_list_categories('title_li=');
					?>
					</ul>
				</div>
				<div class="widget_footer"></div>
				</li>
				
				<li>
				<div id="twitter">
				<ul id="twitter_update_list"><li></li></ul>
				<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>  
				<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $intaglio->option['twitter']; ?>.json?callback=twitterCallback2&amp;count=1"></script>  
				</div>
				</li>
				
				<li>
				<div id="flickr">
				<h3>Gallery</h3>
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=6&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $intaglio->option['flickr']; ?>"></script>
				<div id="gallery_footer"></div>
				</div>
				</li>
<?php endif; ?>

			</ul>
		</div>
		<div class="clear"></div>
	</div>