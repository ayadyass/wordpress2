<?php
if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '<li>',
'after_widget' => '</div><div class="widget_footer"></div></li>',
'before_title' => '<h3 class="widget_title">',
'after_title' => '</h3><div class="widget_content">',
));

include(dirname(__FILE__).'/options.php');

themetoolkit(
	'intaglio', 
	array( 

	'feed' => 'Feedburner ID ## Enter your Feedburner ID here. ',
	'flickr' => 'Flickr Account ## 	Enter the ID of your Flickr account here <br />(e.g http://flickr.com/photos/<b>27353671@N02</b>/). ',
	'featured' => 'Featured Category ## Enter the featured category ID',
	'twitter' => 'Twitter Username ## 	Enter your twitter username here. ',

	),
	__FILE__
);
	
function feedburner() {
	global $intaglio;
	print $intaglio->option['feed'];
}

function widget_intaglio_twitter() {
	global $intaglio;
?>
		<li>
		<div id="twitter">
		<ul id="twitter_update_list"><li></li></ul>
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>  
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $intaglio->option['twitter']; ?>.json?callback=twitterCallback2&amp;count=1"></script>  
		</div>
		</li>

<?php
}
if ( function_exists('register_sidebar_widget') ) {
    register_sidebar_widget(__('Twitter'), 'widget_intaglio_twitter');
}

function widget_intaglio_gallery() {
	global $intaglio;
?>
		<li>
		<div id="flickr">
		<h3>Gallery</h3>
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=10&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $intaglio->option['flickr']; ?>"></script>
		<div id="gallery_footer"></div>
		</div>
		</li>
<?php
}
if ( function_exists('register_sidebar_widget') ) {
    register_sidebar_widget(__('Flickr'), 'widget_intaglio_gallery');
}
?>