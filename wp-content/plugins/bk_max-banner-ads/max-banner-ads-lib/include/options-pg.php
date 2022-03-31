<script type="text/javascript" src="<?php echo MBAN_LIBPATH;?>include/tooltip.js"></script>
<script type="text/javascript"><!--
function mbanGetOrdinal(number) {
	var the_ordinal;
	var ordinal = document.getElementById('mban_ordinal');
	var loop_ordinal = document.getElementById('loop_ordinal');
	number = parseInt(number.value);
	if ( number % 10 == 1 && number % 100 != 11 ) {
		the_ordinal = 'st';
	} else if ( number % 10 == 2 && number % 100 != 12 ) {
		the_ordinal = 'nd';
	} else if ( number % 10 == 3 && number % 100 != 13 ) {
		the_ordinal = 'rd';
	} else {
		the_ordinal = 'th';
	}
	ordinal.innerHTML = the_ordinal;
	loop_ordinal.value = the_ordinal;
}

/***********************************************
* Drop Down/ Overlapping Content- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
function mbangetposOffset(overlay, offsettype){
	var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
	var parentEl=overlay.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}
function mbanoverlay(curobj, subobjstr, opt_position){
	if (document.getElementById){
		var subobj=document.getElementById(subobjstr)
		subobj.style.display=(subobj.style.display!="block")? "block" : "none"
		var xpos=mbangetposOffset(curobj, "left")+((typeof opt_position!="undefined" && opt_position.indexOf("right")!=-1)? -(subobj.offsetWidth-curobj.offsetWidth) : 0) 
		var ypos=mbangetposOffset(curobj, "top")+((typeof opt_position!="undefined" && opt_position.indexOf("bottom")!=-1)? curobj.offsetHeight : 0)
		subobj.style.left=xpos+"px"
		subobj.style.top=ypos+"px"
		return false
	} else {
		return true
	}
}
function mbanoverlayclose(subobj){
	document.getElementById(subobj).style.display="none"
}//--></script>
<style type="text/css">
table, tbody, tfoot, thead, tr, th, td {
	padding: 3px;
}
</style>
<link href="<?php echo MBAN_LIBPATH;?>include/tooltip.css" rel="stylesheet" type="text/css">
<?php ///if ( !is_writable(MBAN_ABSPATH.'/wp-content/') ) echo '<br><strong>'.$this->img_warning.' <font color="#ff0000">Directory "wp-content" is not writeable. Write permission required for uploading banners.</font></strong>';?>
<?php if ( !$tbl_structure_ok ) echo '<br><strong>'.$this->img_warning.' <font color="#ff0000">Seems like you have upgraded the plugin. Please, deactivate and activate the plugin once.</font></strong><br>';?>
<h3><?php echo $this->img_add;?> <a href="?<?php echo $mban_get_vars;?>action=add_zone">Add New Zone</a></h3>
<table cellspacing="0" cellpadding="3" width="100%" style="border:1px solid #dddddd; background-color:#f1f1f1; padding:0;">
 <form name="mban_stats_form" method="post">
 <tr>
  <td width="6%"><strong>Zone: </strong></td>
  <td width="8%">
	<select name="mban[stats_zone]">
	 <option value="all" <?php if($stats_zone=='all'){print'selected';}?>>All</option>
	 <option value="none" <?php if($stats_zone=='none'){print'selected';}?>>None</option>
	 <?php foreach ( $zones as $zid => $zname ) { 
		if ( $stats_zone == $zid ) $zselected = 'selected';
		else $zselected = '';
		echo '<option value="'.$zid.'" '.$zselected.'>'.$zname.'</option>';
	 } ?>
	</select></td>
  <td width="86%"><input type="submit" name="mban[generate_stats]" class="button" value="Generate Stats &raquo;" /></td>
 </tr>
 </form>
</table>
<br /><br />

<table cellspacing="1" cellpadding="4" width="100%" style="border:1px solid #cccccc; padding:0;">
 <tr>
  <td style="background-color:#14568A" width="21%"><strong><font color="#FFFFFF">Zone/Banner (ID)</font></strong></td>
  <td style="background-color:#14568A" width="30%" align="center"><strong><font color="#FFFFFF">Preview</font></strong></td>
  <td style="background-color:#14568A" width="10%" align="center"><strong><font color="#FFFFFF">Impressions</font></strong></td>
  <td style="background-color:#14568A" width="6%" align="center"><strong><font color="#FFFFFF">Clicks</font></strong></td>
  <td style="background-color:#14568A" width="7%" align="center"><strong><font color="#FFFFFF">CTR (%)</font></strong></td>
  <td style="background-color:#14568A" width="5%" align="center"><strong><font color="#FFFFFF">Status</font></strong></td>
  <td style="background-color:#14568A" width="21%" align="center"><strong><font color="#FFFFFF">Action</font></strong></td>
 </tr>
 <?php
 if ( count($zone_banner_arr) > 0 ) {
	foreach ($zone_banner_arr as $zkey => $zone_ban_data) {
		$bgcol1 = ( $zkey % 2 != 0 ) ? '#83B4D8' : '#83B4D8';
		$zone_impressions = $zone_ban_data['zone_impressions'];
		$zone_clicks = $zone_ban_data['zone_clicks'];
		if ( $zone_ban_data['zone_disable'] != 1 ) $zone_status = $this->img_active;
		else $zone_status = $this->img_inactive;
		if ( $zone_impressions > 0 ) $zone_crt = ($zone_clicks/$zone_impressions)*100;
		else $zone_crt = 0;
		$zone_crt = sprintf("%01.2f", $zone_crt);
		?>
		<tr valign="top">
		 <td style="background-color:<?php echo $bgcol1;?>"><strong><?php echo $zone_ban_data['zone_name'];?> (<?php echo $zone_ban_data['zone_id'];?>)</strong></td>
		 <td style="background-color:<?php echo $bgcol1;?>" align="center">&nbsp;</td>
		 <td style="background-color:<?php echo $bgcol1;?>" align="center"><strong><?php echo $zone_impressions;?></strong></td>
		 <td style="background-color:<?php echo $bgcol1;?>" align="center"><strong><?php echo $zone_clicks;?></strong></td>
		 <td style="background-color:<?php echo $bgcol1;?>" align="center"><strong><?php echo $zone_crt;?></strong></td>
		 <td style="background-color:<?php echo $bgcol1;?>" align="center"><strong><a href="?<?php echo $mban_get_vars;?>action=alter_zone_status&currstatus=<?php echo $zone_ban_data['zone_disable'];?>&zone_id=<?php echo $zone_ban_data['zone_id'];?>" class="mbanimg"><?php echo $zone_status;?></a></strong></td>
		 <td style="background-color:<?php echo $bgcol1;?>" align="center">
		 <a href="?<?php echo $mban_get_vars;?>action=add_banner&zone_id=<?php echo $zone_ban_data['zone_id'];?>" class="mbanimg" title="Add New Banner"><?php echo $this->img_add2;?></a> | 
         <a href="?<?php echo $mban_get_vars;?>action=edit_zone&zone_id=<?php echo $zone_ban_data['zone_id'];?>" class="mbanimg" title="Edit Zone"><?php echo $this->img_edit;?></a> | 
		 <a href="?<?php echo $mban_get_vars;?>action=reset_zone&zone_id=<?php echo $zone_ban_data['zone_id'];?>" onclick="return confirm('The stats of this zone and the banners within it will be reset. Are you sure?');" class="mbanimg" title="Reset Zone Stats"><?php echo $this->img_reset;?></a> | 
		 <a href="?<?php echo $mban_get_vars;?>action=delete_zone&zone_id=<?php echo $zone_ban_data['zone_id'];?>" onclick="return confirm('This zone and the banners within it will be deleted. Are you sure?');" class="mbanimg" title="Delete Zone"><?php echo $this->img_delete;?></a> | 
         <a href="#" onClick="return mbanoverlay(this, 'pop_<?php echo $zone_ban_data['zone_id'];?>', 'rightbottom')" class="mbanimg"><?php echo $this->img_tag;?></a>
         <div id="pop_<?php echo $zone_ban_data['zone_id'];?>" style="position:absolute; border: 4px solid #666666; background-color: white; width: 340px; padding: 8px; display:none">
         <table cellpadding="2" cellspacing="1" style="background-color:#ffffff; padding:0;">
         <tr><td align="right" width="97">Template Tag:</td><td><input type="text" name="tt" id="tt_<?php echo $zone_ban_data['zone_id'];?>" style="width:225px" value="&lt;?php if(function_exists('mba_display_zone')) mba_display_zone(<?php echo $zone_ban_data['zone_id'];?>);?&gt;" onfocus="this.select()"></td></tr>
         <tr><td align="right">Post Tag:</td><td><input type="text" name="pt" id="pt_<?php echo $zone_ban_data['zone_id'];?>" style="width:225px" value="<!--MBA:Zone=<?php echo $zone_ban_data['zone_id'];?>-->" onfocus="this.select()"></td></tr>
         <tr><td colspan="2" align="right"><b>[ <a href="#" onClick="mbanoverlayclose('pop_<?php echo $zone_ban_data['zone_id'];?>'); return false">Close</a> ]</b></td></tr>
         </table>
         </div>
         </td>
	    </tr>
	    <?php
		if ( count($zone_ban_data['banners']) > 0 ) {
			foreach ( $zone_ban_data['banners'] as $key => $banner_data ) {
				$bgcol2 = ( $key % 2 != 0 ) ? '#F5FAFB' : '#FEFEF1';
				$banner_impressions = $banner_data['banner_impressions'];
				$banner_clicks = $banner_data['banner_clicks'];
				$banner_img = $banner_data['banner_url'];
				$banner_width = $banner_data['banner_width'];
				$banner_height = $banner_data['banner_height'];
				if ( $banner_width > $this->banner_width_max ) { 
					$percentage    = ($this->banner_width_max/$banner_width);
					$banner_width  = round($banner_width * $percentage);
					$banner_height = round($banner_height * $percentage);
				}
				if ( $banner_height > $this->banner_height_max ) { 
					$percentage    = ($this->banner_height_max/$banner_height);
					$banner_width  = round($banner_width * $percentage);
					$banner_height = round($banner_height * $percentage);
				}
				if ( $banner_data['banner_status'] == 1 ) $banner_status = $this->img_active;
				else $banner_status = $this->img_inactive;
				
				if ( $banner_data['ad_type'] != 1 )	{
					$banner_preview = '<img src="'.$banner_img.'" width="'.$banner_width.'" height="'.$banner_height.'" border="0">';
					$banner_preview_full = '<img src=&quot;'.$banner_img.'&quot;>';
					if ( $banner_impressions > 0 ) $banner_crt = ($banner_clicks/$banner_impressions)*100;
					else $banner_crt = 0;
					$banner_crt = sprintf("%01.2f", $banner_crt);
				} else {
					$banner_clicks = 'N/A';
					$banner_crt = 'N/A';
				}
				?>
				<tr valign="top">
				 <td style="background-color:<?php echo $bgcol2;?>"><?php echo $this->img_child;?> <?php echo $banner_data['banner_name'];?> (<?php echo $banner_data['banner_id'];?>)</td>
				 <?php if ( $banner_data['ad_type'] != 1 ) { ?>
                   <td style="background-color:<?php echo $bgcol2;?>" align="center"><a href="#" onMouseover="tooltip('<?php echo $banner_preview_full;?>','<?php echo $banner_data['banner_width'];?>')" onMouseout="hidetooltip()" style="border-bottom:none;"><?php echo $banner_preview;?></a></td>
				 <?php } else { ?>
                   <td style="background-color:<?php echo $bgcol2;?>" align="center">N/A</td>
                 <?php } ?>
                 <td style="background-color:<?php echo $bgcol2;?>" align="center"><?php echo $banner_impressions;?></td>
				 <td style="background-color:<?php echo $bgcol2;?>" align="center"><?php echo $banner_clicks;?></td>
				 <td style="background-color:<?php echo $bgcol2;?>" align="center"><?php echo $banner_crt;?></td>
				 <td style="background-color:<?php echo $bgcol2;?>" align="center"><a href="?<?php echo $mban_get_vars;?>action=alter_banner_status&currstatus=<?php echo $banner_data['banner_status'];?>&banner_id=<?php echo $banner_data['banner_id'];?>" class="mbanimg"><?php echo $banner_status;?></a></td>
				 <td style="background-color:<?php echo $bgcol2;?>" align="center">
				 <a href="?<?php echo $mban_get_vars;?>action=edit_banner&banner_id=<?php echo $banner_data['banner_id'];?>" class="mbanimg" title="Edit Banner"><?php echo $this->img_edit;?></a> | 
				 <a href="?<?php echo $mban_get_vars;?>action=reset_banner&banner_id=<?php echo $banner_data['banner_id'];?>" onclick="return confirm('This banner\'s stats will be reset. Are you sure?');" class="mbanimg" title="Reset Banner Stats"><?php echo $this->img_reset;?></a> | 
				 <a href="?<?php echo $mban_get_vars;?>action=delete_banner&banner_id=<?php echo $banner_data['banner_id'];?>" onclick="return confirm('This banner will be deleted. Are you sure?');" class="mbanimg" title="Delete Banner"><?php echo $this->img_delete;?></a> | 
                 <a href="#" onClick="return mbanoverlay(this, 'pop2_<?php echo $banner_data['banner_id'];?>', 'rightbottom')" class="mbanimg"><?php echo $this->img_tag;?></a>
        		 <div id="pop2_<?php echo $banner_data['banner_id'];?>" style="position:absolute; border: 4px solid #666666; background-color: white; width: 340px; padding: 8px; display:none">
                 <table cellpadding="2" cellspacing="1" style="background-color:#ffffff; padding:0;">
                 <tr><td align="right" width="97">Template Tag:</td><td><input type="text" name="tt" id="tt2_<?php echo $banner_data['banner_id'];?>" style="width:225px" value="&lt;?php if(function_exists('mba_display_banner')) mba_display_banner(<?php echo $banner_data['banner_id'];?>);?&gt;" onfocus="this.select()"></td></tr>
                 <tr><td align="right">Post Tag:</td><td><input type="text" name="pt" id="pt2_<?php echo $banner_data['banner_id'];?>" style="width:225px" value="<!--MBA:Banner=<?php echo $banner_data['banner_id'];?>-->" onfocus="this.select()"></td></tr>
                 <tr><td colspan="2" align="right"><b>[ <a href="#" onClick="mbanoverlayclose('pop2_<?php echo $banner_data['banner_id'];?>'); return false">Close</a> ]</b></td></tr>
                 </table>
                 </div>
                 </td>
				</tr>
				<?php
			}
			?>
            <tr valign="top"><td style="background-color:#ffffff" align="center" colspan="7"><font size="3"><b>+</b></font> <a href="?<?php echo $mban_get_vars;?>action=add_banner&zone_id=<?php echo $zone_ban_data['zone_id'];?>">Add More Banners...</a></td></tr>
			<?php 			
		} else { ?>
            <tr valign="top"><td style="background-color:#ffffff" align="center" colspan="7">No Banners Added Yet! <a href="?<?php echo $mban_get_vars;?>action=add_banner&zone_id=<?php echo $zone_ban_data['zone_id'];?>">Add Now...</a></td></tr>
		<?php 
		}
	}
 } else {
    echo '<tr><td colspan="7" align="center">No data found!</td></tr>';
 }
?>
</table><br /><br />

<table cellspacing="1" cellpadding="3" width="100%" style="border:1px solid #dddddd; background-color:#f1f1f1; padding:0;">
 <tr>
  <td>
  <form name="mban_options_form" method="post">
  <h3><a name="mbandv" href="#mbandv" onclick="__mbanShowHide('more_option','more_img','<?php echo MBAN_LIBPATH;?>');"><img src="<?php echo MBAN_LIBPATH?>images/plus.gif" id="more_img" border="0" /><strong>More Options</strong></a></h3>
  <div id="more_option" style="display:none">
  <table cellpadding="5" cellspacing="1" border="0" width="100%" style="border:1px solid #f1f1f1; background-color:#ffffff; padding:0;">
   <tr>
    <td style="background-color:#ffffff;"><strong>Blog content is in the</strong> <input type="text" name="mban[loop_number]" value="<?php echo $loop_number;?>" style="width:20px" maxlength="2" onkeyup="mbanGetOrdinal(this);" /><span id="mban_ordinal"><?php echo $loop_ordinal;?></span> <strong>loop</strong>
    <input type="hidden" name="mban[loop_ordinal]" id="loop_ordinal" value="" />
    <a href="#" onMouseover="tooltip('<?php echo $mban_loop_txt;?>',525)" onMouseout="hidetooltip()" style="border-bottom:none;"><img src="<?php echo MBAN_LIBPATH;?>images/help.gif" border="0" align="absmiddle" /></a></td>
   </tr>
   <tr>
    <td style="background-color:#f8f8f8;"><strong>Stats to show by default: </strong>
    <select name="mban[stats_default_zone]">
	 <option value="all" <?php if($stats_default_zone=='all'){print'selected';}?>>All</option>
	 <option value="none" <?php if($stats_default_zone=='none'){print'selected';}?>>None</option>
	 <?php foreach ( $zones as $zid => $zname ) { 
	 	if ( $zid == $stats_default_zone ) $zselected = 'selected';
		else $zselected = '';
		echo '<option value="'.$zid.'" '.$zselected.'>'.$zname.'</option>';
	 } ?>
    </select></td>
   </tr>
   <tr>
    <td style="background-color:#ffffff;"><strong>Clickbank ID:</strong> <input type="text" name="mban[clickbank_id]" value="<?php echo $clickbank_id;?>" size="12" maxlength="20" /> &nbsp;
    <a href="#" onMouseover="tooltip('<?php echo $mban_cb_txt;?>',270)" onMouseout="hidetooltip()" style="border-bottom:none;"><img src="<?php echo MBAN_LIBPATH;?>images/help.gif" border="0" align="absmiddle" /></a> &nbsp; 
	<a href="http://www.maxblogpress.com/affiliate-signup/" target="_blank">Join our affiliate program</a></td>
   </tr>
   <tr>
    <td style="background-color:#f8f8f8;"><input type="checkbox" name="mban[disable_all_banners]" value="1" <?php echo $disable_all_banners_chk;?> /> <strong>Disable All Banners</strong></td>
   </tr>
   <tr>
    <td style="background-color:#ffffff;"><input type="submit" name="mban[save_more_options]" value="Save" class="button" /></td>
   </tr>
  </table>
  </div>
  </form>
  </td>
 </tr>
</table>