<script type="text/javascript"><!--
function __mbanValidateBannerForm() {
	var errmsg = '';
	var name = document.getElementById('name');
	var zoneid = document.getElementById('zoneid');
	if ( name.value == '' ) errmsg = '- Banner/Ad Name Required.\n';
	if ( document.getElementById('ad_type_1').checked == true ) {
		var text_ad_code = document.getElementById('text_ad_code');
		if ( text_ad_code.value == '' ) errmsg += '- Ad Code Rrequired.\n';
	} else {
		var url = document.getElementById('url');
		var url_local = document.getElementById('url_local');
		var url_live = document.getElementById('url_live');
		if ( url.value == '' && url_local.value == '' && url_live.value == '' ) errmsg += '- Image URL Required.\n';
	}
	if ( zoneid.value == '' || zoneid.value <= 0 ) errmsg += '- Zone Required.\n';
	if ( errmsg != '' ) {
		alert(errmsg); return false;
	}
	return true;
}
function __mbanSwitchAdType(curr) {
	var mba_banner_ad_row_1 = document.getElementById('mba_banner_ad_row_1');
	var mba_banner_ad_row_2 = document.getElementById('mba_banner_ad_row_2');
	var mba_text_ad_row     = document.getElementById('mba_text_ad_row');
	var mban_cp_code        = document.getElementById('mban_cp_code');
	var showRow = 'block';
	if ( navigator.appName.indexOf('Microsoft') == -1 ) {
		var showRow = 'table-row';
	}
	if ( curr.value == 1 ) {
		mba_banner_ad_row_1.style.display = 'none';
		mba_banner_ad_row_2.style.display = 'none';
		mba_text_ad_row.style.display     = showRow;
		mban_cp_code.style.display        = 'none';
	} else {
		mba_banner_ad_row_1.style.display = showRow;
		mba_banner_ad_row_2.style.display = showRow;
		mba_text_ad_row.style.display     = 'none';
		mban_cp_code.style.display        = 'block';
	}
}
function __mbanSwitchType(curr) {
	var mban_type_1  = document.getElementById('mban_type_1');
	var mban_type_2  = document.getElementById('mban_type_2');
	var mban_type_3  = document.getElementById('mban_type_3');
	if ( curr == 1 ) {
		mban_type_1.style.display = 'block';
		mban_type_2.style.display = 'none';
		mban_type_3.style.display = 'none';
	} else if ( curr == 2 ) {
		mban_type_1.style.display = 'none';
		mban_type_2.style.display = 'block';
		mban_type_3.style.display = 'none';
	} else if ( curr == 3 ) {
		mban_type_1.style.display = 'none';
		mban_type_2.style.display = 'none';
		mban_type_3.style.display = 'block';
	}
}
function __mbanExtractImageUrlLink() {
	var banner_code = document.getElementById('banner_code');
	var pattern = /<a\s+[^>]*href\=[\"']*([\w:?=&\/._;-]+)[\"']*[^>]*>[\s]*<img\s+[^>]*src\=[\"']*([\w:?=&\/._;-]+)/i;
	var matches = pattern.exec(banner_code.value);
	document.getElementById('add_ban_div').style.display = 'block';
	if ( matches != null ) {
		document.getElementById('url').value = matches[2];
		document.getElementById('link').value = matches[1];
	}
}//--></script>
<style type="text/css">
table, tbody, tfoot, thead, tr, th, td {
	padding: 3px;
}
</style>
<h3><?php echo $addedit;?> &raquo;</h3>
<form name="add_banner_form" method="post" onSubmit="return __mbanValidateBannerForm()" enctype="multipart/form-data">
<div style="background-color:#f1f1f1;padding:6px 2px 6px 2px;border:1px solid #e5e5e5">
<input type="radio" name="mban[ad_type]" id="ad_type_0" value="0" onClick="__mbanSwitchAdType(this)" <?php echo $ad_type_0_chk;?> /> <strong>Banner Ads</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="mban[ad_type]" id="ad_type_1" value="1" onClick="__mbanSwitchAdType(this)" <?php echo $ad_type_1_chk;?> /> <strong>Other Text Ads/Flash/Javascript (Adsense, Adbrite etc...)</strong>
</div><br />
<div id="mban_cp_code" style="display:<?php echo $mban_cp_code_disp;?>">
    <strong><a style="cursor:hand;cursor:pointer" onClick="__mbanShowHide('add_ban_div','add_ban_img','<?php echo MBAN_LIBPATH?>');"><img src="<?php echo MBAN_LIBPATH?>images/plus.gif" id="add_ban_img" border="0" /><strong>Fill Image URL and Link from Copy and paste code</strong></a></strong><br /><br />
    <div id="add_ban_div" style="display:none">
    <table border="0" width="100%" style="border:1px solid #dddddd; background-color:#f1f1f1; padding:0;">
     <tr>
      <td><textarea name="mban[banner_code]" id="banner_code" rows="4" cols="70"></textarea></td>
     </tr>
     <tr>
      <td><input type="button" name="mban[extract_img_link]" value="Extract and Fill Image URL and Link" onClick="__mbanExtractImageUrlLink()" class="button" /></td>
     </tr>
    </table><br />
    </div>
</div>
<table border="0" cellspacing="1" cellpadding="6" width="100%" style="border:1px solid #dddddd; background-color:#f1f1f1; padding:0;">
 <tr>
  <td style="background-color:#f1f1f1" width="110"><strong>Banner Name:</strong></td>
  <td style="background-color:#f1f1f1"><input type="text" name="mban[name]" id="name" value="<?php echo $this->mban_banner_settings['name']?>" size="20" maxlength="100" /> (Visible to you only)</td>
 </tr>
 <tr id="mba_banner_ad_row_1" style="display: <?php echo $mba_banner_ad_row_1_disp;?>">
  <td style="background-color:#ffffff" width="110"><strong>Image URL:</strong></td>
  <td style="background-color:#ffffff">
    <table border="0" width="100%" cellpadding="1" cellspacing="1">
      <tr>
       <td>
       <input type="radio" name="mban[url_type]" id="url_type_1" value="1" <?php echo 'checked';?> onClick="__mbanSwitchType(1)" /> 
       Banner URL &nbsp;    
       <input type="radio" name="mban[url_type]" id="url_type_2" value="2" onClick="__mbanSwitchType(2)" /> Upload Banner From My Computer &nbsp;     
       <input type="radio" name="mban[url_type]" id="url_type_3" value="3" onClick="__mbanSwitchType(3)" /> Upload From URL&nbsp;       </td>
      </tr>
      <tr>
       <td>
        <table width="100%" border="0">
         <tr>
          <td id="mban_type_1" style="display:block">
          <input type="text" name="mban[url]" id="url" value="<?php echo $this->mban_banner_settings['url']?>" size="60"></td>
          <td id="mban_type_2" style="display:none">
          <input type="file" name="url_local" id="url_local" value="" size="35"></td>
          <td id="mban_type_3" style="display:none">
          <input type="text" name="mban[url_live]" id="url_live" value="" size="60"></td>
         </tr>
        </table></td>
      </tr>
    </table></td>
 </tr>
 <tr id="mba_banner_ad_row_2" style="display: <?php echo $mba_banner_ad_row_2_disp;?>">
  <td style="background-color:#f1f1f1" width="110"><strong>Link:</strong></td>
  <td style="background-color:#f1f1f1"><input type="text" name="mban[link]" id="link" value="<?php echo $this->mban_banner_settings['link']?>" size="60" maxlength="250" /> &nbsp;&nbsp; 
  <input type="checkbox" name="mban[in_new_win]" id="in_new_win" value="1" <?php echo $in_new_win_chk;?> /> Open in new window</td>
 </tr>
 <tr id="mba_text_ad_row" style="display: <?php echo $mba_text_ad_row_disp;?>">
  <td style="background-color:#f8f8f8" width="110"><strong>Javascript/Text Ad Code:</strong></td>
  <td style="background-color:#f8f8f8"><textarea name="mban[text_ad_code]" id="text_ad_code" rows="10" cols="60" ><?php echo $this->mban_banner_settings['text_ad_code']?></textarea></td>
 </tr>
 <tr>
  <td style="background-color:#ffffff"><strong>Zone:</strong></td>
  <td style="background-color:#ffffff">
  <select name="mban[zoneid]" id="zoneid">
   <?php foreach ( $zone_arr as $zid => $zname ) { 
        if ( $zid == $zoneid ) $zselected = 'selected'; //Duplicate
        else if ( $_GET['zone_id'] == $zid ) $zselected = 'selected'; //Add (zone id given)
        else if ( strtolower($zname) == 'default' && !$_GET['zone_id'] && $zoneid == '' && $banner_id == '' ) $zselected = 'selected'; //Add
        else if ( $banner_id != '' && $zid == $this->mban_banner_settings['zoneid'] ) $zselected = 'selected'; //Edit
        else $zselected = '';
        echo '<option value="'.$zid.'" '.$zselected.'>'.$zname.'</option>';
   }?>
  </select></td>
 </tr>
 <?php if ( intval($banner_id) > 0 ) { ?>
 <tr>
  <td style="background-color:#f1f1f1"><strong>Impression:</strong></td>
  <td style="background-color:#f1f1f1"><input type="text" name="mban[impressions]" id="impressions" value="<?php echo $this->mban_banner_settings['impressions']?>" size="10" maxlength="9" /></td>
 </tr>
 <tr>
  <td style="background-color:#ffffff" colspan="2"><input type="checkbox" name="mban[banner_disable]" value="1" <?php echo $banner_disable_chk;?> /> <strong>Disable</strong></td>
 </tr>
 <?php } ?>
 <tr>
  <td style="background-color:#f1f1f1" colspan="2">
  <input type="hidden" name="mban[banner_id]" value="<?php echo $banner_id;?>" />
  <input type="hidden" name="mban[banner_width]" value="<?php echo $this->mban_banner_settings['width'];?>" />
  <input type="hidden" name="mban[banner_height]" value="<?php echo $this->mban_banner_settings['height'];?>" />
  <input type="hidden" name="mban[banner_previous]" value="<?php echo $this->mban_banner_settings['url'];?>" />
  <input type="submit" name="mban[addedit_banner]" value="Save" class="button" /></td>
 </tr>
</table>
<br />
<div id="mban_cp_code" style="display:<?php echo $mban_cp_code_disp;?>">
    <h3><a style="cursor:hand;cursor:pointer" onClick="__mbanShowHide('mban_adv_opt','mban_adv_opt_img','<?php echo MBAN_LIBPATH?>');"><img src="<?php echo MBAN_LIBPATH?>images/plus.gif" id="mban_adv_opt_img" border="0" /><strong>Advanced Options (Optional)</strong></a></h3>
    <div id="mban_adv_opt" style="display:none">
    <table border="0" cellpadding="6" cellspacing="1" width="100%" style="border:1px solid #dddddd; background-color:#ffffff; padding:0;">
     <tr>
      <td style="background-color:#f1f1f1" width="130"><strong>Image Tag/Title:</strong></td>
	  <td style="background-color:#f1f1f1"><input type="text" name="mban[img_tag]" id="img_tag" value="<?php echo $this->mban_banner_settings['img_tag'];?>" size="35" maxlength="200"></td>
     </tr>
     <tr>
      <td style="background-color:#ffffff"><strong>Make Link:</strong></td>
	  <td style="background-color:#ffffff"><input type="radio" name="mban[follow_link]" id="follow_link" value="1" <?php echo $follow_link_chk;?> /> Follow &nbsp; 
	  <input type="radio" name="mban[follow_link]" id="follow_link_no" value="0" <?php echo $follow_link_no_chk;?> /> No Follow </td>
     </tr>
     <tr>
      <td style="background-color:#f1f1f1" colspan="2"><input type="submit" name="mban[save_banner_adv_opt]" value="Save All" class="button" /></td>
     </tr>
    </table><br />
    </div>
</div>
</form>