<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script.js"></script>
<?php wp_head(); ?>
</head>
<body>
<div class="PageBackgroundGradient"></div>
<div class="Main">

<div class="Sheet">
  <div class="Sheet-body">
<div class="Header">
  <div>
<table class="logo">
<tr><td class="logo-name"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></td></tr>
<tr><td class="logo-text"><?php bloginfo('description'); ?></td></tr>
</table>

  </div>
</div>
<div class="nav">
<ul class="menu">
<?php art_menu_items(true); ?>
</ul>
<div class="l"></div><div class="r"><div></div></div></div>