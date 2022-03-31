<?php
$curr_path = dirname( __FILE__ );
$mban_path = str_replace("\\", "/", strstr($curr_path, 'wp-content'));
$count     = substr_count(trim($mban_path, '/'), '/');
if ( $count > 0 )
 for ($i=0; $i<=$count; $i++)
  $_mban_path .= "../";
require_once($_mban_path.'wp-config.php');

$banner_id = $_GET['id'];
$mban_banner_table = $table_prefix.'mban_banner';

$sql = "SELECT link FROM $mban_banner_table WHERE id='$banner_id'";
$rs = mysql_query($sql);
$redirect_url = mysql_result($rs,0,'link');

if ( strpos($redirect_url,'http://') === false && strpos($redirect_url,'https://') === false ) $redirect_url = 'http://'.$redirect_url;

if ( !is_admin() && !is_feed() && !is_user_logged_in() ) {
	$sql = "UPDATE $mban_banner_table SET clicks=clicks+1 WHERE id='$banner_id'";
	mysql_query($sql);
}

header("location: $redirect_url");
die();
?>