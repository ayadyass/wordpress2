<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<!-- Google Chrome Frame for IE -->
		<?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) header('X-UA-Compatible: IE=edge,chrome=1'); ?>

		<title><?php wp_title( '|', true, 'right' ); ?></title>
		
		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<?php global $themename; $themename = 'emerald'; ?>

		<!-- icons & favicons -->
		<link rel="icon" href="<?php echo get_option($themename.'_favicon');?>">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_option($themename.'_favicon');?>">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<style>
		<?php echo get_option($themename.'_custom_css'); ?>
		</style>
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->
	</head>

	<body <?php body_class(get_option($themename.'_color_scheme').'-skin'); ?>>

<div class="social_wrap">
    <div class="social">
        <ul>
        <?php if(get_option($themename.'_fb_url')): ?><li class="soc_fb"><a href="<?php echo get_option($themename.'_fb_url');?>" target="_blank" title="Facebook">Facebook</a></li><?php endif; ?>
        <?php if(get_option($themename.'_twitter_url')): ?><li class="soc_tw"><a href="<?php echo get_option($themename.'_twitter_url');?>" target="_blank" title="Twitter">Twitter</a></li><?php endif; ?>
        <?php if(get_option($themename.'_google_plus_url')): ?><li class="soc_plus"><a href="<?php echo get_option($themename.'_google_plus_url');?>" target="_blank" title="Google Plus">Google Plus</a></li><?php endif; ?>
        <?php if(get_option($themename.'_feedburner')): ?><li class="soc_rss"><a href="<?php echo get_option($themename.'_feedburner');?>" target="_blank" title="RSS">RSS</a></li><?php endif; ?>
        </ul>
    </div>
</div>

		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="clearfix">

					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<p style="display:none;" id="logo" class="h1 wrap"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>
					<?php if(get_option($themename.'_logo')): ?>
					<a href="<?php echo home_url(); ?>"><img src="<?php echo get_option($themename.'_logo'); ?>" alt="<?php bloginfo('name'); ?>" id="logo" /></a>
					<?php else: ?>
					<h1 id="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
					<?php endif; ?>
					<div class="header-section-right"><?php get_search_form( true ); ?><?php echo emerald_header_dropdown_nav(); ?></div>
				</div> <!-- end #inner-header -->
					<!-- if you'd like to use the site description you can un-comment it below -->
					<?php // bloginfo('description'); ?>
					<nav role="navigation">
						<?php emerald_main_nav(); ?> 
					</nav>

			</header> <!-- end header -->