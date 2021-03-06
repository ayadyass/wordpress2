=== Gallery2 Image Block ===
Contributors: mattrude
Author URI: http://mattrude.com/
Plugin URI: http://mattrude.com/projects/wp-gallery2-image-block/
Donate link: http://mattrude.com/donate/
Tags: Gallery2, images, image block, plugin, widget
Requires at least: 2.8
Tested up to: 3.3
Stable tag: 0.6.4
	
Widget to display your Gallery 2 Image Block on your WordPress sidebar

== Description ==

This plugin will allow you to put one of the meny [Gallery2](http://gallery.menalto.com/) Image Blocks on your WordPress site.  You are required to have a running Gallery2 install to use this plugin.
  
This is a complete rewrite of [Chris Schierer (aka Lentil)](http://www.theschierers.net/blog) [Gallery2 Image Block Plugin](http://wordpress.org/extend/plugins/gallery2-image-block-widget) 0.1.4.  This rewrite uses the new WordPress 2.8 Widget API, so is only compatable with wordpress 2.8+.
  
All options described in the [Gallery 2 Image Block](http://codex.gallery2.org/Gallery2:Modules:imageblock) documentation are included. User configuration of Image Block options are available in the Widget configuration panel.  Blank (empty) options use the Gallery2 defaults.  

As of version 0.5, wp-gallery2-image-block has full localization support, and ships with 5 languages besides English. Please contact me if you would like to translate it into more langages, I would love for as meny peaple as posible to be able to use this plugin.

= Fully Translated into: =
* Dutch (0.5.1)
* French
* English
* German
* Italian (0.6.1)
* Polish (0.6.1)
* Portuguese (0.5.1)
* Spanish
  
*Note:* This widget was written using [wp_http](http://planetozh.com/blog/2009/08/how-to-make-http-requests-with-wordpress/) to increase compatibility with more sites (version 0.6).
	
== Installation ==

Extract the zip file and just drop the contents in the `wp-content/plugins/` directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

You may ask questions or ask for support form the [Gallery2 Image Block Forums](http://mattrude.com/forums/forum/wp-gallery2-image-block).

= Q: Will this plugin work without Gallery2? =
A: Sorry No, [Gallery2](http://gallery.menalto.com/) is required.

= Q: Will I be able to add a random image to a page with this plugin? =
A: Sorry, this plugin will only work in the wiget sidebar.

= Q: Recived "SECURITY VIOLATION The action you attempted is not permitted" error on page load =
A: make sure the Gallery2 plugin "Image Block" is installed and active on your Gallery2 install. You should be able to see the random image by going to: `http://--gallery2url--/main.php?g2_view=imageblock.External` Where ???gallery2url??? is the value you put in the widget???s URL field. You should
see the random image with the default options.

== Changelog ==

= Version 0.6.4 =
* Tested with WordPress 3.3 - no code changes

= Version 0.6.3 =
* Tested with WordPress 2.9 - no code changes

= Version 0.6.2 =
* Tested with WordPress 2.8.6 - no code changes

= Version 0.6.1 =
* Tested with WordPress 2.8.5 - no code changes
* Added Italian Translation
* Added Polish Translation

= Version: 0.6 =
* Switched from using [lib_curl()](http://www.php.net/curl) to [wp_http](http://planetozh.com/blog/2009/08/how-to-make-http-requests-with-wordpress/)

= Version: 0.5.2 =
* Tested with wordpress 2.8.3 & 2.8.4 - no code change
* Corrected URL's
* Updated README

= Version: 0.5.1 =
* Tested with WordPress 2.8.2 - no code changes
* Updated POT file do to typo
* Added Dutch translation
* Added Portuguese translation

= Version: 0.5 =
* Added full localization support
* Added French translation
* Added Spanish translation

= Version: 0.4 =
* Corrcted typo in $gallery_linktarget 

= Version: 0.3 =
* Corrected missing Header text tag

= Version: 0.1 =
* Initial Release

== Screenshots ==

1. Dashboard Wiget Screen
2. Shown on main page
