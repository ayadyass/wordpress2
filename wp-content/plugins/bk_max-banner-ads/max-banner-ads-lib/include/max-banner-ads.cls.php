<?php
/* 
 * License: Copyright (c) 2008 Pawan Agrawal. All rights reserved.
 *
 * This code is part of commercial software and for your personal use 
 * only. You are not allowed to resell or distribute this script.
 *
 */
 
/**
 * MBPBannerAds - Max Banner Ads
 * Holds all the necessary functions and variables
 */
class MBPBannerAds
{
	var $mban_settings      = array();
	var $mban_options_table = 'mban_options';
	var $mban_zone_table    = 'mban_zone';
	var $mban_banner_table  = 'mban_banner';
	var $banner_width_max   = 290;
	var $banner_height_max  = 120;
	var $mban_dir           = 'mbp-banner';
	var $default_style_class= "padding:4px 4px 4px 4px;\nborder:0;";
	
	/**
     * Holds the default settings values
     * @var array
     */
	var	$default_zone_settings = array(
					'top_of_first_post' => '1', 		 	'tfp_position' => 'fixed',
					'tfp_position_fixed' => 'center',   	'tfp_position_random_left' => '1', 	 	'tfp_position_random_center' => '1',
					'tfp_position_random_right' => '1', 	'blp_position' => 'fixed',       	 	'blp_position_fixed' => 'center',
					'blp_position_random_left' => '1',  	'blp_position_random_center' => '1', 	'blp_position_random_right' => '1',
					'wp_show_in' => '1', 					'wp_position' => 'fixed', 			 	'wp_position_fixed' => 'top',
					'wp_wrap' => '1', 						'wp_preset_custom' => 'preset', 		'wp_preset_position' => 'right',
					'wp_random_top' => '1', 				'wp_random_topleft' => '1', 			'wp_random_topcenter' => '1',
					'wp_random_topright' => '1', 			'wp_random_middle' => '1', 			 	'wp_random_middleleft' => '1',
					'wp_random_middleright' => '1', 		'wp_random_bottom' => '1', 			 	'wp_random_bottomleft' => '1',	 	
					'wp_random_bottomcenter' => '1', 		'wp_random_bottomright' => '1',  	 	'wp_random_topleft_wrap' => '1', 
					'wp_random_topleft_nowrap' => '1', 		'wp_random_topright_wrap' => '1',  	 	'wp_random_topright_nowrap' => '1', 
					'wp_random_middleleft_wrap' => '1',     'wp_random_middleleft_nowrap' => '1',   'wp_random_middleright_wrap' => '1', 
					'wp_random_middleright_nowrap' => '1',  'wp_random_bottomleft_wrap' => '1',  	'wp_random_bottomleft_nowrap' => '1', 
					'wp_random_bottomright_wrap' => '1',    'wp_random_bottomright_nowrap' => '1',  'aw_position' => 'fixed', 			
					'aw_position_fixed' => 'center', 		'aw_position_random_left' => '1',	 	'aw_position_random_center' => '1', 
					'aw_position_random_right' => '1', 	    'noof_banners' => '1',                  'show_in_pages' => ',all,',
					);
					
	/**
	 * Constructor.
	 */
	function MBPBannerAds() {}
	
	/**
	 * Creates zone table
	 */
	function __mbanCreateZoneTable() {
		$rs = @mysql_query("SHOW TABLES LIKE '$this->mban_zone_table'");
		$exists = @mysql_fetch_row($rs);
		if ( !$exists ) {
			$sql = "CREATE TABLE ".$this->mban_zone_table." (
					`id` int(11) NOT NULL auto_increment, 							`name` varchar(150) NOT NULL, 
					`top_of_first_post` enum('0','1') NOT NULL DEFAULT '0',			`tfp_position` varchar(50) DEFAULT 'fixed',  
					`tfp_position_fixed` varchar(50) DEFAULT 'center',     			`tfp_position_random_left` enum('0','1') NOT NULL DEFAULT '1',
					`tfp_position_random_center` enum('0','1') NOT NULL DEFAULT '1',`tfp_position_random_right` enum('0','1') NOT NULL DEFAULT '1',
					`tfp_position_custom_prefix` varchar(250),						`tfp_position_custom_suffix` varchar(250), 
					`bottom_of_last_post` enum('0','1') NOT NULL DEFAULT '0',		`blp_position` varchar(50) DEFAULT 'fixed',  
					`blp_position_fixed` varchar(50) DEFAULT 'center', 				`blp_position_random_left` enum('0','1') NOT NULL DEFAULT '1',
					`blp_position_random_center` enum('0','1') NOT NULL DEFAULT '1',`blp_position_random_right` enum('0','1') NOT NULL DEFAULT '1',
					`blp_position_custom_prefix` varchar(250),						`blp_position_custom_suffix` varchar(250), 
					`within_post` enum('0','1') NOT NULL DEFAULT '0',				`wp_show_in` varchar(100) NOT NULL DEFAULT ',1,',
					`wp_position` varchar(50) DEFAULT 'fixed', 					    `wp_position_fixed` varchar(50) DEFAULT 'top',  
					`wp_wrap` enum('0','1') NOT NULL DEFAULT '1',					`wp_preset_custom` varchar(50),  
					`wp_preset_position` varchar(50) DEFAULT 'right',				`wp_custom_prefix` varchar(250), 
					`wp_custom_suffix` varchar(250), 								`wp_random_top` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_topleft` enum('0','1') NOT NULL DEFAULT '1',			`wp_random_topcenter` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_topright` enum('0','1') NOT NULL DEFAULT '1',		`wp_random_middle` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_middleleft` enum('0','1') NOT NULL DEFAULT '1',		`wp_random_middleright` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_bottom` enum('0','1') NOT NULL DEFAULT '1',			`wp_random_bottomleft` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_bottomcenter` enum('0','1') NOT NULL DEFAULT '1',	`wp_random_bottomright` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_topleft_wrap` enum('0','1') NOT NULL DEFAULT '1',	`wp_random_topleft_nowrap` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_topright_wrap` enum('0','1') NOT NULL DEFAULT '1',	`wp_random_topright_nowrap` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_middleleft_wrap` enum('0','1') NOT NULL DEFAULT '1',	`wp_random_middleleft_nowrap` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_middleright_wrap` enum('0','1') NOT NULL DEFAULT '1',`wp_random_middleright_nowrap` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_bottomleft_wrap` enum('0','1') NOT NULL DEFAULT '1',	`wp_random_bottomleft_nowrap` enum('0','1') NOT NULL DEFAULT '1',
					`wp_random_bottomright_wrap` enum('0','1') NOT NULL DEFAULT '1',`wp_random_bottomright_nowrap` enum('0','1') NOT NULL DEFAULT '1',
					`as_widget` enum('0','1') NOT NULL DEFAULT '0',					`aw_position` varchar(50) DEFAULT 'fixed',  
					`aw_position_fixed` varchar(50) DEFAULT 'center', 				`aw_position_random_left` enum('0','1') NOT NULL DEFAULT '1',
					`aw_position_random_center` enum('0','1') NOT NULL DEFAULT '1',	`aw_position_random_right` enum('0','1') NOT NULL DEFAULT '1',
					`aw_position_custom_prefix` varchar(250), 						`aw_position_custom_suffix` varchar(250), 
					`aw_title` varchar(250), 										`zone_disable` enum('0','1') NOT NULL DEFAULT '0',
					`noof_banners` tinyint(4) DEFAULT 1, 							`show_in_pages` varchar(100) DEFAULT ',all,',
					`banner_prefix_suffix` enum('0','1') NOT NULL DEFAULT '1',		`banner_prefix` varchar(250),									
					`banner_suffix` varchar(250), 									`banner_style_class` text, 
					PRIMARY KEY (`id`)
					);
					";
			@mysql_query($sql);
			return true;
		}
		return false;
	}
	
	/**
	 * Creates banner table
	 */
	function __naffCreateBannerTable() {
		$rs = @mysql_query("SHOW TABLES LIKE '$this->mban_banner_table'");
		$exists = @mysql_fetch_row($rs);
		if ( !$exists ) {
			$sql = "CREATE TABLE ".$this->mban_banner_table." (
					`id` int(11) NOT NULL auto_increment,      
					`zoneid` int(11),      
					`name` varchar(150), 
					`url` varchar(250), 
					`link` varchar(250), 
					`impressions` int(11) DEFAULT 0,       
					`clicks` int(11) DEFAULT 0,       
					`status` enum('0','1'),
					`width` smallint(6) DEFAULT 0,  
					`height` smallint(6) DEFAULT 0,  
					`in_new_win` enum('0','1') DEFAULT '0', 
					`ad_type` enum('0','1') DEFAULT '0', 
					`text_ad_code` longtext,  
					`img_tag` varchar(250) DEFAULT '', 
					`follow_link` enum('0','1') DEFAULT '0',  
					PRIMARY KEY (`id`)
					);
					";
			@mysql_query($sql);
			return true;
		}
		return false;
	}
	
	/**
	 * Creates options table
	 */
	function __mbanCreateOptionsTable() {
		$rs = @mysql_query("SHOW TABLES LIKE '$this->mban_options_table'");
		$exists = @mysql_fetch_row($rs);
		if ( !$exists ) {
			$sql = "CREATE TABLE ".$this->mban_options_table." (
					`option_name` varchar(250) NOT NULL,
					`option_value` longtext NOT NULL,
					PRIMARY KEY (`option_name`)
					);
					";
			@mysql_query($sql);
			return true;
		}
		return false;
	}
	
	/**
	 * Installed and landed on registration page Test.
	 */
	 function __mbaPluginInstallTest() { 
	 ?>
	 <img src='http://www.maxblogpress.com/sta5/TY_via_ip.php?id=LVCigkdp7CE%3D&outcome=2&sta_amt=0' width='0' height='0'>
	 <?php 
	 }
	
	
	/**
	 * Alters banner/zone tables to suit the upgraded version
	 */
	function __mbanAlterTables($db_name) {
		$rs_b_1 = @mysql_query("SHOW COLUMNS FROM $this->mban_banner_table FROM $db_name LIKE 'in_new_win'");
		if ( @mysql_num_rows($rs_b_1) <= 0 ) {
			@mysql_query("ALTER TABLE $this->mban_banner_table ADD in_new_win enum('0','1') DEFAULT '0'");
		}
		$rs_b_2 = @mysql_query("SHOW COLUMNS FROM $this->mban_banner_table FROM $db_name LIKE 'text_ad_code'");
		if ( @mysql_num_rows($rs_b_2) <= 0 ) {
			@mysql_query("ALTER TABLE $this->mban_banner_table ADD ad_type enum('0','1') DEFAULT '0', ADD text_ad_code longtext");
		}
		$rs_b_3 = @mysql_query("SHOW COLUMNS FROM $this->mban_banner_table FROM $db_name LIKE 'follow_link'");
		if ( @mysql_num_rows($rs_3_2) <= 0 ) {
			@mysql_query("ALTER TABLE $this->mban_banner_table ADD follow_link enum('0','1') DEFAULT '0', ADD img_tag varchar(250) DEFAULT ''");
		}
		$rs_z_1 = @mysql_query("SHOW COLUMNS FROM $this->mban_zone_table FROM $db_name LIKE 'banner_style_class'");
		if ( @mysql_num_rows($rs_z_1) <= 0 ) {
			@mysql_query("ALTER TABLE $this->mban_zone_table ADD banner_style_class text");
			@mysql_query("UPDATE $this->mban_zone_table SET banner_style_class='$this->default_style_class'");
			@mysql_query("ALTER TABLE $this->mban_zone_table ALTER banner_prefix_suffix SET DEFAULT '1'");
		}
		$rs_z_2 = @mysql_query("SHOW COLUMNS FROM $this->mban_zone_table FROM $db_name LIKE 'show_in_pages'");
		if ( @mysql_num_rows($rs_z_2) <= 0 ) {
			@mysql_query("ALTER TABLE $this->mban_zone_table ADD show_in_pages varchar(100) DEFAULT ',all,'");
		}
		return true;
	}
	
	/**
	 * Checks if table structure is intact or not
	 */
	function __mbanCheckTableStructure() {
		$rs_1 = @mysql_query("SHOW COLUMNS FROM $this->mban_banner_table LIKE 'in_new_win'");
		if ( @mysql_num_rows($rs_1) <= 0 ) return false;
		$rs_2 = @mysql_query("SHOW COLUMNS FROM $this->mban_zone_table LIKE 'banner_style_class'");
		if ( @mysql_num_rows($rs_2) <= 0 ) return false;
		return true;
	}

	/**
	 * Adds default data to DB tables. Add default zone in zone table.
	 */
	function __mbanAddDefaultData() {
		$options = array('loop_number' => 1, 'loop_ordinal' => 'st', 'clickbank_id' => '', 'stats_default_zone' => 'all', 'disable_all_banners' => '');
		$options = serialize($options);
		$sql_1 = "INSERT INTO $this->mban_zone_table (name, bottom_of_last_post, banner_style_class) VALUES ('Bottom of Last Post', '1', '$this->default_style_class')";
		$sql_2 = "INSERT INTO $this->mban_zone_table (name, top_of_first_post, banner_style_class) VALUES ('Top of First Post', '1', '$this->default_style_class')";
		$sql_3 = "INSERT INTO $this->mban_zone_table (name, as_widget, banner_style_class) VALUES ('Sidebar Widget', '1', '$this->default_style_class')";
		$sql_4 = "INSERT INTO $this->mban_zone_table (name, within_post, wp_show_in, banner_style_class) VALUES ('Within The Post', '1', ',1,', '$this->default_style_class')";
		$sql_5 = "INSERT INTO $this->mban_options_table (option_name,option_value) VALUES ('options_global', '$options')";
		@mysql_query($sql_1);
		@mysql_query($sql_2);
		@mysql_query($sql_3);
		@mysql_query($sql_4);
		@mysql_query($sql_5);
	}
	
	/**
	 * Stylesheet and javascript
	 */
	function __mbanStyleAndJS() {
		?>
		<style type="text/css">
		.mbanimg {
			border-bottom: none;
			text-decoration: none;
		}
		</style>
		<script type="text/javascript"><!--
		function __mbantrim(str){
			var n = str;
			while ( n.length>0 && n.charAt(0)==' ' ) 
				n = n.substring(1,n.length);
			while( n.length>0 && n.charAt(n.length-1)==' ' )	
				n = n.substring(0,n.length-1);
			return n;
		}
		function __mbanShowHide(curr, img, path) {
			var curr = document.getElementById(curr);
			if ( img != '' ) {
				var img  = document.getElementById(img);
			}
			var showRow = 'block'
			if ( navigator.appName.indexOf('Microsoft') == -1 && curr.tagName == 'TR' ) {
				var showRow = 'table-row';
			}
			if ( curr.style == '' || curr.style.display == 'none' ) {
				curr.style.display = showRow;
				if ( img != '' ) img.src = path + 'images/minus.gif';
			} else if ( curr.style != '' || curr.style.display == 'block' || curr.style.display == 'table-row' ) {
				curr.style.display = 'none';
				if ( img != '' ) img.src = path + 'images/plus.gif';
			}
		}
		function __mbanShowHideAW(curr,zid) {
			var curr = document.getElementById(curr+'_'+zid);
			var showRow = 'block';
			if ( navigator.appName.indexOf('Microsoft') == -1 && curr.tagName == 'TR' ) {
				var showRow = 'table-row';
			}
			var position_fixed  = document.getElementById('aw_position_fixed_div_'+zid);
			var position_random = document.getElementById('aw_position_random_div_'+zid);
			var position_custom = document.getElementById('aw_position_custom_div_'+zid);
			position_fixed.style.display  = 'none';
			position_random.style.display = 'none';
			position_custom.style.display = 'none';
			curr.style.display = showRow;
		}
		//--></script>	
		<?php
	}
	
	/**
	 * Page Header
	 */
	function __mbanHeader() {
		if ( !isset($_GET['dnl']) ) {	
			$mban_version_chk = $this->mbanRecheckData();
			if ( ($mban_version_chk == '') || strtotime(date('Y-m-d H:i:s')) > (strtotime($mban_version_chk['last_checked_on']) + $mban_version_chk['recheck_interval']*60*60) ) {
				$update_arr = $this->mbanExtractUpdateData();
				if ( count($update_arr) > 0 ) {
					$latest_version   = $update_arr[0];
					$recheck_interval = $update_arr[1];
					$download_url     = $update_arr[2];
					$msg_in_plugin    = $update_arr[3];
					$msg_in_plugin    = $update_arr[4];
					$upgrade_url      = $update_arr[5];
					if( MBAN_VERSION < $latest_version ) {
						$mban_version_check = array('recheck_interval' => $recheck_interval, 'last_checked_on' => date('Y-m-d H:i:s'));
						$this->mbanRecheckData($mban_version_check);
						$msg_in_plugin = str_replace("%latest-version%", $latest_version, $msg_in_plugin);
						$msg_in_plugin = str_replace("%plugin-name%", MBAN_NAME, $msg_in_plugin);
						$msg_in_plugin = str_replace("%upgrade-url%", $upgrade_url, $msg_in_plugin);
						$msg_in_plugin = '<div style="border-bottom:1px solid #CCCCCC;background-color:#FFFEEB;padding:6px;font-size:11px;text-align:center">'.$msg_in_plugin.'</div>';
					} else {
						$msg_in_plugin = '';
					}
				}
			}
		}
		echo '<h2>'. MBAN_NAME .' '. MBAN_VERSION .'</h2>';	
		if ( trim($msg_in_plugin) != '' && !isset($_GET['dnl']) ) echo $msg_in_plugin;
		echo '<br /><strong>'.$this->img_how.' <a href="http://strag.screenstepslive.com/spaces/maxblogpress/manuals/1345" target="_blank">How to use it?</a></strong>&nbsp;&nbsp;&nbsp;';
		echo '<strong>'.$this->img_comment.' <a href="http://community.maxblogpress.com" target="_blank">Comments and Suggestions</a></strong>&nbsp;&nbsp;&nbsp;';
		echo '<strong>'.$this->img_remove.' <a href="http://www.maxblogpress.com/proplugin/maxbanneradspro/" target="_blank">Remove "Powered by '.MBAN_NAME.'" Link</a></strong>';
	}
	
	/**
	 * Page Footer
	 */
	function __mbanFooter() {
		echo '<p style="text-align:center;margin-top:3em;"><strong>'. MBAN_NAME .' '. MBAN_VERSION .' by <a href="http://www.maxblogpress.com/" target="_blank" >MaxBlogPress</a></strong></p>';
	}
	
	/**
	 * Collects and returns GET vars
	 * @param string $var
	 */
	function __mbanBuildGetVars($var='') {
		$get_vars = '';
		foreach ( (array) $_GET as $key => $val ) {
			if ( $key == $var ) {
				$get_vars = $key.'='.$val.'&';
				break;
			} else {
				$get_vars .= $key.'='.$val.'&';
			}
		}
		return $get_vars;
	}
	
	/**
	 * Get global options from option table
	 */
	function __mbanGetOptions() {
		$options_global = array();
		$sql = "SELECT option_value FROM $this->mban_options_table WHERE option_name='options_global'";
		$rs = @mysql_query($sql);
		$num_rows = @mysql_num_rows($rs);
		if ( $num_rows > 0 ) {
			$options_global = @mysql_result($rs,0,'option_value');
			$options_global = unserialize($options_global);
		}
		return $options_global;
	}
	
	/**
	 * Get zone names from zone table
	 */
	function __mbanGetZones() {
		$zone_array = array();
		$sql = "SELECT id,name FROM $this->mban_zone_table ORDER BY name ASC";
		$rs  = @mysql_query($sql);
		if ( $rs ) {
			while ( $row = @mysql_fetch_assoc($rs) ) {
				$zone_array[$row['id']] = $row['name'];
			}
		}
		return $zone_array;
	}
	
	/**
	 * Creates a directory to upload banners
	 */
	function __mbanMakeDir() {
		$mban_upload_path = MBAN_ABSPATH.'wp-content/'.$this->mban_dir;
		if ( is_admin() && !is_dir($mban_upload_path) ) {
			@mkdir($mban_upload_path);
		}
		return $mban_upload_path;
	}

	/**
	 * Delets Banner from upload directory
	 */
	function __mbanRemoveBanner($banner_url) {
		$file_info = pathinfo($banner_url);
		$filename = $file_info['basename'];
		$banner = MBAN_ABSPATH.'wp-content/'.$this->mban_dir.'/'.$filename; 
		if ( file_exists($banner) ) @unlink($banner);
	}
	
	/**
	 * Separate show in posts by comma
	 */
	function __mbanWPShowInPosts() {
		if ( $this->mban_request['wp_show_in_all'] != 1 ) {
			for ( $i=1; $i<=10; $i++ ) { 
				$fld_wp_show_in = 'wp_show_in_'.$i;
				if ( $this->mban_request[$fld_wp_show_in] == 1 ) {
					$_wp_show_in .= $i.',';
				}
			}
			$_wp_show_in = trim($_wp_show_in,',');
		} else {
			$_wp_show_in = 'all';
		}
		return $_wp_show_in;
	}
	
	/**
	 * Shuffles an array and preserves index association
	 */
	function __mbanShuffleArray($array) {
		if ( count($array) > 1 ) {
			$keys = array_rand($array, count($array));
			foreach ( $keys as $key ) {
				$new_array[$key] = $array[$key];
			}
			$array = $new_array;
		}
		return $array;
	}
	
	/**
	 * Counts Impression for each banner appearing on a page
	 */
	function __mbanCountImpression() {
		$banner_ids = implode('_',$this->usedbanners);
		if ( trim($banner_ids) == '' ) $impression_counter = '';
		else $impression_counter = '<img src="'.MBAN_LIBPATH.'include/impression.php?ids='.$banner_ids.'" width="1" height="1" border="0" style="visibility:hidden">';
		echo $impression_counter;
		$this->usedbanners = array();
	}
	
	/**
	 * Displays banners in specific positions
	 */
	function __mbanInsertBanner($position, $zoneID='', $post_content='', $post_number='') {
		$banner_output = '';
		$zone_id_arr   = array();
		$banner_arr    = array();
		$post_number   = intval($post_number);
		
		if ( !is_array($this->options_global) ) {
			$this->options_global = $this->__mbanGetOptions(); // Get global options
		}
		$clickbank_id        = $this->options_global['clickbank_id'];
		$remove_pwd          = $this->options_global['remove_pwd'];
		$stats_default_zone  = $this->options_global['stats_default_zone'];
		$disable_all_banners = $this->options_global['disable_all_banners'];
		if ( $disable_all_banners == 1) return true;
		if ( $position == 'tfp' ) { 
			$this->loop_count_tfp++;
			if ( $this->loop_count_tfp != $this->options_global['loop_number'] ) return;
			$banner_pos = 'top_of_first_post';
			$pfx = 'tfp';
		}
		else if ( $position == 'blp' ) {
			$this->loop_count_blp++;
			if ( $this->loop_count_blp != $this->options_global['loop_number'] ) return;
			$banner_pos = 'bottom_of_last_post';
			$pfx = 'blp';
		}
		else if ( $position == 'aw' )  {
			$banner_pos = 'as_widget';
			$pfx = 'aw';
		}
		else if ( $position == 'wp' )  $banner_pos = 'within_post';
		else return false;
		if ( trim($clickbank_id) == '' ) {
			$clickbank_id = base64_decode("bmljZWFydA==");
		}
		${base64_decode("bWJhbl9w")} = base64_decode("PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZTo5cHgiPlBvd2VyZWQgYnkgPGEgc3R5bGU9ImNvbG9yOiMwMDAwZmY7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7Zm9udC1zaXplOjlweCIgaHJlZj0iaHR0cDovL3d3dy5tYXhibG9ncHJlc3MuY29tL2dvLnBocD9vZmZlcj0=").$clickbank_id.'&pid=12" '.base64_decode("dGFyZ2V0PSJfYmxhbmsiIG9ubW91c2VvdmVyPSJzZWxmLnN0YXR1cz0nTWF4QmxvZ1ByZXNzLmNvbSc7cmV0dXJuIHRydWU7IiBvbm1vdXNlb3V0PSJzZWxmLnN0YXR1cz0nJyI+TWF4IEJhbm5lciBBZHM8L2E+PC9zcGFuPg==");
		
		// Select active zones having at least one active banner
		$this->zone_banner_arr = array();
		$this->zone_banner_inuse_arr = array();
		$show_in_pg = $this->mbanCheckPageType();
		$sql = "SELECT t2.id AS banner_id, t2.url, t2.link, t2.in_new_win, t2.ad_type, t2.text_ad_code, t2.img_tag, t2.follow_link, t1.* 
				FROM $this->mban_zone_table t1 INNER JOIN $this->mban_banner_table t2 ON t1.id=t2.zoneid 
				WHERE t1.{$banner_pos}='1' AND t1.zone_disable<>'1' AND t2.status='1' AND (t1.show_in_pages LIKE '%,all,%' OR t1.show_in_pages LIKE '%,$show_in_pg,%')"; 
		if ( $zoneID != '' ) $sql .= " AND t1.id='$zoneID'";	
		if ( $position == 'wp' ) $sql .= " AND (t1.wp_show_in LIKE '%,all,%' OR t1.wp_show_in LIKE '%,$post_number,%') ";
		$sql .= " ORDER BY RAND()";
		$rs = @mysql_query($sql);
		while ( $row = @mysql_fetch_assoc($rs) ) {
			if( !in_array($row['id'],$zone_id_arr) ) $zone_id_arr[] = $row['id']; // Unique Zone IDs
			if ( $position == 'wp' ) {
				$this->zone_banner_arr[$row['id']]['zonedata'] = 
					array('noof_banners' => $row['noof_banners'], 'wp_show_in' => $row['wp_show_in'], 'wp_position' => $row['wp_position'], 
					'wp_position_fixed' => $row['wp_position_fixed'], 'wp_wrap' => $row['wp_wrap'], 'wp_preset_custom' => $row['wp_preset_custom'], 
					'wp_preset_position' => $row['wp_preset_position'], 'wp_custom_prefix' => $row['wp_custom_prefix'], 'wp_custom_suffix' => $row['wp_custom_suffix'], 
					'wp_random_top' => $row['wp_random_top'], 'wp_random_topleft' => $row['wp_random_topleft'], 'wp_random_topcenter' => $row['wp_random_topcenter'], 
					'wp_random_topright' => $row['wp_random_topright'], 'wp_random_middle' => $row['wp_random_middle'], 'wp_random_middleleft' => $row['wp_random_middleleft'], 
					'wp_random_middleright' => $row['wp_random_middleright'], 'wp_random_bottom' => $row['wp_random_bottom'], 'wp_random_bottomleft' => $row['wp_random_bottomleft'], 
					'wp_random_bottomcenter' => $row['wp_random_bottomcenter'], 'wp_random_bottomright' => $row['wp_random_bottomright'], 'wp_random_topleft_wrap' => $row['wp_random_topleft_wrap'], 
					'wp_random_topleft_nowrap' => $row['wp_random_topleft_nowrap'], 'wp_random_topright_wrap' => $row['wp_random_topright_wrap'], 'wp_random_topright_nowrap' => $row['wp_random_topright_nowrap'], 
					'wp_random_middleleft_wrap' => $row['wp_random_middleleft_wrap'], 'wp_random_middleleft_nowrap' => $row['wp_random_middleleft_nowrap'], 'wp_random_middleright_wrap' => $row['wp_random_middleright_wrap'], 
					'wp_random_middleright_nowrap' => $row['wp_random_middleright_nowrap'], 'wp_random_bottomleft_wrap' => $row['wp_random_bottomleft_wrap'], 'wp_random_bottomleft_nowrap' => $row['wp_random_bottomleft_nowrap'], 
					'wp_random_bottomright_wrap' => $row['wp_random_bottomright_wrap'], 'wp_random_bottomright_nowrap' => $row['wp_random_bottomright_nowrap'], 'banner_prefix_suffix' => $row['banner_prefix_suffix'], 
					'banner_style_class' => $row['banner_style_class'], 'banner_prefix' => $row['banner_prefix'], 'banner_suffix' => $row['banner_suffix'], 'within_post' => $row['within_post']
					);
			} else {
				$this->zone_banner_arr[$row['id']]['zonedata'] = 
					array('noof_banners' => $row['noof_banners'], $pfx.'_position' => $row[$pfx.'_position'], $pfx.'_position_fixed' => $row[$pfx.'_position_fixed'], 
					$pfx.'_position_random_left' => $row[$pfx.'_position_random_left'], $pfx.'_position_random_center' => $row[$pfx.'_position_random_center'], 
					$pfx.'_position_random_right' => $row[$pfx.'_position_random_right'], $pfx.'_position_custom_prefix' => $row[$pfx.'_position_custom_prefix'], 
					$pfx.'_position_custom_suffix' => $row[$pfx.'_position_custom_suffix'], 'banner_prefix_suffix' => $row['banner_prefix_suffix'], 
					'banner_style_class' => $row['banner_style_class'], 'banner_prefix' => $row['banner_prefix'], 'banner_suffix' => $row['banner_suffix'], 
					'top_of_first_post' => $row['top_of_first_post'], 'bottom_of_last_post' => $row['bottom_of_last_post'], 'as_widget' => $row['as_widget']
					);
				if ( $position == 'aw' )  {
					$this->zone_banner_arr[$row['id']]['zonedata']['aw_title'] = $row['aw_title']; 
				}
			}
			$this->zone_banner_arr[$row['id']]['bannerdata'][$row['banner_id']] = array('url' => $row['url'], 'link' => $row['link'], 'in_new_win' => $row['in_new_win'], 'ad_type' => $row['ad_type'], 'text_ad_code' => $row['text_ad_code'], 'img_tag' => $row['img_tag'], 'follow_link' => $row['follow_link']);
		}
		if ( count($this->zone_banner_inuse_arr) <= 0 ) {
			$this->zone_banner_inuse_arr = $this->zone_banner_arr; // Array used for fetching banners from
		}
		// Get zone/banner properties and display banners
		foreach ( $this->zone_banner_inuse_arr as $zone_id => $banner_arr ) {
			if ( $position == 'tfp' && $banner_arr['zonedata']['top_of_first_post'] != 1 )   return true;
			if ( $position == 'blp' && $banner_arr['zonedata']['bottom_of_last_post'] != 1 ) return true;
			if ( $position == 'wp' && $banner_arr['zonedata']['within_post'] != 1 )          return true;
		
			if ( count($banner_arr['bannerdata']) > 0 && $mban_p != '' ) {
				// Whether to insert banner in this post
				$insert_banners_in_posts = $banner_arr['zonedata']['wp_show_in'];
				if ( $position == 'wp' && strpos($insert_banners_in_posts,'all') == false ) {
					$insert_banners_in_posts_arr = explode(',',$insert_banners_in_posts);
					if ( !in_array($post_number,$insert_banners_in_posts_arr) ) {
						return $post_content;
					}
				}
				// Ensure unique banners in a page
				if ( count($this->usedbanners) > 0 ) {
					foreach ( $banner_arr['bannerdata'] as $ban_id => $ban_data ) {
						$banner_count = count($banner_arr['bannerdata']);
						if ( in_array($ban_id,$this->usedbanners) && ($banner_count > $banner_arr['zonedata']['noof_banners']) ) { 
							unset($banner_arr['bannerdata'][$ban_id]);
						}
					}
				}
				
				// Banner style/properties
				if ( $banner_arr['zonedata']['banner_prefix_suffix'] == 1 ) {
					$banner_style_class = str_replace("\n","",$banner_arr['zonedata']['banner_style_class']);
					if ( trim($banner_style_class) != '' ) $banner_style_class = 'style="'.$banner_style_class.'"';
					else $banner_style_class = '';
					$banner_prefix_gbl  = $banner_arr['zonedata']['banner_prefix'];
					$banner_suffix_gbl  = $banner_arr['zonedata']['banner_suffix'];
				}
				if ( $position == 'wp' ) {
					$align_array = array();
					if ( $banner_arr['zonedata']['wp_position'] == 'random' ) {
						if ( $banner_arr['zonedata']['wp_random_top'] == 1 ) {
							if ( $banner_arr['zonedata']['wp_random_topleft_wrap'] == 1 && $banner_arr['zonedata']['wp_random_topleft'] == 1 )     $align_array['top']['halign']['left'][]  = 'wrap';
							if ( $banner_arr['zonedata']['wp_random_topleft_nowrap'] == 1 && $banner_arr['zonedata']['wp_random_topleft'] == 1 )   $align_array['top']['halign']['left'][]  = 'nowrap';
							if ( $banner_arr['zonedata']['wp_random_topright_wrap'] == 1 && $banner_arr['zonedata']['wp_random_topright'] == 1 )   $align_array['top']['halign']['right'][] = 'wrap';
							if ( $banner_arr['zonedata']['wp_random_topright_nowrap'] == 1 && $banner_arr['zonedata']['wp_random_topright'] == 1 ) $align_array['top']['halign']['right'][] = 'nowrap';
							if ( !is_array($align_array['top']['halign']['left']) && $banner_arr['zonedata']['wp_random_topleft'] == 1 )     $align_array['top']['halign']['left']   = array();
							if ( !is_array($align_array['top']['halign']['center']) && $banner_arr['zonedata']['wp_random_topcenter'] == 1 ) $align_array['top']['halign']['center'] = array();
							if ( !is_array($align_array['top']['halign']['right']) && $banner_arr['zonedata']['wp_random_topright'] == 1 )   $align_array['top']['halign']['right']  = array();
						}
						if ( $banner_arr['zonedata']['wp_random_bottom'] == 1 ) {						  
							if ( $banner_arr['zonedata']['wp_random_bottomleft_wrap'] == 1 && $banner_arr['zonedata']['wp_random_bottomleft'] == 1 )    $align_array['bottom']['halign']['left'][]  = 'wrap';
							if ( $banner_arr['zonedata']['wp_random_bottomleft_nowrap'] == 1 && $banner_arr['zonedata']['wp_random_bottomleft'] == 1 )  $align_array['bottom']['halign']['left'][]  = 'nowrap';
							if ( $banner_arr['zonedata']['wp_random_bottomright_wrap'] == 1 && $banner_arr['zonedata']['wp_random_bottomright'] == 1 )   $align_array['bottom']['halign']['right'][] = 'wrap';
							if ( $banner_arr['zonedata']['wp_random_bottomright_nowrap'] == 1 && $banner_arr['zonedata']['wp_random_bottomright'] == 1 ) $align_array['bottom']['halign']['right'][] = 'nowrap';
							if ( !is_array($align_array['bottom']['halign']['left']) && $banner_arr['zonedata']['wp_random_bottomleft'] == 1 )   $align_array['bottom']['halign']['left']   = array();
							if ( !is_array($align_array['bottom']['halign']['center']) && $banner_arr['zonedata']['wp_random_bottomcenter'] == 1 ) $align_array['bottom']['halign']['center'] = array();
							if ( !is_array($align_array['bottom']['halign']['right']) && $banner_arr['zonedata']['wp_random_bottomright'] == 1 )  $align_array['bottom']['halign']['right']  = array();
						}
						if ( count($align_array) > 0 ) {
							$banner_valign     = array_rand($align_array);
							$banner_valign_arr = $align_array[$banner_valign];
							$banner_halign     = array_rand($banner_valign_arr['halign']);
							$banner_halign_arr = $align_array[$banner_valign]['halign'][$banner_halign];
							$wrap_nowrap       = $banner_halign_arr[array_rand($banner_halign_arr)];
							if ( $wrap_nowrap == 'wrap' ) $wrap = 'float:'.$banner_halign;
						}
					} else { //fixed
						$banner_valign = $banner_arr['zonedata']['wp_position_fixed'];
						if ( $banner_arr['zonedata']['wp_preset_custom'] == 'custom' ) {
							$banner_prefix = $banner_arr['zonedata']['wp_custom_prefix'];
							$banner_suffix = $banner_arr['zonedata']['wp_custom_suffix'];
						} else {
							$banner_halign = $banner_arr['zonedata']['wp_preset_position'];
						}
						if ( $banner_arr['zonedata']['wp_wrap'] == 1 )  $wrap = 'float:'.$banner_halign;
					}
					$banner_style = 'style="padding:5px 0 5px 0; text-align:'.$banner_halign.'; '.$wrap.';"';
					$mban_spc = '&nbsp;';
				} else {
					$mban_img_align = '';
					if ( $banner_arr['zonedata'][$pfx.'_position'] == 'fixed' ) {
						$banner_align = $banner_arr['zonedata'][$pfx.'_position_fixed'];
					} else if ( $banner_arr['zonedata'][$pfx.'_position'] == 'random' ) {
						if ( $banner_arr['zonedata'][$pfx.'_position_random_left'] == 1 )   $banner_align_arr[] = 'left';
						if ( $banner_arr['zonedata'][$pfx.'_position_random_center'] == 1 ) $banner_align_arr[] = 'center';
						if ( $banner_arr['zonedata'][$pfx.'_position_random_right'] == 1 )  $banner_align_arr[] = 'right';
						$rand_key = array_rand($banner_align_arr);
						$banner_align = $banner_align_arr[$rand_key];
					} else if ( $banner_arr['zonedata'][$pfx.'_position'] == 'custom' ) {
						$banner_prefix = $banner_arr['zonedata'][$pfx.'_position_custom_prefix'];
						$banner_suffix = $banner_arr['zonedata'][$pfx.'_position_custom_suffix'];
					} 
					$banner_style = 'style="padding:5px 0 5px 0; text-align:'.$banner_align.'"';
					$mban_spc = '&nbsp;';
				}
				// Eof banner style/properties
	
				if ( $position == 'wp' ) { // randomize banners
					$banner_arr['bannerdata'] = $this->__mbanShuffleArray($banner_arr['bannerdata']);
				}
				if ( trim($banner_prefix_gbl) != '' ) $banner_output .= $banner_prefix_gbl;
				if ( $position == 'aw' && trim($banner_arr['zonedata']['aw_title']) != '' )  {
					$banner_output .= '<h2>'.$banner_arr['zonedata']['aw_title'].'</h2>';
				}
				$banner_output .= '<div '.$banner_style.'>';
				$ban_cnt = 0;
				foreach ( $banner_arr['bannerdata'] as $banner_id => $banner_data ) {
					$ban_cnt++;
					if ( $banner_data['in_new_win'] == 1 ) $target = 'target="_blank"';
					else $target = '';
					if ( $banner_data['follow_link'] == 1 ) $rel = 'rel="follow"';
					else  $rel = 'rel="nofollow"';
					if ( trim($banner_data['img_tag']) != '' ) $img_tag = 'title="'.$banner_data['img_tag'].'"';
					else $img_tag = '';
					if ( $ban_cnt > intval($banner_arr['zonedata']['noof_banners']) ) break;
					$the_link = MBAN_LIBPATH.'include/redirect.php?id='.$banner_id;
					
					if ( trim($banner_prefix) != '' ) $banner_output .= $banner_prefix;
					if ( $banner_data['ad_type'] == 1 ) {
						$banner_output .= '<span '.$banner_style_class.'>'.$banner_data['text_ad_code'].'</span>';
					} else {
						$banner_output .= '<a href="'.$the_link.'" '.$target.' '.$rel.'><img src="'.$banner_data['url'].'" '.$banner_style_class.' '.$img_tag.' /></a>';
					}
					if ( trim($banner_suffix) != '' ) $banner_output .= $banner_suffix;
					
					unset($this->zone_banner_inuse_arr[$zone_id]['bannerdata'][$banner_id]); // remove the used banner from array
					// If the inuse array is out of banners, restore to original. Ensure unique banners in a page
					$banners_in_zone = count($this->zone_banner_inuse_arr[$zone_id]['bannerdata']);
					if ( ($banners_in_zone <= 0) || ($banners_in_zone < $banner_arr['zonedata']['noof_banners']) ) {
						$this->zone_banner_inuse_arr = $this->zone_banner_arr;
					} 
					$this->usedbanners[] = $banner_id; // For counting impressions
				}
				$banner_output .= base64_decode("PGJyIC8+").$mban_spc.${base64_decode("bWJhbl9w")}.$mban_spc.base64_decode("PC9kaXY+");
				if ( trim($banner_suffix_gbl) != '' ) $banner_output .= $banner_suffix_gbl;
			}
		}
		$this->mbanCountImpression();
		if ( $position == 'wp' ) {
			if ( $banner_valign == 'bottom' ) {
				$post_content = $post_content.$banner_output;
			} else {
				$post_content = $banner_output.$post_content;
			}
			return $post_content;
		}
		return $banner_output;
	}
	
	/**
	 * Returns the formatted banner output
	 */
	function __mbanGetBanner($id,$url,$link,$in_new_win,$zone_properties="",$text_ad_code="") {
		if ( !is_array($this->options_global) ) {
			$this->options_global = $this->__mbanGetOptions(); // Get global options
		}
		$clickbank_id = $this->options_global['clickbank_id'];
		$remove_pwd   = $this->options_global['remove_pwd'];
		if ( trim($clickbank_id) == '' ) {
			$clickbank_id = base64_decode("bmljZWFydA==");
		}
		${base64_decode("bWJhbl9w")} = base64_decode("PGZvbnQgc2l6ZT0iMSI+UG93ZXJlZCBieSA8YSBzdHlsZT0iY29sb3I6IzAwMDBmZjtmb250LWZhbWlseTpBcmlhbCxIZWx2ZXRpY2Esc2Fucy1zZXJpZiIgaHJlZj0iaHR0cDovL3d3dy5tYXhibG9ncHJlc3MuY29tL2dvLnBocD9vZmZlcj0=").$clickbank_id.'&pid=12" '.base64_decode("dGFyZ2V0PSJfYmxhbmsiIG9ubW91c2VvdmVyPSJzZWxmLnN0YXR1cz0nTWF4QmxvZ1ByZXNzLmNvbSc7cmV0dXJuIHRydWU7IiBvbm1vdXNlb3V0PSJzZWxmLnN0YXR1cz0nJyI+TWF4IEJhbm5lciBBZHM8L2E+PC9mb250Pg==");
		$mban_spc = '&nbsp;';
		$banner_style = 'style="padding:5px 0 5px 0;"';
		if ( $zone_properties[0] == 1 ) { 
			$banner_style_class = str_replace("\n","",$zone_properties[3]);
			if ( trim($banner_style_class) != '' ) $banner_style_class = 'style="'.$banner_style_class.'"';
			else $banner_style_class = '';
			$banner_prefix_gbl  = $zone_properties[1];
			$banner_suffix_gbl  = $zone_properties[2];
		}
		if ( trim($banner_prefix_gbl) != '' ) $banner_output = $banner_prefix_gbl;
		$banner_output .= '<div '.$banner_style.'>';
		foreach ( (array) $id as $key => $val ) {
			$this->usedbanners[] = $id[$key]; // For counting impressions
			if ( $in_new_win[$key] == 1 ) $target = 'target="_blank"';
			else $target = '';
			$the_link = MBAN_LIBPATH.'include/redirect.php?id='.$id[$key];
			if ( count($text_ad_code) > 0 ) {
				$banner_output .= $text_ad_code[$key];
			} else {
				$banner_output .= '<a href="'.$the_link.'" '.$target.'><img src="'.$url[$key].'" '.$banner_style_class.' /></a>';
			}
		}
		$this->mbanCountImpression();
		$banner_output .= base64_decode("PGJyIC8+").$mban_spc.${base64_decode("bWJhbl9w")}.$mban_spc.base64_decode("PC9kaXY+");
		if ( trim($banner_suffix_gbl) != '' ) $banner_output .= $banner_suffix_gbl;
		return $banner_output;
	}
	
	/**
	 * Searches for zone/banner tags and replaces with corresponding banners
	 */
	function __mbanSearchPostTag($post_content,$type) { 
		if ( $type == 'zone' ) {
			$post_tag = '<!--mba:zone';
			$search = "@(?:<p>)*\s*\<!--MBA:Zone\s*=\s*(\w+|^\+)\-->\s*(?:</p>)*@i";
		} else {
			$post_tag = '<!--mba:banner';
			$search = "@(?:<p>)*\s*\<!--MBA:Banner\s*=\s*(\w+|^\+)\-->\s*(?:</p>)*@i";
		}
		if ( stristr($post_content,$post_tag) ) { 
			if (preg_match_all($search, $post_content, $matches)) {
				if (is_array($matches)) {
					foreach ($matches[1] as $key =>$val) {
						if ( $type == 'zone' ) {
							$sql = "SELECT t2.id, t2.url, t2.link, t2.in_new_win, t1.id as zoneID, t1.noof_banners, t1.banner_prefix_suffix, 
									t2.ad_type, t2.text_ad_code, t1.banner_prefix, t1.banner_suffix, t1.banner_style_class   
									FROM $this->mban_zone_table t1 INNER JOIN $this->mban_banner_table t2 ON t1.id=t2.zoneid 
									WHERE t1.id='$val' AND t1.zone_disable<>'1' AND t2.status='1' 
									ORDER BY RAND()";
						} else {
							$sql = "SELECT id,url,link,in_new_win,ad_type,text_ad_code FROM $this->mban_banner_table WHERE status='1' AND id='$val'";
						}
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
							if ( trim($data['ad_type']) == '1' ) {
								$id[] = $data['id'];
								$text_ad_code[] = $data['text_ad_code'];
							} else {
								$id[]   = $data['id'];
								$url[]  = $data['url'];
								$link[] = $data['link'];
								$in_new_win[] = $data['in_new_win'];
							}
							if ( $type == 'zone' && count($zone_properties) <= 0 ) {
								$zone_properties = array($data['banner_prefix_suffix'],$data['banner_prefix'],$data['banner_suffix'],$data['banner_style_class']);
							}
							if ( $type == 'zone' && $cnt >= $data['noof_banners'] ) break;
						}
						if ( count($id) > 0 ) {
							$search  = $matches[0][$key];
							$replace = $this->__mbanGetBanner($id,$url,$link,$in_new_win,$zone_properties,$text_ad_code);
							$post_content = str_replace($search, $replace, $post_content);
						}
					}	
				}
			}
		}
		return $post_content;
	}

	/**
	 * Carries out all the operations
	 */
	function __mbanOptionsPg() {
		$mban_msg = '';
		$this->mban_request = $_POST['mban'];
		$action = $_GET['action'];
		
		if ( isset($this->mban_request['generate_stats']) ) {
			$this->stats_zone = $this->mban_request['stats_zone'];
			return;
		} else if ( isset($this->mban_request['save_more_options']) ) {
			$loop_number         = intval($this->mban_request['loop_number']);
			$loop_ordinal        = $this->mban_request['loop_ordinal'];
			$clickbank_id        = $this->mban_request['clickbank_id'];
			$remove_pwd          = $this->mban_request['remove_pwd'];
			$stats_default_zone  = $this->mban_request['stats_default_zone'];
			$disable_all_banners = $this->mban_request['disable_all_banners'];
			$options = array('loop_number' => $loop_number, 'loop_ordinal' => $loop_ordinal, 'clickbank_id' => $clickbank_id, 'remove_pwd' => $remove_pwd, 'stats_default_zone' => $stats_default_zone, 'disable_all_banners' => $disable_all_banners);
			$options = serialize($options);
			$sql = "UPDATE $this->mban_options_table SET option_value='$options' WHERE option_name='options_global'";
			$rs = @mysql_query($sql);
			$mban_msg = "Options saved successfully.";
			return $mban_msg;
		} else if ( isset($this->mban_request['addedit_banner']) || isset($this->mban_request['save_banner_adv_opt']) ) {
			$ad_type     = $this->mban_request['ad_type'];
			$name        = $this->mban_request['name'];
			$banner_id   = $this->mban_request['banner_id'];
			$impressions = $this->mban_request['impressions'];
			$zoneid      = $this->mban_request['zoneid'];
			if ( $this->mban_request['banner_disable'] == 1 ) $status = 0;
			else $status = 1;
			if ( $ad_type == 1 ) {
				$text_ad_code = $this->mban_request['text_ad_code'];
			} else {
				$url        = $this->mban_request['url'];
				$img_tag    = $this->mban_request['img_tag'];
				$link       = $this->mban_request['link'];
				$in_new_win = intval($this->mban_request['in_new_win']);
				$follow_link= intval($this->mban_request['follow_link']);
			}
			// Check if banner name already exists
			$sql_chk = "SELECT id FROM $this->mban_banner_table WHERE name='$name' AND zoneid='$zoneid'";
			if ( intval($banner_id) > 0 ) {
				$sql_chk .= " AND id<>'$banner_id'";
			}
			$rs_chk = @mysql_query($sql_chk);
			$already_exists = @mysql_num_rows($rs_chk);
			if ( !$already_exists ) {
				if ( $ad_type == 1 ) { // Text Ad
					if ( intval($this->mban_request['banner_id']) > 0 ) { // Edit
						$sql = "UPDATE $this->mban_banner_table SET zoneid='$zoneid', name='$name', status='$status', ad_type='$ad_type', 
								text_ad_code='$text_ad_code', impressions='$impressions' WHERE id='{$this->mban_request['banner_id']}'";
						$mban_msg .= 'Text Ad "'.stripslashes(htmlspecialchars($name)).'" Edited Successfully';
					} else { // Add
						$sql = "INSERT INTO $this->mban_banner_table (zoneid, name, status, ad_type, text_ad_code) 
								VALUES ('$zoneid', '$name', '$status', '$ad_type', '$text_ad_code')";
						$mban_msg .= 'New Text Ad "'.stripslashes(htmlspecialchars($name)).'" Added Successfully';
					}
					@mysql_query($sql);
					return $mban_msg;
				} else { // Banner Ad
					$upload_err = 0;
					if ( $this->mban_request['url_type'] == 3 ) { // Upload from URL
						$mban_upload_path = $this->__mbanMakeDir();
						$mban_src_url     = trim($this->mban_request['url_live']);
						$mban_src_info    = pathinfo($mban_src_url);
						$mban_src_file    = $mban_src_info['basename'];
						$mban_src_ext     = $mban_src_info['extension'];
						$extension_pos    = strrpos($mban_src_file,'.');
						$filename         = substr($mban_src_file,0,$extension_pos);
						$upload_name      = $filename.'_'.date('YmdHis').'.'.$mban_src_ext;
						if ( $mban_src_ext == 'jpg' || $mban_src_ext == 'gif' || $mban_src_ext == 'png' || $mban_src_ext == 'bmp' ) {
							$mban_dest_url   = $mban_upload_path.'/'.$upload_name;
							$mban_banner_url = MBAN_SITEURL.'/wp-content/'.$this->mban_dir.'/'.$upload_name; 
							if ( ini_get('allow_url_fopen') ) {
								@copy($mban_src_url, $mban_dest_url);
							} else if ( extension_loaded('curl') ) {
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $mban_src_url);
								curl_setopt($ch, CURLOPT_HEADER, false);
								curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								set_time_limit(300); // 5 minutes for PHP
								curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5 minutes for CURL
								$mban_outfile = fopen($mban_dest_url, 'wb');
								curl_setopt($ch, CURLOPT_FILE, $mban_outfile);
								curl_exec($ch);
								fclose($mban_outfile);
								curl_close($ch); 	
							} else {
								$upload_err = 1;
								$mban_msg = "Banner couldn't be uploaded from URL. 'URL file-access' and/or 'CURL' are/is disabled in your server.";
							}
						} else {
							$upload_err = 1;
							$mban_msg = "Banner couldn't be uploaded from URL. Invalid file type";
						}
						if ( $upload_err != 1 ) {
							$url = $mban_banner_url;
							list($banner_width, $banner_height) = @getimagesize($mban_dest_url);
							$mban_msg = "Banner uploaded from URL.\n";
						}
					} else if ( $this->mban_request['url_type'] == 2 ) { // Upload from local computer
						$mban_valid_file  = array("image/pjpeg", "image/png", "image/jpeg", "image/gif", "image/bmp");
						$mban_upload_path = $this->__mbanMakeDir();
						$upload_name      = $_FILES['url_local']['name'];
						$upload_type      = $_FILES['url_local']['type'];
						$upload_size      = $_FILES['url_local']['size'];
						$upload_tmp_name  = $_FILES['url_local']['tmp_name'];
						
						$file_ext_pos     = strrpos($upload_name,'.');
						$filename         = substr($upload_name,0,$file_ext_pos);
						$extension        = substr($upload_name,$file_ext_pos+1);
						$upload_name      = $filename.'_'.date('YmdHis').'.'.$extension;
						$banner_path      = $mban_upload_path.'/'.$upload_name;
						$banner_url       = MBAN_SITEURL.'/wp-content/'.$this->mban_dir.'/'.$upload_name; 
						$url              = $banner_url;
						if ( in_array($upload_type,$mban_valid_file) ) {
							if ( move_uploaded_file($upload_tmp_name, $banner_path) ) {
								list($banner_width, $banner_height) = @getimagesize($banner_path);
								$mban_msg = "Banner uploaded from local computer.\n";
							} else {
								$upload_err = 1;
								$mban_msg = "Banner couldn't be uploaded from local computer.";
							}
						} else {
							$upload_err = 1;
							$mban_msg = "Banner couldn't be uploaded from local computer. Invalid file type.";
						}
					} else { // Direct url
						if ( ini_get('allow_url_fopen') ) list($banner_width, $banner_height) = @getimagesize($url);
					}
					if ( $upload_err != 1) {
						if ( intval($this->mban_request['banner_id']) > 0 ) { // Edit
							if ( intval($banner_width) <= 0 || intval($banner_height) <= 0 ) {
								$banner_width  = $this->mban_request['banner_width'];
								$banner_height = $this->mban_request['banner_height'];
							}
							// If new banner selected, delete previous banner
							if ( trim($this->mban_request['banner_previous']) != trim($url) ) {
								$this->__mbanRemoveBanner($this->mban_request['banner_previous']);
							}
							$sql = "UPDATE $this->mban_banner_table SET zoneid='$zoneid', name='$name', url='$url', link='$link', 
									impressions='$impressions', status='$status', width='$banner_width', height='$banner_height', 
									in_new_win='$in_new_win', ad_type='$ad_type', img_tag='$img_tag', follow_link='$follow_link'   
									WHERE id='{$this->mban_request['banner_id']}'";
							$mban_msg .= 'Banner "'.stripslashes(htmlspecialchars($name)).'" Edited Successfully';
						} else { // Add
							$sql = "INSERT INTO $this->mban_banner_table (zoneid, name, url, link, status, width, height, in_new_win, ad_type, img_tag, follow_link) 
									VALUES ('$zoneid', '$name', '$url', '$link', '$status', '$banner_width', '$banner_height', '$in_new_win', '$ad_type', '$img_tag', '$follow_link')";
							$mban_msg .= 'New Banner "'.stripslashes(htmlspecialchars($name)).'" Added Successfully';
						}
						@mysql_query($sql);
						return $mban_msg;
					}
				}
			} else {
				$mban_msg = 'Duplicate Banner Name "'.stripslashes(htmlspecialchars($this->mban_request['name'])).'"';
			}
		} else if ( isset($this->mban_request['addedit_zone']) ) {
			// Zone Table fields
			$zone_tbl_fields = 'name, top_of_first_post, tfp_position, tfp_position_fixed, tfp_position_random_left,     
				tfp_position_random_center, tfp_position_random_right, tfp_position_custom_prefix, tfp_position_custom_suffix,   
				bottom_of_last_post, blp_position, blp_position_fixed, blp_position_random_left, blp_position_random_center,   
				blp_position_random_right, blp_position_custom_prefix, blp_position_custom_suffix, within_post, wp_show_in,                   
				wp_position, wp_position_fixed, wp_wrap, wp_preset_custom, wp_preset_position,           
				wp_custom_prefix, wp_custom_suffix, wp_random_top, wp_random_topleft, wp_random_topcenter,          
				wp_random_topright, wp_random_middle, wp_random_middleleft, wp_random_middleright, wp_random_bottom,             
				wp_random_bottomleft, wp_random_bottomcenter, wp_random_bottomright, wp_random_topleft_wrap, wp_random_topleft_nowrap,     
				wp_random_topright_wrap, wp_random_topright_nowrap, wp_random_middleleft_wrap, wp_random_middleleft_nowrap, wp_random_middleright_wrap,   
				wp_random_middleright_nowrap, wp_random_bottomleft_wrap, wp_random_bottomleft_nowrap, wp_random_bottomright_wrap, wp_random_bottomright_nowrap, 
				as_widget, aw_position, aw_position_fixed, aw_position_random_left, aw_position_random_center,    
				aw_position_random_right, aw_position_custom_prefix, aw_position_custom_suffix, zone_disable, noof_banners,                 
				banner_prefix_suffix, banner_prefix, banner_suffix, banner_style_class, show_in_pages';			
			$zone_tbl_fields_arr = explode(',', $zone_tbl_fields);
			// Edit Zone
			if ( intval($this->mban_request['zone_id']) > 0 ) {
				foreach ( (array) $zone_tbl_fields_arr as $zfield) {
					$zfield = trim($zfield);
					if ( $zfield == 'wp_show_in' ) {
						$_wp_show_in = $this->__mbanWPShowInPosts();
						$_wp_show_in = ','.$_wp_show_in.',';
						$zone_tbl_fields_values .= $zfield.'='."'".$_wp_show_in."',";
					} else if ( $zfield == 'show_in_pages' ) {
						if ( $this->mban_request['mban_in_all'] )      $show_in_pages  = $this->mban_request['mban_in_all'].',';
						if ( $this->mban_request['mban_in_home'] )     $show_in_pages .= $this->mban_request['mban_in_home'].',';
						if ( $this->mban_request['mban_in_single'] )   $show_in_pages .= $this->mban_request['mban_in_single'].',';
						if ( $this->mban_request['mban_in_category'] ) $show_in_pages .= $this->mban_request['mban_in_category'].',';
						if ( $this->mban_request['mban_in_archive'] )  $show_in_pages .= $this->mban_request['mban_in_archive'].',';
						if ( $this->mban_request['mban_in_search'] )   $show_in_pages .= $this->mban_request['mban_in_search'].',';
						$show_in_pages = ','.$show_in_pages;
						$zone_tbl_fields_values .= $zfield.'='."'".$show_in_pages."',";
					} else {
						if ( $zfield == 'name' || $zfield == 'tfp_position' || $zfield == 'tfp_position_fixed' || $zfield == 'tfp_position_custom_prefix'
						 || $zfield == 'tfp_position_custom_suffix' || $zfield == 'blp_position' || $zfield == 'blp_position_fixed' || $zfield == 'blp_position_custom_prefix'
						 || $zfield == 'blp_position_custom_suffix' || $zfield == 'wp_position' || $zfield == 'wp_position_fixed' || $zfield == 'wp_preset_custom'
						 || $zfield == 'wp_preset_position' || $zfield == 'wp_custom_prefix' || $zfield == 'wp_custom_suffix' || $zfield == 'aw_position'
						 || $zfield == 'aw_position_fixed' || $zfield == 'aw_position_custom_prefix' || $zfield == 'aw_position_custom_suffix' || $zfield == 'aw_title'
						 || $zfield == 'banner_prefix' || $zfield == 'banner_suffix' || $zfield == 'banner_style_class' 
						 ) {
							$zone_tbl_fields_values .= $zfield.'='."'".$this->mban_request[$zfield]."',";
						} else {
							$zone_tbl_fields_values .= $zfield.'='."'".intval($this->mban_request[$zfield])."',";
						}
					}
				}
				$zone_tbl_fields_values = trim($zone_tbl_fields_values, ',');
			} else { // Add New Zone
				foreach ( (array) $zone_tbl_fields_arr as $zfield) {
					$zfield = trim($zfield);
					if ( $zfield == 'wp_show_in' ) {
						$_wp_show_in = $this->__mbanWPShowInPosts();
						$zone_tbl_data .= "',".$_wp_show_in.",',";
					} else if ( $zfield == 'show_in_pages' ) {
						if ( $this->mban_request['mban_in_all'] )      $show_in_pages  = $this->mban_request['mban_in_all'].',';
						if ( $this->mban_request['mban_in_home'] )     $show_in_pages .= $this->mban_request['mban_in_home'].',';
						if ( $this->mban_request['mban_in_single'] )   $show_in_pages .= $this->mban_request['mban_in_single'].',';
						if ( $this->mban_request['mban_in_category'] ) $show_in_pages .= $this->mban_request['mban_in_category'].',';
						if ( $this->mban_request['mban_in_archive'] )  $show_in_pages .= $this->mban_request['mban_in_archive'].',';
						if ( $this->mban_request['mban_in_search'] )   $show_in_pages .= $this->mban_request['mban_in_search'].',';
						$show_in_pages = ','.$show_in_pages;
						$zone_tbl_data .= "',".$show_in_pages.",',";
					} else {
						if ( $zfield == 'name' || $zfield == 'tfp_position' || $zfield == 'tfp_position_fixed' || $zfield == 'tfp_position_custom_prefix'
						 || $zfield == 'tfp_position_custom_suffix' || $zfield == 'blp_position' || $zfield == 'blp_position_fixed' || $zfield == 'blp_position_custom_prefix'
						 || $zfield == 'blp_position_custom_suffix' || $zfield == 'wp_position' || $zfield == 'wp_position_fixed' || $zfield == 'wp_preset_custom'
						 || $zfield == 'wp_preset_position' || $zfield == 'wp_custom_prefix' || $zfield == 'wp_custom_suffix' || $zfield == 'aw_position'
						 || $zfield == 'aw_position_fixed' || $zfield == 'aw_position_custom_prefix' || $zfield == 'aw_position_custom_suffix' || $zfield == 'aw_title'
						 || $zfield == 'banner_prefix' || $zfield == 'banner_suffix' || $zfield == 'banner_style_class' 
						 ) {
							$zone_tbl_data .= "'".$this->mban_request[$zfield]."',";
						} else {
							$zone_tbl_data .= "'".intval($this->mban_request[$zfield])."',";
						}
					}
				}
				$zone_tbl_data = trim($zone_tbl_data, ',');
			}
			// Check if zone name already exists
			$sql_chk = "SELECT id FROM $this->mban_zone_table WHERE name='{$this->mban_request['name']}'";
			if ( intval($this->mban_request['zone_id']) > 0 ) {
				$sql_chk .= " AND id<>'{$this->mban_request['zone_id']}'";
			}
			$rs_chk = @mysql_query($sql_chk);
			$already_exists = @mysql_num_rows($rs_chk);
			if ( !$already_exists ) {
				if ( intval($this->mban_request['zone_id']) > 0 ) { // Edit
					$sql = "UPDATE $this->mban_zone_table SET $zone_tbl_fields_values WHERE id='{$this->mban_request['zone_id']}'";
					$mban_msg = 'Zone "'.stripslashes(htmlspecialchars($this->mban_request['name'])).'" Edited Successfully';
				} else { // Add
					$sql = "INSERT INTO $this->mban_zone_table ({$zone_tbl_fields}) VALUES ($zone_tbl_data)";
					$mban_msg = 'New Zone "'.stripslashes(htmlspecialchars($this->mban_request['name'])).'" Added Successfully';
				}
				@mysql_query($sql);
				return $mban_msg;
			} else {
				$mban_msg = 'Duplicate Zone Name "'.stripslashes(htmlspecialchars($this->mban_request['name'])).'"';
			}
		} 
		
		if ( $action == 'alter_banner_status' ) {
			$banner_id  = $_GET['banner_id'];
			$currstatus = $_GET['currstatus'];
			$status = ($currstatus == 1) ? 0 : 1;
			$sql = "UPDATE $this->mban_banner_table SET status='$status' WHERE id=$banner_id";
			@mysql_query($sql);
			$mban_msg = "Banner Status Altered Successfully.";
		} else if ( $action == 'alter_zone_status' ) {
			$zone_id  = $_GET['zone_id'];
			$currstatus = $_GET['currstatus'];
			$status = ($currstatus == 1) ? 0 : 1;
			$sql = "UPDATE $this->mban_zone_table SET zone_disable='$status' WHERE id=$zone_id";
			@mysql_query($sql);
			$mban_msg = "Zone Status Altered Successfully.";
		} else if ( $action == 'delete_zone' ) {
			$zone_id = $_GET['zone_id'];
			$url_arr = array();
			$sql_1 = "DELETE FROM $this->mban_zone_table WHERE id=$zone_id";
			$sql_2 = "DELETE FROM $this->mban_banner_table WHERE zoneid=$zone_id";
			$sql_3 = "SELECT url FROM $this->mban_banner_table WHERE zoneid=$zone_id";
			$rs = @mysql_query($sql_3);
			while ( $row = @mysql_fetch_assoc($rs) ) {
				$this->__mbanRemoveBanner($row['url']);
			}
			@mysql_query($sql_1);
			@mysql_query($sql_2);
			$mban_msg = "Zone Deleted Successfully.";
		} else if ( $action == 'delete_banner' ) {
			$banner_id = $_GET['banner_id'];
			$sql_1 = "DELETE FROM $this->mban_banner_table WHERE id=$banner_id";
			$sql_2 = "SELECT url FROM $this->mban_banner_table WHERE id=$banner_id";
			$rs = @mysql_query($sql_2);
			$banner_url  = @mysql_result($rs,0,'url');
			$this->__mbanRemoveBanner($banner_url);
			@mysql_query($sql_1);
			$mban_msg = "Banner Deleted Successfully.";
		} else if ( $action == 'reset_zone' ) {
			$zone_id = $_GET['zone_id'];
			$sql_1 = "UPDATE $this->mban_zone_table SET impressions=0, clicks=0 WHERE id=$zone_id";
			$sql_2 = "UPDATE $this->mban_banner_table SET impressions=0, clicks=0 WHERE zoneid=$zone_id";
			@mysql_query($sql_1);
			@mysql_query($sql_2);
			$mban_msg = "Zone Stats Reset Successfully.";
		} else if ( $action == 'reset_banner' ) {
			$banner_id = $_GET['banner_id'];
			$sql = "UPDATE $this->mban_banner_table SET impressions=0, clicks=0 WHERE id=$banner_id";
			@mysql_query($sql);
			$mban_msg = "Banner Stats Reset Successfully.";
		} else if ( $action == 'add_zone' ) {
			$this->mbanAddEditZone($mban_msg);
			exit;
		} else if ( $action == 'edit_zone' ) {
			$this->mbanAddEditZone($mban_msg);
			exit;
		} else if ( $action == 'add_banner' ) {
			$this->mbanAddEditBanner($mban_msg);
			exit;
		} else if ( $action == 'edit_banner' ) {
			$this->mbanAddEditBanner($mban_msg);
			exit;
		} else if ( $action == 'upgrade' ) {
			$this->mbanUpgradePlugin();
			exit;
		}
		return $mban_msg;
	}
	
	/**
	 * Displays zones/banners and the various options available
	 */
	function __mbanShowOptionsPg() {
		$mban_get_vars   = $this->__mbanBuildGetVars('page');
		$zone_arr        = array();
		$banner_arr      = array();
		$zone_banner_arr = array();
		$mban_loop_txt   = "Most of the time you won\'t have to edit this setting. You\'ll need to edit it if you have banner zone which will place the banner at the &quot;top of the first post&quot; or &quot;bottom of the last post&quot;.<br><br>If your banner is not appearing at the &quot;top of the first post&quot; and instead its appearing at sidebar or other unexpected places then you have to edit this setting.<br><br>By default the value is 1 there. Make it 2, save the setting and reload your blog again. If the banner comes at &quot;top of the first post&quot; then its ok. Otherwise you have to change it to 3, then 4 and so on...<br><br>Usually, the value 1 or 2 will work but for most of the blogs. But for some rare blogs you may need to change it to other greater numbers as well.<br><br>You\'ll have to change this setting only once and it will work for all the current and future banner/zone you\'ll create.";
		$mban_cb_txt     = "Enter your ClickBank ID for branding the &quot;Powered by&quot; link with your affiliate link.<br><br>Whenever someone use any of our free plugins they\'ll see an &quot;One Time Offer&quot; and if they buy it then you\'ll get commission for it. Also, your affiliate id will be cookied so if the user went ahead and purchase any other product then you\'ll still receive commission for that.<br><br>You can join our affiliate program by clicking on &quot;Jour our affiliate program&quot; link just beside this icon.";
		
		$tbl_structure_ok    = $this->__mbanCheckTableStructure();
		$options_global      = $this->__mbanGetOptions(); // Get global options
		$zones               = $this->__mbanGetZones(); // Get Zones
		$loop_number         = $options_global['loop_number'];
		$loop_ordinal        = $options_global['loop_ordinal'];
		$clickbank_id        = $options_global['clickbank_id'];
		$remove_pwd          = $options_global['remove_pwd'];
		$stats_default_zone  = $options_global['stats_default_zone'];
		$disable_all_banners = $options_global['disable_all_banners'];
		if ( $remove_pwd == 1 ) $remove_pwd_chk = 'checked';
		if ( $disable_all_banners == 1 ) $disable_all_banners_chk = 'checked';
		
		// Get zone/banner data
		if ( trim($this->stats_zone) != '' ) $stats_zone = $this->stats_zone;
		else $stats_zone = $stats_default_zone;
		if ( $stats_zone != 'none' ) {
			$sql_zone  = "SELECT id, name, zone_disable FROM $this->mban_zone_table";
			if ( intval($stats_zone) > 0 ) $sql_zone .= " WHERE id=$stats_zone";
			$sql_zone .= " ORDER BY id DESC";
			$rs_zone   = @mysql_query($sql_zone);
			if ( $rs_zone ) {
				while ( $row = @mysql_fetch_assoc($rs_zone) ) {
					$zone_arr[] = array($row['id'], $row['name'], $row['zone_disable']);
				}
			}
			$sql_ban = "SELECT * FROM $this->mban_banner_table ORDER BY id DESC";
			$rs_ban  = @mysql_query($sql_ban);
			if ( $rs_ban ) {
				while ( $row = @mysql_fetch_assoc($rs_ban) ) {
					$banner_arr[$row['zoneid']][] = array('banner_id' => $row['id'], 'banner_name' => $row['name'], 'banner_url' => $row['url'], 
													'banner_link' => $row['link'], 'banner_impressions' => $row['impressions'], 'banner_clicks' => $row['clicks'], 
													'banner_status' => $row['status'], 'banner_width' => $row['width'], 'banner_height' => $row['height'], 'ad_type' => $row['ad_type']);
				}
			}
			foreach ( $zone_arr as $zone_data ) {
				$zone_impressions = 0;
				$zone_clicks = 0;
				$zone_banners = $banner_arr[$zone_data[0]];
				if ( $zone_banners == '' ) $zone_banners = array();
				foreach ( $zone_banners as $banner_data ) {
					$zone_impressions += $banner_data['banner_impressions'];
					$zone_clicks += $banner_data['banner_clicks'];
				}
				$zone_banner_arr[] = array('zone_id' => $zone_data[0], 'zone_name' => $zone_data[1], 'zone_disable' => $zone_data[2], 
									'zone_impressions' => $zone_impressions, 'zone_clicks' => $zone_clicks, 'banners' => $zone_banners);
			}
		}
		$this->__mbanHeader();
		
		?>
		<br>
		<table width=100% align=center cellpadding=5 cellspacing=1>
			<tr>
				<td valign=top style="text-align:left">
				<?php require_once('options-pg.php');?>
				</td>
				<td width="27%" rowspan="2" valign="top">
				<!--MBP Support-->
				<?php include_once('mbp-support-pg.php'); ?>
				<!--MBP end Support-->
				</td>
			</tr>
			<tr>
				<td width=73% valign="top">
<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "inline";  
  feedback_widget_options.company = "maxblogpress";
  
  
  feedback_widget_options.style = "idea";
  feedback_widget_options.product = "maxblogpress_max_banner_ads";
  
  
  
  
  feedback_widget_options.limit = "3";
  
  GSFN.feedback_widget.prototype.local_base_url = "http://community.maxblogpress.com";
  GSFN.feedback_widget.prototype.local_ssl_base_url = "http://community.maxblogpress.com";
  

  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>				
				</td>
			</tr>
		</table>
		
		
		<?php
		$this->__mbanFooter();
	}
	
	/**
	 * Interface for Adding/Editing Zone
	 */
	function __mbanAddEditZone() {
		$zone_id = $_GET['zone_id']; 
		$addedit = 'Add New Zone';
		$banner_ps_display = 'none';
		$wp_row_display    = 'none';
		$wp_div_display    = 'none';
		$wp_div_display2   = 'none';
		$as_widget_display = 'none';
		$mban_tfpblp_txt   = "Usually this banner position will work right away without any other setting changes. But for some of the blogs the banner may appear at sidebar or other unexpected places.<br><br>In order to correct this, click on &quot;Max Banner Ads Home&quot; >> More Options<br><br>There change the value for: &quot;Blog content is in the xxx loop&quot;. You will find more information on how to change the setting there.<br><br>You\'ll have to change this setting only once and it will work for all the current and future banner/zone you\'ll create.";
		
		$mban_get_vars = $this->__mbanBuildGetVars('page');
		$row_style_display = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') ? 'block' : 'table-row';
		
		if ( isset($_POST['mban']['addedit_zone']) ) { // Duplicate
			$this->mban_zone_settings = $_POST['mban'];
		} else if ( intval($zone_id) > 0 ) { // Edit
			$sql = "SELECT * FROM $this->mban_zone_table WHERE id='$zone_id'";
			$rs = @mysql_query($sql);
			if ( $rs ) {
				$rowdata = @mysql_fetch_assoc($rs);
				foreach ( $rowdata as $key => $val ) {
					$this->mban_zone_settings[$key] = $val;
				}
			}
		} else { // Add
			$this->mban_zone_settings = $this->default_zone_settings;
		}
		if ( intval($zone_id) > 0 ) $addedit = 'Edit Zone';
		
		// Top of first post
		if ( $this->mban_zone_settings['top_of_first_post'] == 1 ) $top_of_first_post_chk = 'checked';
		$tfp_position_fixed_chk = '';
		$tfp_position_fixed_display = 'none';
		$tfp_position_random_chk = '';
		$tfp_position_random_display = 'none';
		$tfp_position_custom_chk = '';
		$tfp_position_custom_display = 'none';
		if ( $this->mban_zone_settings['tfp_position'] == 'random' ) { 
			$tfp_position_random_chk = 'checked';
			$tfp_position_random_display = $row_style_display;
		} else if ( $this->mban_zone_settings['tfp_position'] == 'custom' ) { 
			$tfp_position_custom_chk = 'checked';
			$tfp_position_custom_display = $row_style_display;
		} else { //fixed
			$tfp_position_fixed_chk = 'checked';
			$tfp_position_fixed_display = $row_style_display;
		} 
		if ( $this->mban_zone_settings['tfp_position_fixed'] == 'left' ) $tfp_position_fixed_left = 'selected';
		else if ( $this->mban_zone_settings['tfp_position_fixed'] == 'right' ) $tfp_position_fixed_right = 'selected';
		else $tfp_position_fixed_center = 'selected';
		if ( $this->mban_zone_settings['tfp_position_random_left'] == 1 ) $tfp_position_random_left_chk = 'checked';
		if ( $this->mban_zone_settings['tfp_position_random_center'] == 1 ) $tfp_position_random_center_chk = 'checked';
		if ( $this->mban_zone_settings['tfp_position_random_right'] == 1 ) $tfp_position_random_right_chk = 'checked';

		// Bottom of last post
		$blp_position_random_display = 'none';
		$blp_position_custom_display = 'none';
		if ( $this->mban_zone_settings['bottom_of_last_post'] == 1 ) $bottom_of_last_post_chk = 'checked';
		
		$blp_position_fixed_chk = '';
		$blp_position_fixed_display = 'none';
		$blp_position_random_chk = '';
		$blp_position_random_display = 'none';
		$blp_position_custom_chk = '';
		$blp_position_custom_display = 'none';
		if ( $this->mban_zone_settings['blp_position'] == 'random' ) { 
			$blp_position_random_chk = 'checked';
			$blp_position_random_display = $row_style_display;
		} else if ( $this->mban_zone_settings['blp_position'] == 'custom' ) { 
			$blp_position_custom_chk = 'checked';
			$blp_position_custom_display = $row_style_display;
		} else { //fixed
			$blp_position_fixed_chk = 'checked';
			$blp_position_fixed_display = $row_style_display;
		}
		if ( $this->mban_zone_settings['blp_position_fixed'] == 'left' ) $blp_position_fixed_left = 'selected';
		else if ( $this->mban_zone_settings['blp_position_fixed'] == 'right' ) $blp_position_fixed_right = 'selected';
		else $blp_position_fixed_center = 'selected';
		if ( $this->mban_zone_settings['blp_position_random_left'] == 1 ) $blp_position_random_left_chk = 'checked';
		if ( $this->mban_zone_settings['blp_position_random_center'] == 1 ) $blp_position_random_center_chk = 'checked';
		if ( $this->mban_zone_settings['blp_position_random_right'] == 1 ) $blp_position_random_right_chk = 'checked';
		
		// Within Post
		$wp_show_in_arr = array();
		$wrap_txt_tooltip = '<img src=&quot;'.MBAN_LIBPATH.'images/wrap-nowrap.jpg&quot;>';
		$wp_show_in_arr = explode(',',$this->mban_zone_settings['wp_show_in']);
		foreach ( $wp_show_in_arr as $val ) {
			if ( $val == 'all' ) {
				$wp_show_in_all_chk = 'checked';
				break;
			}
			$_wp_show_in = 'wp_show_in_'.$val;
			${$_wp_show_in} = 1;
		}
		if ( $this->mban_zone_settings['within_post'] == 1 ) {
			$within_post_chk = 'checked';
			$wp_row_display  = $row_style_display;
			$wp_div_display  = 'block';
			$wp_div_display2 = 'none';
		}
		$wp_position_random_display = 'none';
		if ( $this->mban_zone_settings['wp_position'] == 'random' ) {
			$wp_position_random_chk = 'checked';
			$wp_position_fixed_display = 'none';
			$wp_position_random_display = $row_style_display;
		} else {
			$wp_position_fixed_chk = 'checked';
			$wp_position_fixed_display = $row_style_display;
		}
		if ( $this->mban_zone_settings['wp_position_fixed'] == 'middle' ) $wp_position_fixed_middle = 'selected';
		else if ( $this->mban_zone_settings['wp_position_fixed'] == 'bottom' ) $wp_position_fixed_bottom = 'selected';
		else $wp_position_fixed_top = 'selected';
		if ( $this->mban_zone_settings['wp_wrap'] == 1 ) $wp_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_preset_custom'] == 'custom' ) {
			$wp_custom_chk  = 'checked';
			$wp_custom_show = $row_style_display;
		} else {
			$wp_preset_chk  = 'checked';
			$wp_custom_show = 'none';
		}
		if ( $this->mban_zone_settings['wp_preset_position'] == 'left' ) $wp_preset_position_left = 'selected';
		else if ( $this->mban_zone_settings['wp_preset_position'] == 'center' ) $wp_preset_position_center = 'selected';
		else $wp_preset_position_right = 'selected';
		if ( $this->mban_zone_settings['wp_random_top'] == 1 ) {
			$wp_random_top_chk  = 'checked';
			$wp_random_top_show = $row_style_display;
		} else {
			$wp_random_top_chk  = '';
			$wp_random_top_show = 'none';
		}
		if ( $this->mban_zone_settings['wp_random_middle'] == 1 ) {
			$wp_random_middle_chk  = 'checked';
			$wp_random_middle_show = $row_style_display;
		} else {
			$wp_random_middle_chk  = '';
			$wp_random_middle_show = 'none';
		}
		if ( $this->mban_zone_settings['wp_random_bottom'] == 1 ) {
			$wp_random_bottom_chk  = 'checked';
			$wp_random_bottom_show = $row_style_display;
		} else {
			$wp_random_bottom_chk  = '';
			$wp_random_bottom_show = 'none';
		}
		if ( $this->mban_zone_settings['wp_random_topleft'] == 1 ) $wp_random_topleft_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_topcenter'] == 1 ) $wp_random_topcenter_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_topright'] == 1 ) $wp_random_topright_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_middleleft'] == 1 ) $wp_random_middleleft_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_middleright'] == 1 ) $wp_random_middleright_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomleft'] == 1 ) $wp_random_bottomleft_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomcenter'] == 1 ) $wp_random_bottomcenter_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomright'] == 1 ) $wp_random_bottomright_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_topleft_wrap'] == 1 ) $wp_random_topleft_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_topleft_nowrap'] == 1 ) $wp_random_topleft_nowrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_topright_wrap'] == 1 ) $wp_random_topright_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_topright_nowrap'] == 1 ) $wp_random_topright_nowrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_middleleft_wrap'] == 1 ) $wp_random_middleleft_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_middleleft_nowrap'] == 1 ) $wp_random_middleleft_nowrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_middleright_wrap'] == 1 ) $wp_random_middleright_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_middleright_nowrap'] == 1 ) $wp_random_middleright_nowrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomleft_wrap'] == 1 ) $wp_random_bottomleft_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomleft_nowrap'] == 1 ) $wp_random_bottomleft_nowrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomright_wrap'] == 1 ) $wp_random_bottomright_wrap_chk = 'checked';
		if ( $this->mban_zone_settings['wp_random_bottomright_nowrap'] == 1 ) $wp_random_bottomright_nowrap_chk = 'checked';

		// Show as widget
		if ( $this->mban_zone_settings['as_widget'] == 1 ) {
			$as_widget_chk = 'checked';
		}
		
		// Other options
		if ( $this->mban_zone_settings['zone_disable'] == 1 ) $zone_disable_chk = 'checked';
		if ( strpos($this->mban_zone_settings['show_in_pages'], ',all,') !== false || $this->mban_zone_settings['show_in_pages'] == '' ) {
			$mban_in_all_chk = 'checked';
		} else {
			if ( strpos($this->mban_zone_settings['show_in_pages'], ',hom,') !== false ) $mban_in_home_chk     = 'checked';
			if ( strpos($this->mban_zone_settings['show_in_pages'], ',sin,') !== false ) $mban_in_single_chk   = 'checked';
			if ( strpos($this->mban_zone_settings['show_in_pages'], ',cat,') !== false ) $mban_in_category_chk = 'checked';
			if ( strpos($this->mban_zone_settings['show_in_pages'], ',arc,') !== false ) $mban_in_archive_chk  = 'checked';
			if ( strpos($this->mban_zone_settings['show_in_pages'], ',sea,') !== false ) $mban_in_search_chk   = 'checked';
		}
		if ( $this->mban_zone_settings['banner_prefix_suffix'] == 1 ) {
			$banner_prefix_suffix_chk = 'checked';
			$banner_ps_display = $row_style_display;
		}
		
		$this->__mbanHeader();
		echo '<p><strong><a href="?'.$mban_get_vars.'">'.$this->img_home.' '.MBAN_NAME.' Home</a></strong></p>';
		require_once('addedit-zone.php');
		$this->__mbanFooter();
	}
	
	/**
	 * Interface for Adding/Editing Banner
	 */
	function __mbanAddEditBanner() {
		$banner_id = $_GET['banner_id'];
		$addedit = 'Add New Banner';
		$zone_new_visibility = 'style="visibility:hidden"';
		$row_style_display = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') ? 'block' : 'table-row';
		
		$zone_arr = $this->__mbanGetZones(); // Get Zones
		$mban_get_vars = $this->__mbanBuildGetVars('page');

		if ( isset($_POST['mban']['addedit_banner']) ) { // Duplicate or Error
			$this->mban_banner_settings = $_POST['mban'];
			$zoneid = $this->mban_banner_settings['zoneid'];
		} else if ( intval($banner_id) > 0 ) { // Edit
			$sql = "SELECT * FROM $this->mban_banner_table WHERE id='$banner_id'";
			$rs = @mysql_query($sql);
			if ( $rs ) {
				$rowdata = @mysql_fetch_assoc($rs);
				foreach ( $rowdata as $key => $val ) {
					$this->mban_banner_settings[$key] = $val;
				}
			}
		} else { // Add
			$this->mban_banner_settings = $this->default_zone_settings;
			$this->mban_banner_settings['zone_name'] = '';
			$this->mban_banner_settings['link'] = 'http://';
		}
		if ( intval($banner_id) > 0 ) $addedit = 'Edit Banner';
		if ( $this->mban_banner_settings['status'] == 0 ) $banner_disable_chk = 'checked';
		if ( $this->mban_banner_settings['in_new_win'] == 1 ) $in_new_win_chk = 'checked';
		if ( $this->mban_banner_settings['follow_link'] == 1 ) {
			$follow_link_chk = 'checked';
		} else {
			$follow_link_no_chk = 'checked';
		}
		if ( $this->mban_banner_settings['ad_type'] == 1 ) {
			$mba_text_ad_row_disp = $row_style_display;
			$mba_banner_ad_row_1_disp = 'none';
			$mba_banner_ad_row_2_disp = 'none';
			$mban_cp_code_disp = 'none';
			$ad_type_1_chk = 'checked';
		} else {
			$mba_text_ad_row_disp = 'none';
			$mba_banner_ad_row_1_disp = $row_style_display;
			$mba_banner_ad_row_2_disp = $row_style_display;
			$mban_cp_code_disp = 'block';
			$ad_type_0_chk = 'checked';
		}

		$this->__mbanHeader();
		echo '<p><strong><a href="?'.$mban_get_vars.'">'.$this->img_home.' '.MBAN_NAME.' Home</a></strong></p>';
		require_once('addedit-banner.php');
		$this->__mbanFooter();
	}
	
	/**
	 * Plugin registration form
	 */
	function __mbanRegistrationForm($form_name, $submit_btn_txt='Register', $name, $email, $hide=0, $submit_again='') {
		$plugin_pg    = ($this->wp_version >= 2.7) ? 'tools.php' : 'edit.php';
		$thankyou_url = MBAN_SITEURL.'/wp-admin/'.$plugin_pg.'?page='.$_GET['page'];
		$onlist_url   = MBAN_SITEURL.'/wp-admin/'.$plugin_pg.'?page='.$_GET['page'].'&amp;mbp_onlist=1';
		if ( $hide == 1 ) $align_tbl = 'left';
		else $align_tbl = 'center';
		?>
		
		<?php if ( $submit_again != 1 ) { ?>
		<script><!--
		function trim(str){
			var n = str;
			while ( n.length>0 && n.charAt(0)==' ' ) 
				n = n.substring(1,n.length);
			while( n.length>0 && n.charAt(n.length-1)==' ' )	
				n = n.substring(0,n.length-1);
			return n;
		}
		function __mbanValidateForm_0() {
			var name = document.<?php echo $form_name;?>.name;
			var email = document.<?php echo $form_name;?>.from;
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var err = ''
			if ( trim(name.value) == '' )
				err += '- Name Required\n';
			if ( reg.test(email.value) == false )
				err += '- Valid Email Required\n';
			if ( err != '' ) {
				alert(err);
				return false;
			}
			return true;
		}
		//-->
		</script>
		<?php } 
			$form_action = ($submit_again == 1)?'http://www.maxblogpress.com/plugindoptin/index.php' : 'https://maxblogpress.infusionsoft.com/AddForms/processFormSecure.jsp';		
		?>
		<table align="<?php echo $align_tbl;?>">
		<form name="<?php echo $form_name;?>" method="post" action="<?php echo $form_action;?>" <?php if($submit_again!=1){;?>onsubmit="return __mbanValidateForm_0()"<?php }?>>
		<input value="7b4182a381614627fa085e2012fde837" name="infusion_xid" type="hidden" id="infusion_xid" />
		<input value="CustomFormWeb" name="infusion_type" type="hidden" id="infusion_type" />
		<input value="Max Banner Ads" name="infusion_name" type="hidden" id="infusion_name" />
		<input value="Max Banner Ads" name="Contact0_Plugin" type="hidden" id="Contact0_Plugin" />
		 <input type="hidden" name="Contact0_PluginBlogURL" id="Contact0_PluginBlogURL" value="<?php echo $thankyou_url;?>" />
		 <input type="hidden" name="Contact0_Tracking" id="Contact0_Tracking" value="mba-m" />	
		 <?php if ( $submit_again == 1 ) { ?> 	
		 <input type="hidden" name="submit_again" value="1">
		 <?php } ?>		 
		 <?php if ( $hide == 1 ) { ?> 
		<input value="7b4182a381614627fa085e2012fde837" name="infusion_xid" type="hidden" id="infusion_xid" />
		<input value="CustomFormWeb" name="infusion_type" type="hidden" id="infusion_type" />
		<input value="Max Banner Ads" name="infusion_name" type="hidden" id="infusion_name" />
		<input value="Max Banner Ads" name="Contact0_Plugin" type="hidden" id="Contact0_Plugin" />	 
		 <input type="hidden" name="Contact0Website" id="Contact0Website" value="<?php echo $thankyou_url;?>" />	
		<input type="hidden" id="Contact0FirstName" name="Contact0FirstName" value="<?php echo $name;?>" size="25" maxlength="150" />
		<input type="hidden" id="Contact0Email" name="Contact0Email" value="<?php echo $email;?>" size="25" maxlength="150" />
		 <?php } else { ?>
		 <tr><td>First Name: </td><td><input type="text" id="Contact0FirstName" name="Contact0FirstName" value="<?php echo $name;?>" size="25" maxlength="150" /></td></tr>
		 <tr><td>Email: </td><td><input type="text" id="Contact0Email" name="Contact0Email" value="<?php echo $email;?>" size="25" maxlength="150" /></td></tr>
		 <?php } ?>
		 <tr><td>&nbsp;</td><td><input type="submit" name="submit" value="<?php echo $submit_btn_txt;?>" class="button" /></td></tr>
		 </form>
		</table>
		<?php
	}
	
	/**
	 * Register Plugin - Step 2
	 */
	function __mbanRegisterStep2($form_name='frm2',$name,$email) {
		$msg = 'You have not clicked on the confirmation link yet. A confirmation email has been sent to you again. Please check your email and click on the confirmation link to activate the plugin.';
		if ( trim($_GET['submit_again']) != '' && $msg != '' ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$msg.'</strong></p></div>';
		}
		?>
		<style type="text/css">
		table, tbody, tfoot, thead {
			padding: 8px;
		}
		tr, th, td {
			padding: 0 8px 0 8px;
		}
		</style>
		<div class="wrap"><h2> <?php echo MBAN_NAME.' '.MBAN_VERSION; ?></h2>
		 <center>
		 <table width="100%" cellpadding="3" cellspacing="1" style="border:1px solid #e3e3e3; padding: 8px; background-color:#f1f1f1;">
		 <tr><td align="center">
		 <table width="650" cellpadding="5" cellspacing="1" style="border:1px solid #e9e9e9; padding: 8px; background-color:#ffffff; text-align:left;">
		  <tr><td align="center"><h3>Almost Done....</h3></td></tr>
		  <tr><td><h3>Step 1:</h3></td></tr>
		  <tr><td>A confirmation email has been sent to your email "<?php echo $email;?>". You must click on the link inside the email to activate the plugin.</td></tr>
		  <tr><td><strong>The confirmation email will look like:</strong><br /><img src="http://www.maxblogpress.com/images/activate-plugin-email.jpg" vspace="4" border="0" /></td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td><h3>Step 2:</h3></td></tr>
		  <tr><td>Click on the button below to Verify and Activate the plugin.</td></tr>
		  <tr><td><?php $this->__mbanRegistrationForm($form_name.'_0','Verify and Activate',$name,$email,$hide=1,$submit_again=1);?></td></tr>
		 </table>
		 </td></tr></table><br />
		 <table width="100%" cellpadding="3" cellspacing="1" style="border:1px solid #e3e3e3; padding:8px; background-color:#f1f1f1;">
		 <tr><td align="center">
		 
	<script type="text/javascript">
			function __mbanShowHide(Div, Img) {
				var divCtrl = document.getElementById(Div);
				var Img     = document.getElementById(Img);
				if(divCtrl.style=="" || divCtrl.style.display=="none") {
					divCtrl.style.display = "block";
					Img.src = '<?php echo MBAN_LIBPATH?>images/minus.gif';
				}
				else if(divCtrl.style!="" || divCtrl.style.display=="block") {
					divCtrl.style.display = "none";
					Img.src = '<?php echo MBAN_LIBPATH?>images/plus.gif';
				}
			}		 
		 </script>		 
		 
		 <div align="left" style="padding:10px;"><a style="cursor:hand;cursor:pointer;" onclick="__mbanShowHide('adv_option','adv_img');"><img src="<?php echo MBAN_LIBPATH?>images/plus.gif" id="adv_img" border="0" /><strong>Troubleshooting</strong></a></div>
		 
		  <div id="adv_option" style="display:none">				 
		 <table width="650" cellpadding="5" cellspacing="1" style="border:1px solid #e9e9e9; padding:8px; background-color:#ffffff; text-align:left;">
           <tr><td><h3>Troubleshooting</h3></td></tr>
           <tr><td><strong>The confirmation email is not there in my inbox!</strong></td></tr>
           <tr><td>Dont panic! CHECK THE JUNK, spam or bulk folder of your email.</td></tr>
           <tr><td>&nbsp;</td></tr>
           <tr><td><strong>It's not there in the junk folder either.</strong></td></tr>
           <tr><td>Sometimes the confirmation email takes time to arrive. Please be patient. WAIT FOR 6 HOURS AT MOST. The confirmation email should be there by then.</td></tr>
           <tr><td>&nbsp;</td></tr>
           <tr><td><strong>6 hours and yet no sign of a confirmation email!</strong></td></tr>
           <tr><td>Please register again from below:</td></tr>
           <tr><td><?php $this->__mbanRegistrationForm($form_name,'Register Again',$name,$email,$hide=0,$submit_again=2);?></td></tr>
           <tr><td><strong>Help! Still no confirmation email and I have already registered twice</strong></td></tr>
           <tr><td>Okay, please register again from the form above using a DIFFERENT EMAIL ADDRESS this time.</td></tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
             <td><strong>Why am I receiving an error similar to the one shown below?</strong><br />
                 <img src="http://www.maxblogpress.com/images/no-verification-error.jpg" border="0" vspace="8" /><br />
               You get that kind of error when you click on &quot;Verify and Activate&quot; button or try to register again.<br />
               <br />
               This error means that you have already subscribed but have not yet clicked on the link inside confirmation email. In order to  avoid any spam complain we don't send repeated confirmation emails. If you have not recieved the confirmation email then you need to wait for 12 hours at least before requesting another confirmation email. </td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr><td><strong>But I've still got problems.</strong></td></tr>
           <tr><td>Stay calm. <strong><a href="http://www.maxblogpress.com/contact-us/" target="_blank">Contact us</a></strong> about it and we will get to you ASAP.</td></tr>
         </table>
		 </div>
		 
		 </td></tr></table>
		 </center>		
		<p style="text-align:center;margin-top:3em;"><strong><?php echo MBAN_NAME.' '.MBAN_VERSION; ?> by <a href="http://www.maxblogpress.com/" target="_blank" >MaxBlogPress</a></strong></p>
	    </div>
		<?php
	}

	/**
	 * Register Plugin - Step 1
	 */
	function __mbanRegisterStep1($form_name='frm1',$userdata) {
		$name  = trim($userdata->first_name);
		$email = trim($userdata->user_email);
		?>
		<style type="text/css">
		tabled , tbody, tfoot, thead {
			padding: 8px;
		}
		tr, th, td {
			padding: 0 8px 0 8px;
		}
		</style>
		<div class="wrap"><h2> <?php echo MBAN_NAME.' '.MBAN_VERSION; ?></h2>
		 <center>
		 <table width="100%" cellpadding="3" cellspacing="1" style="border:2px solid #e3e3e3; padding: 8px; background-color:#f1f1f1;">
		  <tr><td align="center">
		    <table width="600" align="center" cellpadding="5" cellspacing="0" style="border:1px solid #e9e9e9; padding: 8px; background-color:#ffffff;">
			  <tr><td align="center"><h3>Please register the plugin to activate it. (Registration is free)</h3></td></tr>
			  <tr><td align="left">In addition you'll also receive complimentary subscription to MaxBlogPress Newsletter (worth $97) which will give you insider tips on how to make more money from your blog as well as how to bring thousands of new visitors to your blog for free..<br /></td></tr>
			  <tr><td align="center"><strong><br />
			    Fill the form below to register the plugin:</strong></td>
			  </tr>
			  <tr><td align="center"><?php $this->__mbanRegistrationForm($form_name,'Register',$name,$email);?></td></tr>
			  <tr><td><font style="font-size:11px"><strong><br />
			    Note:</strong> If you've already registered any of the free MaxBlogPress plugins then simply enter the name/email from which you have registered before. The plugin will activate immediately.</font><br /></td></tr>
			  <tr><td align="center"><br/><font size="1">[ Your contact information will be handled with the strictest confidence <br />and will never be sold or shared with third parties.<strong>Also, you can unsubscribe at anytime.</strong>]</font></td></tr>
		    </table>
		  </td></tr></table>
		 </center>
		<p style="text-align:center;margin-top:3em;"><strong><?php echo MBAN_NAME.' '.MBAN_VERSION; ?> by <a href="http://www.maxblogpress.com/" target="_blank" >MaxBlogPress</a></strong></p>
	    </div>
		<?php
	}
	
} // Eof Class

$MBPBannerAds = new MBPBannerAds();
?>