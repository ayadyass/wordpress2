<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--[if lte IE 7]><style media="screen,projection" type="text/css">@import "<?php bloginfo('stylesheet_directory'); ?>/style-ie.css";</style><![endif]-->
	<!--[if IE 6]>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/DD_belatedPNG_0.0.7a-min.js"></script>
		<script type="text/javascript">
		  DD_belatedPNG.fix('#sidebar_search_val, #board, .body_top');
		</script>
	<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
</head>

<body <?php if(is_home()) : ?>id="indexpage"<?php endif; ?>>
<div id="page">

<div id="header">
	<div id="logo">
		<a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
	</div>
	<div id="sidebar_search">
		<form method="get" action="<?php bloginfo('url'); ?>/">
			<div>
				<input type="text" value="Type your search here..." name="s" id="sidebar_search_val" onclick="this.value='';" />
				<input type="image" src="<?php bloginfo('template_url')?>/images/button_go.gif" id="sidebar_search_sub" />
			</div>
		</form>
	</div>
</div>
<div id="board">
	<div id="twitter">
		<?php $twitter_id = obwp_get_meta(SHORTNAME.'_twitter_id'); ?>
		<h2><a href="http://www.twitter.com/<?php echo $twitter_id; ?>">Recent twitter entries...</a></h2>
		<ul id="twitter_update_list"><li>&nbsp;</li></ul>
	</div>
	<div id="twitter_link"><a href="http://www.twitter.com/<?php echo $twitter_id; ?>">follow me on <span>twitter</span></a></div>
	<div id="rss_link"><a href="<?php bloginfo('rss2_url'); ?>">subscribe to <span>rss</span> feed</a></div>
</div>
<div class="body">
	<div class="body_top">