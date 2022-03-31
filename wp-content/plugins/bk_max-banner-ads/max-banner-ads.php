<?php
/* 
 * Plugin Name:   Max Banner Ads
 * Version:       1.4
 * Plugin URI:    http://www.maxblogpress.com/plugins/mba/
 * Description:   Easily rotate banners and ads in almost anywhere in your wordpress blog without editing the theme. Adjust your settings <a href="edit.php?page=max-banner-ads/max-banner-ads.php">here</a>.
 * Author:        MaxBlogPress
 * Author URI:    http://www.maxblogpress.com
 *
 * License: Copyright (c) 2008 Pawan Agrawal. All rights reserved.
 * 
 * This plugin uses a commercial script library.
 * 
 * Please refer to "license.txt" file located at "max-banner-ads-lib/"
 * for copyright notice and end user license agreement.
 * 
 */
 
$mban_path     = preg_replace('/^.*wp-content[\\\\\/]plugins[\\\\\/]/', '', __FILE__);
$mban_path     = str_replace('\\','/',$mban_path);
$mban_dir      = substr($mban_path,0,strrpos($mban_path,'/'));
$mban_siteurl  = get_bloginfo('wpurl');
$mban_siteurl  = (strpos($mban_siteurl,'http://') === false) ? get_bloginfo('siteurl') : $mban_siteurl;
$mban_fullpath = $mban_siteurl.'/wp-content/plugins/'.$mban_dir.'/';
$mban_relpath  = str_replace('\\','/',dirname(__FILE__));
$mban_libpath  = $mban_fullpath.'max-banner-ads-lib/';
$mban_abspath  = str_replace("\\","/",ABSPATH); 
define('MBAN_ABSPATH', $mban_abspath);
define('MBAN_PATH', $mban_path);
define('MBAN_FULLPATH', $mban_fullpath);
define('MBAN_LIBPATH', $mban_libpath);
define('MBAN_SITEURL', $mban_siteurl);
define('MBAN_NAME', 'Max Banner Ads');
define('MBAN_VERSION', '1.4');
require_once($mban_relpath.'/max-banner-ads-lib/include/max-banner-ads.cls.php');

/**
 * MBPBannerAdsPlugin - Max Banner Ads
 * Holds all the necessary functions and variables
 */
class MBPBannerAdsPlugin extends MBPBannerAds
{
	/**
	 * Constructor. Adds the plugins plugin actions/filters and gets the user defined options.
	 */
	function MBPBannerAdsPlugin() {
		global $table_prefix, $wp_version;
		$this->mban_zone_table    = $table_prefix.$this->mban_zone_table;
		$this->mban_banner_table  = $table_prefix.$this->mban_banner_table;
		$this->mban_options_table = $table_prefix.$this->mban_options_table;
		
		$this->wp_version   = $wp_version;
		$this->usedbanners  = array();
		$this->img_how      = '<img src="'.MBAN_LIBPATH.'images/how.gif" border="0" align="absmiddle">';
		$this->img_comment  = '<img src="'.MBAN_LIBPATH.'images/comment.gif" border="0" align="absmiddle">';
		$this->img_remove   = '<img src="'.MBAN_LIBPATH.'images/remove.gif" border="0" align="absmiddle">';
		$this->img_home     = '<img src="'.MBAN_LIBPATH.'images/home.gif" border="0" align="absmiddle">';
		$this->img_add      = '<img src="'.MBAN_LIBPATH.'images/add.gif" border="0" align="absmiddle">';
		$this->img_add2     = '<img src="'.MBAN_LIBPATH.'images/add2.gif" border="0" align="absmiddle">';
		$this->img_edit     = '<img src="'.MBAN_LIBPATH.'images/edit.gif" border="0" align="absmiddle">';
		$this->img_delete   = '<img src="'.MBAN_LIBPATH.'images/delete.gif" border="0" align="absmiddle">';
		$this->img_reset    = '<img src="'.MBAN_LIBPATH.'images/reset.gif" border="0" align="absmiddle">';
		$this->img_child    = '<img src="'.MBAN_LIBPATH.'images/sub.gif" border="0" align="absmiddle">';
		$this->img_tag      = '<img src="'.MBAN_LIBPATH.'images/tag.gif" border="0" align="absmiddle" title="Template/Post Tags">';
		$this->img_warning  = '<img src="'.MBAN_LIBPATH.'images/warning.gif" border="0" align="absmiddle">';
		$this->img_active   = '<img src="'.MBAN_LIBPATH.'images/active.gif" border="0" align="absmiddle" title="Active (Click to make Inactive)">';
		$this->img_inactive = '<img src="'.MBAN_LIBPATH.'images/inactive.gif" border="0" align="absmiddle" title="Inactive (Click to make Active)">';

		add_action('activate_'.MBAN_PATH, array(&$this, 'mbanActivate'));
		add_action('init', array(&$this, 'mbanInit'));
		add_action('admin_head', array(&$this, 'mbanStyleAndJS'));
		add_action('admin_menu', array(&$this, 'mbanAddMenu'));
		add_action('after_plugin_row', array(&$this, 'mbanCheckPluginVersion'));

		$this->mban_activate = get_option('mban_activate');
		if ( $this->mban_activate == 3 ) {
			add_action('loop_start', array(&$this, 'mbanInsertBannerInTFP'));
			add_action('loop_end', array(&$this, 'mbanInsertBannerInBLP'));
			add_filter('the_content', array(&$this, 'mbanInsertBannerWithinPost'));
			add_filter('the_excerpt', array(&$this, 'mbanWithinPostExcerpt'));
		}
	}
	
	/**
	 * Called when plugin is activated. Adds the plugins options to the options table.
	 */
	function mbanActivate() {
		$ret1 = $this->__mbanCreateZoneTable();
		$ret2 = $this->__naffCreateBannerTable();
		$ret3 = $this->__mbanCreateOptionsTable();
		if ( $ret1 == true && $ret3 == true ) $this->__mbanAddDefaultData();
		if ( $ret1 == false || $ret2 == false ) $this->__mbanAlterTables(DB_NAME);
		update_option('mban_version', MBAN_VERSION);
		return true;
	}
	
	/**
	 * Plugin's stylesheet and javascripts
	 */
	function mbanStyleAndJS() {
		$this->__mbanStyleAndJS();
	}
	
	/**
	 * Plugin Initialization
	 */
	function mbanInit() {
		$this->mban_init = 1;
	}
	
	/**
	 * Adds the plugins link in admin's Manage menu
	 */
	function mbanAddMenu() {
		add_management_page(MBAN_NAME, 'Max Banner Ads', 9, MBAN_PATH, array(&$this, 'mbanOptionsPg'));
	}
	
	/**
	 * Gets recheck data fro displaying auto upgrade information
	 */
	function mbanRecheckData($data='') {
		if ( $data != '' ) {
			update_option('mban_version_check',$data);
		} else {
			$version_chk = get_option('mban_version_check');
			return $version_chk;
		}
	}
	
	/**
	 * Extracts plugin update data
	 */
	function mbanExtractUpdateData() {
		$arr = array();
		$version_chk_file = "http://www.maxblogpress.com/plugin-updates/max-banner-ads.php?v=".MBAN_VERSION;
		$content = wp_remote_fopen($version_chk_file);
		if ( $content ) {
			$content          = nl2br($content);
			$content_arr      = explode('<br />', $content);
			$latest_version   = trim(trim(strstr($content_arr[0],'~'),'~'));
			$recheck_interval = trim(trim(strstr($content_arr[1],'~'),'~'));
			$download_url     = trim(trim(strstr($content_arr[2],'~'),'~'));
			$msg_plugin_mgmt  = trim(trim(strstr($content_arr[3],'~'),'~'));
			$msg_in_plugin    = trim(trim(strstr($content_arr[4],'~'),'~'));
			$upgrade_url      = MBAN_SITEURL.'/wp-admin/edit.php?page='.MBAN_PATH.'&action=upgrade&dnl='.$download_url;
			$arr = array($latest_version, $recheck_interval, $download_url, $msg_plugin_mgmt, $msg_in_plugin, $upgrade_url);
		}
		return $arr;
	}
		
	/**
	 * Checks the plugin version and displays the message if new version is available
	 */
	function mbanCheckPluginVersion($plugin) {
		$update_arr = array();
		if ( strpos(MBAN_PATH,$plugin) !== false ) {	
			// Check for last checked date and access version info data only if recheck interval has reached
			$mban_version_chk = $this->mbanRecheckData();
			if ( ($mban_version_chk == '') || strtotime(date('Y-m-d H:i:s')) > (strtotime($mban_version_chk['last_checked_on']) + $mban_version_chk['recheck_interval']*60*60) ) {
				$update_arr = $this->mbanExtractUpdateData();
				if ( count($update_arr) > 0 ) {
					$latest_version   = $update_arr[0];
					$recheck_interval = $update_arr[1];
					$download_url     = $update_arr[2];
					$msg_plugin_mgmt  = $update_arr[3];
					$msg_in_plugin    = $update_arr[4];
					$upgrade_url      = $update_arr[5];
					if( MBAN_VERSION < $latest_version ) {
						$mban_version_check = array('recheck_interval' => $recheck_interval, 'last_checked_on' => date('Y-m-d H:i:s'));
						$this->mbanRecheckData($mban_version_check);
						$msg_plugin_mgmt = str_replace("%latest-version%", $latest_version, $msg_plugin_mgmt);
						$msg_plugin_mgmt = str_replace("%plugin-name%", MBAN_NAME, $msg_plugin_mgmt);
						$msg_plugin_mgmt = str_replace("%upgrade-url%", $upgrade_url, $msg_plugin_mgmt);
						echo '<td colspan="5" class="plugin-update" style="line-height:2.5em;">'.$msg_plugin_mgmt.'</td>';
					} else {
						$msg_plugin_mgmt = '';
					}
				}
			}
		}
	}
	
	/**

	 * Checks the page type
	 */
	function mbanCheckPageType() {
		$show_in = '';
		if ( is_home() ) $show_in = 'hom';
		if ( is_single() || is_page() ) $show_in = 'sin';
		if ( is_search() ) $show_in = 'sea';
		if ( is_archive() ) {
			if ( is_category() )  $show_in = 'cat';
			else if ( !is_tag() ) $show_in = 'arc';
		}
		return $show_in;
	}
	
	/**
	 * Displays banners in top of the first post
	 */
	function mbanInsertBannerInTFP() {
		if ( !is_admin() && !is_feed() && $this->mban_init ) {
			$banner_output = '';
			$banner_output = $this->__mbanInsertBanner('tfp');
			if ( strlen($banner_output) > 5 && (strpos($banner_output, base64_decode("UG93ZXJlZA==")) !== false) ) {
				echo $banner_output;
			}
		}
	}
	
	/**
	 * Displays banners in bottom of the last post
	 */
	function mbanInsertBannerInBLP() {
		if ( !is_admin() && !is_feed() && $this->mban_init ) {
			$banner_output = '';
			$banner_output = $this->__mbanInsertBanner('blp');
			if ( strlen($banner_output) > 5 && (strpos($banner_output, base64_decode("UG93ZXJlZA==")) !== false) ) {
				echo $banner_output;
			}
		}
	}
	
	/**
	 * Displays banners within the post excerpt
	 */
	function mbanWithinPostExcerpt($post_excerpt) {
		if ( strpos($post_excerpt,'Powered by Max Banner Ads') !== false ) {
			$post_excerpt = str_replace('&nbsp;Powered by Max Banner Ads&nbsp;','',$post_excerpt);
			$post_excerpt = str_replace('Powered by Max Banner Ads','',$post_excerpt);
		}
		return $post_excerpt;
	}
	
	/**
	 * Displays banners within the post
	 */
	function mbanInsertBannerWithinPost($post_content) { 
		global $post, $paged, $posts_per_page;
		$this->post_number++;
		$post_content_orig = $post_content;
		$curr_pg = intval($paged) > 0 ? ($paged-1) : 0;
		$page_start_no = $curr_pg * $posts_per_page + 1;
		$post_number   = $page_start_no + ($this->post_number - 1);
		// One time fetch
		if ( trim($this->within_posts) == '' ) {
			$sql = "SELECT wp_show_in FROM $this->mban_zone_table WHERE within_post='1'";
			$rs = @mysql_query($sql);
			while ( $row = @mysql_fetch_assoc($rs) ) {
				$this->within_posts .= ','.$row['wp_show_in'].',';
			}
		}
		// Execute banner query only for required posts
		if ( strpos($this->within_posts,','.$post_number.',') !== false || strpos($this->within_posts,'all') !== false ) {
			$post_content = $this->__mbanInsertBanner('wp','',$post_content,$post_number);
		}
		if ( $this->options_global['disable_all_banners'] != 1 ) {
			$post_content = $this->__mbanSearchPostTag($post_content,'zone'); // Check for zone tag
			$post_content = $this->__mbanSearchPostTag($post_content,'banner'); // Check for banner tag
			return $post_content;
		} else {
			return $post_content_orig;
		}
	}
	
	/**
	 * Counts Impression for each banner appearing on a page
	 */
	function mbanCountImpression() {
		if ( !is_admin() && !is_feed() && !is_user_logged_in() ) {
			$this->__mbanCountImpression();
		}
	}
	
	/**
	 * Displays the plugins options
	 */
	function mbanOptionsPg() {
		$reg_msg = '';
		$mban_msg = '';
		
		$form_1 = 'mban_reg_form_1';
		$form_2 = 'mban_reg_form_2';
		
		// Activate the plugin if email already on list
		if ( trim($_GET['mbp_onlist']) == 1 ) {
			$this->mban_activate = 3;
			update_option('mban_activate', $this->mban_activate);
			$reg_msg = 'Thank you for registering the plugin. It has been activated'; 
			echo "<img src='http://www.maxblogpress.com/sta5/TY_via_ip.php?id=LVCigkdp7CE%3D&outcome=3&sta_amt=0' width='0' height='0'>";
		} 
		
		// If registration form is successfully submitted
		if ( ((trim($_GET['submit']) != '' && trim($_GET['Contact0Email']) != '') || trim($_GET['submit_again']) != '') && $this->mban_activate != 3 ) { 
			update_option('mban_name', $_GET['Contact0FirstName']);
			update_option('mban_email', $_GET['Contact0Email']);
			$this->mban_activate = 1;
			update_option('mban_activate', $this->mban_activate);
		}
		
		
		if ( intval($this->mban_activate) == 0 ) { // First step of plugin registration
			global $userdata;
			$this->__mbanRegisterStep1($form_1,$userdata);
			$this->__mbaPluginInstallTest(); // Install and land on registration page test
		} else if ( intval($this->mban_activate) == 1 ) { // Second step of plugin registration
			$name  = get_option('mban_name');
			$email = get_option('mban_email');
			$this->__mbanRegisterStep2($form_2,$name,$email);
		} else if ( intval($this->mban_activate) == 3 ) { // Options page
			$mban_msg = $this->__mbanOptionsPg();
			if ( trim($mban_msg) != '' || trim($reg_msg) != '' ) {
				if ( trim($reg_msg) != '' ) $mban_msg = $reg_msg;
				echo '<div id="message" class="updated fade"><p><strong>'.$mban_msg.'</strong></p></div>';
			}
			echo '<div class="wrap">';
			$this->__mbanShowOptionsPg();
			echo '</div>';
		}
	}
	
	/**
	 * Interface for Adding/Editing Zone
	 */
	function mbanAddEditZone($msg='') {
		if ( trim($msg) != '' ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$msg.'</strong></p></div>';
		}
		echo '<div class="wrap">';
		$this->__mbanAddEditZone();
		echo '</div>';
	}
	
	/**
	 * Interface for Adding/Editing Banner
	 */
	function mbanAddEditBanner($msg='') {
		if ( trim($msg) != '' ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$msg.'</strong></p></div>';
		}
		echo '<div class="wrap">';
		$this->__mbanAddEditBanner();
		echo '</div>';
	}
	
	/**
	 * Interface for upgrading plugin
	 */
	function mbanUpgradePlugin() {
		global $wp_version;
		$plugin = MBAN_PATH;
		echo '<div class="wrap">';
		$this->__mbanHeader();
		echo '<h3>Upgrade Plugin &raquo;</h3>';
		if ( $wp_version >= 2.5 ) {
			$res = $this->mbanDoPluginUpgrade($plugin);
		} else {
			echo '&raquo; Wordpress 2.5 or higher required for automatic upgrade.<br><br>';
		}
		if ( $res == false ) echo '&raquo; Plugin couldn\'t be upgraded.<br><br>';
		echo '<br><strong><a href="'.MBAN_SITEURL.'/wp-admin/plugins.php">Go back to plugins page</a> | <a href="'.MBAN_SITEURL.'/wp-admin/edit.php?page='.MBAN_PATH.'">'.MBAN_NAME.' home page</a></strong>';
		$this->__mbanFooter();
		echo '</div>';
		include('admin-footer.php');
	}
	
	/**
	 * Carries out plugin upgrade
	 */
	function mbanDoPluginUpgrade($plugin) {
		set_time_limit(300);
		global $wp_filesystem;
		$debug = 0;
		$was_activated = is_plugin_active($plugin); // Check current status of the plugin to retain the same after the upgrade

		// Is a filesystem accessor setup?
		if ( ! $wp_filesystem || !is_object($wp_filesystem) ) {
			WP_Filesystem();
		}
		if ( ! is_object($wp_filesystem) ) {
			echo '&raquo; Could not access filesystem.<br /><br />';
			return false;
		}
		if ( $wp_filesystem->errors->get_error_code() ) {
			echo '&raquo; Filesystem error '.$wp_filesystem->errors.'<br /><br />';
			return false;
		}
		
		if ( $debug ) echo '> File System Okay.<br /><br />';
		
		// Get the URL to the zip file
		$package = $_GET['dnl'];
		if ( empty($package) ) {
			echo '&raquo; Upgrade package not available.<br /><br />';
			return false;
		}
		// Download the package
		$file = download_url($package);
		if ( is_wp_error($file) || $file == '' ) {
			echo '&raquo; Download failed. '.$file->get_error_message().'<br /><br />';
			return false;
		}
		$working_dir = MBAN_ABSPATH . 'wp-content/upgrade/' . basename($plugin, '.php');
		
		if ( $debug ) echo '> Working Directory = '.$working_dir.'<br /><br />';
		
		// Unzip package to working directory
		$result = $this->mbanUnzipFile($file, $working_dir);
		if ( is_wp_error($result) ) {
			unlink($file);
			$wp_filesystem->delete($working_dir, true);
			echo '&raquo; Couldn\'t unzip package to working directory. Make sure that "/wp-content/upgrade/" folder has write permission (CHMOD 755).<br /><br />';
			return $result;
		}
		
		if ( $debug ) echo '> Unzip package to working directory successful<br /><br />';
		
		// Once extracted, delete the package
		unlink($file);
		if ( is_plugin_active($plugin) ) {
			deactivate_plugins($plugin, true); //Deactivate the plugin silently, Prevent deactivation hooks from running.
		}
		
		// Remove the old version of the plugin
		$plugin_dir = dirname(MBAN_ABSPATH . PLUGINDIR . "/$plugin");
		$plugin_dir = trailingslashit($plugin_dir);
		// If plugin is in its own directory, recursively delete the directory.
		if ( strpos($plugin, '/') && $plugin_dir != $base . PLUGINDIR . '/' ) {
			$deleted = $wp_filesystem->delete($plugin_dir, true);
		} else {

			$deleted = $wp_filesystem->delete($base . PLUGINDIR . "/$plugin");
		}
		if ( !$deleted ) {
			$wp_filesystem->delete($working_dir, true);
			echo '&raquo; Could not remove the old plugin. Make sure that "/wp-content/plugins/" folder has write permission (CHMOD 755).<br /><br />';
			return false;
		}
		
		if ( $debug ) echo '> Old version of the plugin removed successfully.<br /><br />';

		// Copy new version of plugin into place
		if ( !$this->mbanCopyDir($working_dir, MBAN_ABSPATH . PLUGINDIR) ) {
			echo '&raquo; Installation failed. Make sure that "/wp-content/plugins/" folder has write permission (CHMOD 755)<br /><br />';
			return false;
		}
		//Get a list of the directories in the working directory before we delete it, we need to know the new folder for the plugin
		$filelist = array_keys( $wp_filesystem->dirlist($working_dir) );
		// Remove working directory
		$wp_filesystem->delete($working_dir, true);
		// if there is no files in the working dir
		if( empty($filelist) ) {
			echo '&raquo; Installation failed.<br /><br />';
			return false; 
		}
		$folder = $filelist[0];
		$plugin = get_plugins('/' . $folder);      // Pass it with a leading slash, search out the plugins in the folder, 
		$pluginfiles = array_keys($plugin);        // Assume the requested plugin is the first in the list
		$result = $folder . '/' . $pluginfiles[0]; // without a leading slash as WP requires
		
		if ( $debug ) echo '> Copy new version of plugin into place successfully.<br /><br />';
		
		if ( is_wp_error($result) ) {
			echo '&raquo; '.$result.'<br><br>';
			return false;
		} else {
			//Result is the new plugin file relative to PLUGINDIR
			echo '&raquo; Plugin upgraded successfully<br><br>';	
			if( $result && $was_activated ){
				echo '&raquo; Attempting reactivation of the plugin...<br><br>';	
				echo '<iframe style="display:none" src="' . wp_nonce_url('update.php?action=activate-plugin&plugin=' . $result, 'activate-plugin_' . $result) .'"></iframe>';
				sleep(15);
				echo '&raquo; Plugin reactivated successfully.<br><br>';	
			}
			return true;
		}
	}
	
	/**
	 * Copies directory from given source to destinaktion
	 */
	function mbanCopyDir($from, $to) {
		global $wp_filesystem;
		$dirlist = $wp_filesystem->dirlist($from);
		$from = trailingslashit($from);
		$to = trailingslashit($to);
		foreach ( (array) $dirlist as $filename => $fileinfo ) {
			if ( 'f' == $fileinfo['type'] ) {
				if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, true) ) return false;
				$wp_filesystem->chmod($to . $filename, 0644);
			} elseif ( 'd' == $fileinfo['type'] ) {
				if ( !$wp_filesystem->mkdir($to . $filename, 0755) ) return false;
				if ( !$this->mbanCopyDir($from . $filename, $to . $filename) ) return false;
			}
		}
		return true;
	}
	
	/**
	 * Unzips the file to given directory
	 */
	function mbanUnzipFile($file, $to) {
		global $wp_filesystem;
		if ( ! $wp_filesystem || !is_object($wp_filesystem) )
			return new WP_Error('fs_unavailable', __('Could not access filesystem.'));
		$fs =& $wp_filesystem;
		require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
		$archive = new PclZip($file);
		// Is the archive valid?
		if ( false == ($archive_files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING)) )
			return new WP_Error('incompatible_archive', __('Incompatible archive'), $archive->errorInfo(true));
		if ( 0 == count($archive_files) )
			return new WP_Error('empty_archive', __('Empty archive'));
		$to = trailingslashit($to);
		$path = explode('/', $to);
		$tmppath = '';
		for ( $j = 0; $j < count($path) - 1; $j++ ) {
			$tmppath .= $path[$j] . '/';
			if ( ! $fs->is_dir($tmppath) )
				$fs->mkdir($tmppath, 0755);
		}
		foreach ($archive_files as $file) {
			$path = explode('/', $file['filename']);
			$tmppath = '';
			// Loop through each of the items and check that the folder exists.
			for ( $j = 0; $j < count($path) - 1; $j++ ) {
				$tmppath .= $path[$j] . '/';
				if ( ! $fs->is_dir($to . $tmppath) )
					if ( !$fs->mkdir($to . $tmppath, 0755) )
						return new WP_Error('mkdir_failed', __('Could not create directory'));
			}
			// We've made sure the folders are there, so let's extract the file now:
			if ( ! $file['folder'] )
				if ( !$fs->put_contents( $to . $file['filename'], $file['content']) )
					return new WP_Error('copy_failed', __('Could not copy file'));
				$fs->chmod($to . $file['filename'], 0755);
		}
		return true;
	}

} // Eof Class

$MBPBannerAdsPlugin = new MBPBannerAdsPlugin();
if ( $wp_version < 2.8 ) { 
	add_action('plugins_loaded', 'mbanWidgetInit');
}

/**
 * Template Tag. Displays banners in a zone
 */
function mba_display_zone($zone_id) {
	global $MBPBannerAdsPlugin;
	if ( !is_admin() && $MBPBannerAdsPlugin->mban_activate == 3  ) {
		if ( intval($zone_id) > 0 ) {
			$zone_filter = "t1.id='$zone_id'";
		} else {
			$zone_filter = "t1.name='$zone_id'";
		}
		$sql = "SELECT t2.id, t2.url, t2.link, t2.in_new_win, t2.ad_type, t2.text_ad_code, t1.id as zoneID, t1.noof_banners, 
				t1.banner_prefix_suffix, t1.banner_prefix, t1.banner_suffix, t1.banner_style_class 
				FROM $MBPBannerAdsPlugin->mban_zone_table t1 INNER JOIN $MBPBannerAdsPlugin->mban_banner_table t2 ON t1.id=t2.zoneid 
				WHERE {$zone_filter} AND t1.zone_disable<>'1' AND t2.status='1' ORDER BY RAND()";
		$rs   = @mysql_query($sql);
		$cnt  = 0;
		$id   = array();
		$url  = array();
		$link = array();
		$in_new_win = array();
		$text_ad_code = array();
		$zone_properties = array();
		while ( $data = @mysql_fetch_assoc($rs) ) {
			$cnt++;
			if ( $data['ad_type'] == 1 ) {
				$id[] = $data['id'];
				$text_ad_code[] = $data['text_ad_code'];
			} else {
				$id[]   = $data['id'];
				$url[]  = $data['url'];
				$link[] = $data['link'];
				$in_new_win[] = $data['in_new_win'];
			}
			if ( count($zone_properties) <= 0 ) {
				$zone_properties = array($data['banner_prefix_suffix'],$data['banner_prefix'],$data['banner_suffix'],$data['banner_style_class']);
			}
			if ( $cnt >= $data['noof_banners'] ) break;
		}
		if ( count($id) > 0 ) {
			$banner_output = $MBPBannerAdsPlugin->__mbanGetBanner($id,$url,$link,$in_new_win,$zone_properties,$text_ad_code);
			echo $banner_output;
		}
	}
}

/**
 * Template Tag. Displays banner
 */
function mba_display_banner($banner_id) {
	global $MBPBannerAdsPlugin;
	if ( !is_admin() && $MBPBannerAdsPlugin->mban_activate == 3  ) {
		if ( intval($banner_id) > 0 ) {
			$banner_filter = "id='$banner_id'";
		} else {
			$banner_filter = "name='$banner_id'";
		}
		$sql = "SELECT id,url,link,in_new_win,ad_type,text_ad_code FROM $MBPBannerAdsPlugin->mban_banner_table WHERE status='1' AND {$banner_filter}";
		$rs  = @mysql_query($sql);
		$id   = array();
		$url  = array();
		$link = array();
		$in_new_win = array();
		$text_ad_code = array();
		$zone_properties = array();
		while ( $data = @mysql_fetch_assoc($rs) ) {
			$cnt++;
			if ( $data['ad_type'] == 1 ) {
				$id[] = $data['id'];
				$text_ad_code[] = $data['text_ad_code'];
			} else {
				$id[]   = $data['id'];
				$url[]  = $data['url'];
				$link[] = $data['link'];
				$in_new_win[] = $data['in_new_win'];
			}
		}
		if ( count($id) > 0 ) {
			$banner_output = $MBPBannerAdsPlugin->__mbanGetBanner($id,$url,$link,$in_new_win,$zone_properties,$text_ad_code);
			echo $banner_output;
		}
	}
}

/**
 * Template Tag. Displays banners in sidebar
 */
function mban_sidebar_banners($zone_id='', $title='', $before_widget='', $after_widget='', $before_title='', $after_title='') {
	global $MBPBannerAdsPlugin;

	if ( !is_admin() && $MBPBannerAdsPlugin->mban_activate == 3  ) {
		$banner_output = '';
		$banner_output = $MBPBannerAdsPlugin->__mbanInsertBanner('aw', $zone_id);
		if ( strlen($banner_output) > 5 && (strpos($banner_output, base64_decode("UG93ZXJlZA==")) !== false) ) {
			echo $before_widget;
			if ( trim($title) != '' ) echo $before_title.$title.$after_title;
			echo $banner_output;
			echo $after_widget;
		}
	}
}

/**
 * Max Banner Ads Widget
 */
function mbanWidgetInit() {
	global $MBPBannerAdsPlugin;
	// Check if required Widget API functions are defined
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') || $MBPBannerAdsPlugin->mban_activate != 3 ) {
		return; 
	}

	function mbanWidgetSidebar($args,$zone_id) {
		extract($args);
		mban_sidebar_banners($zone_id, $title='', $before_widget, $after_widget, $before_title, $after_title);
	}
	
	function mbanWidgetController($zone_id) {
		global $MBPBannerAdsPlugin;
		if ( isset($_POST["mban_widget_submit"]) ) {
			foreach ( $_POST['mban'] as $zoneID => $zone_data ) {
				$aw_title                  = $zone_data['aw_title'];
				$aw_position               = $zone_data['aw_position'];
				$aw_position_fixed         = $zone_data['aw_position_fixed'];
				$aw_position_random_left   = $zone_data['aw_position_random_left'];
				$aw_position_random_center = $zone_data['aw_position_random_center'];
				$aw_position_random_right  = $zone_data['aw_position_random_right'];
				$aw_position_custom_prefix = $zone_data['aw_position_custom_prefix'];
				$aw_position_custom_suffix = $zone_data['aw_position_custom_suffix'];
				$sql = "UPDATE $MBPBannerAdsPlugin->mban_zone_table SET aw_position='$aw_position', aw_position_fixed='$aw_position_fixed', aw_position_random_left='$aw_position_random_left', 
						aw_position_random_center='$aw_position_random_center', aw_position_random_right='$aw_position_random_right', aw_position_custom_prefix='$aw_position_custom_prefix', 
						aw_position_custom_suffix='$aw_position_custom_suffix', aw_title='$aw_title'  
						WHERE id='$zoneID'";
				@mysql_query($sql);
			}
		}
		$sql = "SELECT * FROM $MBPBannerAdsPlugin->mban_zone_table WHERE id='$zone_id'";
		$rs = @mysql_query($sql);
		if ( $rs > 0 ) {
			$row = @mysql_fetch_assoc($rs);
			$aw_title                  = $row['aw_title'];
			$aw_position               = $row['aw_position'];
			$aw_position_fixed         = $row['aw_position_fixed'];
			$aw_position_random_left   = $row['aw_position_random_left'];
			$aw_position_random_center = $row['aw_position_random_center'];
			$aw_position_random_right  = $row['aw_position_random_right'];
			$aw_position_custom_prefix = $row['aw_position_custom_prefix'];
			$aw_position_custom_suffix = $row['aw_position_custom_suffix'];
		}
		$row_display_style = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') ? 'block' : 'table-row';
		$aw_position_custom_display = 'none';
		$aw_position_random_display = 'none';
		$aw_position_fixed_display  = 'none';
		if ( $aw_position == 'custom' ) {
			$aw_position_custom_display = $row_display_style;
			$aw_position_custom_chk = 'checked';
		} else if ( $aw_position == 'random' ) {
			$aw_position_random_display = $row_display_style;
			$aw_position_random_chk = 'checked';
		} else {
			$aw_position_fixed_display  = $row_display_style;
			$aw_position_fixed_chk = 'checked';
		}
		if ( $aw_position_fixed == 'left' ) $aw_position_fixed_left = 'selected';
		else if ( $aw_position_fixed == 'right' ) $aw_position_fixed_right = 'selected';
		else $aw_position_fixed_center = 'selected';
		if ( $aw_position_random_left == 1 )   $aw_position_random_left_chk   = 'checked';
		if ( $aw_position_random_center == 1 ) $aw_position_random_center_chk = 'checked';
		if ( $aw_position_random_right == 1 )  $aw_position_random_right_chk  = 'checked';
		?>
		<div>
		  <table cellpadding="3" cellspacing="0" align="right" border="0" width="100%" style="border:1px solid #f1f1f1">
		   <tr bgcolor="#f3f3f3">
		    <td>Title: <input type="text" class="widefat" name="mban[<?php echo $zone_id;?>][aw_title]" id="aw_title" value="<?php echo htmlspecialchars($aw_title);?>" style="width:220px;" /></td>
		   </tr>
		   <tr bgcolor="#ffffff">
			<td><input type="radio" name="mban[<?php echo $zone_id;?>][aw_position]" id="aw_position" value="fixed" <?php echo $aw_position_fixed_chk;?> onclick="__mbanShowHideAW('aw_position_fixed_div','<?php echo $zone_id;?>')" /> Fixed Alignment</td>
		   </tr>
		   <tr bgcolor="#ffffff" id="aw_position_fixed_div_<?php echo $zone_id;?>" style="display:<?php echo $aw_position_fixed_display;?>">
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<select name="mban[<?php echo $zone_id;?>][aw_position_fixed]" id="aw_position_fixed">
			 <option value="left" <?php echo $aw_position_fixed_left;?>>Left</option>
			 <option value="center" <?php echo $aw_position_fixed_center;?>>Center</option>
			 <option value="right" <?php echo $aw_position_fixed_right;?>>Right</option>
			</select></td>
		   </tr>
		   <tr bgcolor="#f3f3f3">
			<td><input type="radio" name="mban[<?php echo $zone_id;?>][aw_position]" id="aw_position_random" value="random" <?php echo $aw_position_random_chk;?> onclick="__mbanShowHideAW('aw_position_random_div','<?php echo $zone_id;?>')" /> Random</td>
		   </tr>
		   <tr bgcolor="#f3f3f3" id="aw_position_random_div_<?php echo $zone_id;?>" style="display:<?php echo $aw_position_random_display;?>">
			<td>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="mban[<?php echo $zone_id;?>][aw_position_random_left]" value="1" id="aw_position_random" <?php echo $aw_position_random_left_chk;?>  /> Left &nbsp;
			<input type="checkbox" name="mban[<?php echo $zone_id;?>][aw_position_random_center]" value="1" id="aw_position_random" <?php echo $aw_position_random_center_chk;?>  /> Center &nbsp;
			<input type="checkbox" name="mban[<?php echo $zone_id;?>][aw_position_random_right]" value="1" id="aw_position_random" <?php echo $aw_position_random_right_chk;?>  /> Right</td>
		   </tr>
		   <tr bgcolor="#ffffff">
			<td><input type="radio" name="mban[<?php echo $zone_id;?>][aw_position]" id="aw_position_custom" value="custom" <?php echo $aw_position_custom_chk;?> onclick="__mbanShowHideAW('aw_position_custom_div','<?php echo $zone_id;?>')" /> Custom </td>
		   </tr>
		   <tr bgcolor="#ffffff" id="aw_position_custom_div_<?php echo $zone_id;?>" style="display:<?php echo $aw_position_custom_display;?>">
			<td> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Before Code: <input type="text" class="widefat" name="mban[<?php echo $zone_id;?>][aw_position_custom_prefix]" id="aw_position_custom_prefix" value="<?php echo htmlspecialchars($aw_position_custom_prefix);?>" style="width:115px;" /><br /> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;After Code:&nbsp;&nbsp; <input type="text" class="widefat" name="mban[<?php echo $zone_id;?>][aw_position_custom_suffix]" id="aw_position_custom_suffix" value="<?php echo htmlspecialchars($aw_position_custom_suffix);?>" style="width:115px;" /></td>
		   </tr>
		   <tr bgcolor="#f3f3f3" height="12"><td></td></tr>
		   <tr bgcolor="#f3f3f3">
		    <td align="center">Powered by <a href="http://www.maxblogpress.com/" target="_blank"><?php echo MBAN_NAME;?> Plugin</a>
			<input type="hidden" name="mban[<?php echo $zone_id;?>][widget_options_exist]" id="mban[<?php echo $zone_id;?>][widget_options_exist]" value="<?php echo $num_rows;?>" />
			<input type="hidden" name="mban_widget_submit" id="mban_widget_submit" value="1" /></td>
		   </tr>
		  </table>
		</div>
	<?php
	}

	$sql = "SELECT  DISTINCT zid, zname FROM (SELECT t1.id AS zid, t1.name AS zname FROM $MBPBannerAdsPlugin->mban_zone_table t1 
			INNER JOIN $MBPBannerAdsPlugin->mban_banner_table t2 ON t1.id=t2.zoneid WHERE t1.zone_disable<>'1' AND t1.as_widget='1' 
			AND t2.status='1' ORDER BY t1.id DESC) AS tbl_distinct_widgets";
	$rs  = @mysql_query($sql);
	if ( $rs ) {
		while ( $row = @mysql_fetch_assoc($rs) ) {
			$zone_id   = $row['zid'];
			$zone_name = 'MBAN-'.$row['zname'];
			if ( function_exists('wp_register_sidebar_widget') ) { // fix for wordpress 2.2
				wp_register_sidebar_widget(sanitize_title($zone_name), $zone_name, 'mbanWidgetSidebar', array(), $zone_id);
			} else {
				register_sidebar_widget($zone_name, 'mbanWidgetSidebar', $zone_id);
			}
			register_widget_control($zone_name, 'mbanWidgetController', '', '210px', $zone_id);
		}
	}
}

if ( $wp_version >= 2.8 ) {
	class mban_sidebar_widget extends WP_Widget {
		// widget actual processes
		function mban_sidebar_widget() {
			$widget_ops = array('description' => 'Put the banners on your sidebar');
			$this->WP_Widget('maxbannerads', 'MBAN Sidebar Widget', $widget_ops);
		}
		
		// outputs the content of the widget
		function widget($args, $instance) {
			extract($args);
			$zone_id = intval($instance['aw_zone_id']);
			mban_sidebar_banners($zone_id, $title='', $before_widget, $after_widget, $before_title, $after_title, $instance);
		}
	
		// processes widget options to be saved
		function update($new_instance, $old_instance) {
			global $MBPBannerAdsPlugin, $wpdb;
			$aw_zone_id                = $new_instance['aw_zone_id'];
			$aw_title                  = $new_instance['aw_title'];
			$aw_position               = $new_instance['aw_position'];
			$aw_position_fixed         = $new_instance['aw_position_fixed'];
			$aw_position_random_left   = $new_instance['aw_position_random_left'];
			$aw_position_random_center = $new_instance['aw_position_random_center'];
			$aw_position_random_right  = $new_instance['aw_position_random_right'];
			$aw_position_custom_prefix = $new_instance['aw_position_custom_prefix'];
			$aw_position_custom_suffix = $new_instance['aw_position_custom_suffix'];
			$sql = "UPDATE $MBPBannerAdsPlugin->mban_zone_table SET aw_position='$aw_position', aw_position_fixed='$aw_position_fixed', aw_position_random_left='$aw_position_random_left', 
					aw_position_random_center='$aw_position_random_center', aw_position_random_right='$aw_position_random_right', aw_position_custom_prefix='$aw_position_custom_prefix', 
					aw_position_custom_suffix='$aw_position_custom_suffix', aw_title='$aw_title'  
					WHERE id='$aw_zone_id'";
			$wpdb->query($sql);
			return $new_instance;
		}
		
		// outputs the options form on admin
		function form($instance) {
			global $MBPBannerAdsPlugin, $wpdb;
			$sidebar_zones = $wpdb->get_results("SELECT id,name FROM $MBPBannerAdsPlugin->mban_zone_table WHERE as_widget='1'");
			$instance = wp_parse_args((array) $instance, array('aw_zone_id' => 0, 'aw_title' => '', 'aw_position' => '', 'aw_position_fixed' => '', 'aw_position_random_left' => '', 'aw_position_random_center' => '', 'aw_position_random_right' => '', 'aw_position_custom_prefix' => '', 'aw_position_custom_suffix' => ''));
			$aw_zone_id = intval($instance['aw_zone_id']);
			$aw_zone_id = $aw_zone_id == 0 ? $aw_zone_id='' : $aw_zone_id;
			$aw_title = esc_attr($instance['aw_title']);
			$aw_position = $instance['aw_position'];
			$aw_position_fixed = $instance['aw_position_fixed'];
			$aw_position_random_left = $instance['aw_position_random_left'];
			$aw_position_random_center = $instance['aw_position_random_center'];
			$aw_position_random_right = $instance['aw_position_random_right'];
			$aw_position_custom_prefix = $instance['aw_position_custom_prefix'];
			$aw_position_custom_suffix = $instance['aw_position_custom_suffix'];
			if ( $aw_position == 'custom' ) {
				$aw_position_custom_chk = 'checked';
			} else if ( $aw_position == 'random' ) {
				$aw_position_random_chk = 'checked';
			} else {
				$aw_position_fixed_chk = 'checked';
			}
			if ( $aw_position_fixed == 'left' ) $aw_position_fixed_left = 'selected';
			else if ( $aw_position_fixed == 'right' ) $aw_position_fixed_right = 'selected';
			else $aw_position_fixed_center = 'selected';
			if ( $aw_position_random_left == 1 )   $aw_position_random_left_chk   = 'checked';
			if ( $aw_position_random_center == 1 ) $aw_position_random_center_chk = 'checked';
			if ( $aw_position_random_right == 1 )  $aw_position_random_right_chk  = 'checked';
			?>
			<label for="<?php echo $this->get_field_id('aw_zone_id'); ?>"><br />
			Zone: <select class="widefat" id="<?php echo $this->get_field_id('aw_zone_id'); ?>" name="<?php echo $this->get_field_name('aw_zone_id'); ?>" style="width:150px;">
			<?php foreach ( $sidebar_zones as $sidebar_zone ) {
				if ( $sidebar_zone->id == $aw_zone_id ) $selected = 'selected';
				else $selected = '';
				echo '<option value="'.$sidebar_zone->id.'" '.$selected.'>'.$sidebar_zone->name.'</option>';
			}?></select>
			</label>
			<label for="none-1" style="line-height:1px;display:block;"></label>
			<label for="<?php echo $this->get_field_id('aw_title'); ?>"><br />
			Title: <input type="text" class="widefat" id="<?php echo $this->get_field_id('aw_title'); ?>" name="<?php echo $this->get_field_name('aw_title'); ?>" value="<?php echo $aw_title; ?>" style="width:160px;" >
			</label>
			<label for="none-2" style="line-height:18px;display:block;">&nbsp;</label>
			<label for="<?php echo $this->get_field_id('aw_align'); ?>">Alignment:</label>
			<div style="border:1px solid #e5e5e5; background-color:#f8f8f8; padding:3px;">
				<label for="<?php echo $this->get_field_id('aw_position1'); ?>">
				<input type="radio" class="checkbox" id="<?php echo $this->get_field_id('aw_position'); ?>" name="<?php echo $this->get_field_name('aw_position'); ?>" value="fixed" <?php echo $aw_position_fixed_chk;?> onclick="__mbanShowHideAW('aw_position_fixed_div_','')"> Fixed
				</label>
				<label for="<?php echo $this->get_field_id('aw_position_fixed_blk'); ?>">
				<select id="<?php echo $this->get_field_id('aw_position_fixed'); ?>" name="<?php echo $this->get_field_name('aw_position_fixed'); ?>">
				 <option value="left" <?php echo $aw_position_fixed_left;?>>Left</option>
				 <option value="center" <?php echo $aw_position_fixed_center;?>>Center</option>
				 <option value="right" <?php echo $aw_position_fixed_right;?>>Right</option>
				</select>
				</label>
				<label for="none-3" style="line-height:1px;display:block;"></label>
				<label for="<?php echo $this->get_field_id('aw_position2'); ?>"><br />
				<input type="radio" class="checkbox" id="<?php echo $this->get_field_id('aw_position'); ?>" name="<?php echo $this->get_field_name('aw_position'); ?>" value="random" <?php echo $aw_position_random_chk;?> onclick="__mbanShowHideAW('aw_position_random_div_','')"> Random
				</label>
				<label for="<?php echo $this->get_field_id('aw_position_random_blk'); ?>"><br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('aw_position_random_left'); ?>" name="<?php echo $this->get_field_name('aw_position_random_left'); ?>" value="1" <?php echo $aw_position_random_left_chk;?>  /> Left &nbsp;
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('aw_position_random_center'); ?>" name="<?php echo $this->get_field_name('aw_position_random_center'); ?>" value="1" <?php echo $aw_position_random_center_chk;?>  /> Center &nbsp;
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('aw_position_random_right'); ?>" name="<?php echo $this->get_field_name('aw_position_random_right'); ?>" value="1" <?php echo $aw_position_random_right_chk;?>  /> Right
				</label>
				<label for="none-4" style="line-height:1px;display:block"></label>
				<label for="<?php echo $this->get_field_id('aw_position3'); ?>"><br />
				<input type="radio" class="checkbox" id="<?php echo $this->get_field_id('aw_position'); ?>" name="<?php echo $this->get_field_name('aw_position'); ?>" value="custom" <?php echo $aw_position_custom_chk;?> onclick="__mbanShowHideAW('aw_position_custom_div_','');"> Custom
				</label>
				<label for="<?php echo $this->get_field_id('aw_position_custom_blk'); ?>"><br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Before Code: <input type="text" class="widefat" id="<?php echo $this->get_field_id('aw_position_custom_prefix'); ?>" name="<?php echo $this->get_field_name('aw_position_custom_prefix'); ?>" value="<?php echo htmlspecialchars($aw_position_custom_prefix);?>" style="width:100px;" /><br /> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;After Code: &nbsp;&nbsp; <input type="text" class="widefat" id="<?php echo $this->get_field_id('aw_position_custom_suffix'); ?>" name="<?php echo $this->get_field_name('aw_position_custom_suffix'); ?>" value="<?php echo htmlspecialchars($aw_position_custom_suffix);?>" style="width:100px;" />
				</label>
			</div>
			<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
			<?php
		}
	}
	add_action('widgets_init', create_function('', 'return register_widget(mban_sidebar_widget);'));
}
?>