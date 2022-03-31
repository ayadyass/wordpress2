<?
/**
 * @package WordPress
 * @subpackage magazine_obsession
 */

/**
 * Show the General Settings for Admin oanel
 *
 * @since 2.7.0
 *
 */
function obwp_general_settings()
{
    global $themename, $options;

	$options = array (
				array(	"name" => "General Settings",
						"type" => "heading"),
						
				array(	"name" => "Twitter ID",
						"desc" => "Enter twitter id.<br /><br />",
			    		"id" => SHORTNAME."_twitter_id",
			    		"std" => "",
			    		"type" => "text"),
						
				array(	"name" => "Google Adsense ID",
						"desc" => "Enter google adnsense id. Example: pub-################. Enter pub- too.<br /><br />",
			    		"id" => SHORTNAME."_google_id",
			    		"std" => "",
			    		"type" => "text"),
						
				array(	"name" => "Count of 125x125 banners",
						"desc" => "Enter count of 125x125 banner blocks.<br /><br />",
			    		"id" => SHORTNAME."_count_banner_125_125",
			    		"std" => "",
			    		"type" => "text")
																														
		  );
	
	obwp_add_admin('obwp-settings.php');
}



?>