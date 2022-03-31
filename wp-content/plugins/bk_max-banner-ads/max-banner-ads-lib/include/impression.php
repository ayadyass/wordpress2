<?php
$curr_path = dirname( __FILE__ );
$mban_path = str_replace("\\", "/", strstr($curr_path, 'wp-content'));
$count     = substr_count(trim($mban_path, '/'), '/');
if ( $count > 0 )
 for ($i=0; $i<=$count; $i++)
  $_mban_path .= "../";
require_once($_mban_path.'wp-config.php');

$mban_banner_table = $table_prefix.'mban_banner';
$banner_ids = $_GET['ids'];
$banner_id_arr = explode('_',$banner_ids);
groupBannerIds($banner_id_arr);

function groupBannerIds($banner_id_arr) {
	global $mban_banner_table;
	$id_arr = array();
	foreach ( (array) $banner_id_arr as $key => $id ) {
		if ( !in_array($id,$id_arr) ) {
			$id_arr[] = $id;
			unset($banner_id_arr[$key]);
		}
	}
	$banner_ids = implode(',',$id_arr);
	$sql = "UPDATE $mban_banner_table SET impressions=impressions+1 WHERE id IN($banner_ids)";
	mysql_query($sql);
	if ( count($banner_id_arr) <= 0 ) exit;
	groupBannerIds($banner_id_arr);
}
exit;
?>