<script type="text/javascript"><!--
function __mbanShowHideGroup(type,curr) {
	var curr = document.getElementById(curr);
	var showRow = 'block';
	if ( navigator.appName.indexOf('Microsoft') == -1 && curr.tagName == 'TR' ) {
		var showRow = 'table-row';
	}
	if ( type == 'tfp' ) {
		var position_fixed  = document.getElementById('tfp_position_fixed_div');
		var position_random = document.getElementById('tfp_position_random_div');
		var position_custom = document.getElementById('tfp_position_custom_div');
	} else if ( type == 'blp' ) {
		var position_fixed  = document.getElementById('blp_position_fixed_div');
		var position_random = document.getElementById('blp_position_random_div');
		var position_custom = document.getElementById('blp_position_custom_div');
	} else if ( type == 'wp' ) {
		var position_fixed  = document.getElementById('wp_position_fixed_div');
		var position_random = document.getElementById('wp_position_random_div');
	} else if ( type == 'aw' ) {
		var position_fixed  = document.getElementById('aw_position_fixed_div');
		var position_random = document.getElementById('aw_position_random_div');
		var position_custom = document.getElementById('aw_position_custom_div');
	}
	position_fixed.style.display  = 'none';
	position_random.style.display = 'none';
	if ( type != 'wp' ) {
		position_custom.style.display = 'none';
	}
	curr.style.display = showRow;
}
function __mbanShowHideRow(curr,target,outer_div) {
	var target  = document.getElementById(target);
	var showRow = 'block';
	if ( navigator.appName.indexOf('Microsoft') == -1 && target.tagName == 'TR' ) {
		var showRow = 'table-row';
	}
	if ( curr.checked == true ) {
		target.style.display = showRow;
		if ( outer_div != '' ) document.getElementById(outer_div).style.display = 'block';
	} else {
		if ( outer_div != '' ) document.getElementById(outer_div).style.display = 'none';
	    target.style.display = 'none';
	}
}
function __mbanShowHideWP(div1, row, div2) {
	var div1 = document.getElementById(div1);
	var div2 = document.getElementById(div2);
	var row  = document.getElementById(row);
	if ( div1.style == '' || div1.style.display == 'none' ) {
		div1.style.display = 'block';
		div2.style.display = 'block';
	} else if ( div1.style != '' || div1.style.display == 'block' ) { 
		if ( div2.style.display == 'block' ) {
			div2.style.display = 'none';
		} else {
			div2.style.display = 'block';
		}
	}
}
function __mbanDisableOtherPosts(curr) {
	if ( curr.checked == true ) {
		for ( i=1; i<=10; i++ ) {
			document.getElementById('wp_show_in_'+i).checked  = false;
			document.getElementById('wp_show_in_'+i).disabled = true;
		}
	} else {
		for ( i=1; i<=10; i++ ) {
			document.getElementById('wp_show_in_'+i).disabled = false;
		}
	}
}
function __mbanValidateZoneForm() {
	var name = document.getElementById('name');
	var errmsg = '';
	if ( __mbantrim(name.value) == '' ) {
		errmsg = '- Zone Name required\n';
	}
	if ( errmsg != '' ) {
		alert(errmsg);
		return false;
	}
	return true;
}//--></script>
<style type="text/css">
table, tbody, tfoot, thead, tr, th, td {
	padding: 3px;
}
</style>
<script type="text/javascript" src="<?php echo MBAN_LIBPATH;?>include/tooltip.js"></script>
<link href="<?php echo MBAN_LIBPATH;?>include/tooltip.css" rel="stylesheet" type="text/css">
<h3><?php echo $addedit;?> &raquo;</h3>

<form name="add_banner_form2" method="post" onsubmit="return __mbanValidateZoneForm()">
<table cellpadding="3" cellspacing="1" border="0" width="100%" style="border:1px solid #dddddd; background-color:#f1f1f1; padding:0;">
 <tr>
  <td style="background-color:#f1f1f1"><strong>Zone Name:</strong> <input type="text" name="mban[name]" id="name" value="<?php echo $this->mban_zone_settings['name']?>" size="20" maxlength="100" /></td>
 </tr>
 <tr>
  <td style="background-color:#ffffff"><strong>Position:</strong></td>
 </tr>
 <tr>
  <td valign="top">
   <table align="right" cellpadding="5" cellspacing="2" border="0" width="97%" style="border:1px solid #eeeeee; padding:2px">
	 <tr>
	  <td style="background-color:#f1f1f1"><input type="checkbox" name="mban[top_of_first_post]" id="top_of_first_post" value="1" <?php echo $top_of_first_post_chk;?> /> <strong>Top of First Post</strong> (<a style="cursor:hand;cursor:pointer" onclick="__mbanShowHide('tfp_div','','')">Adjust Alignment</a>)
      <a href="#" onMouseover="tooltip('<?php echo $mban_tfpblp_txt;?>',480)" onMouseout="hidetooltip()" style="border-bottom:none;"><img src="<?php echo MBAN_LIBPATH;?>images/help.gif" border="0" align="absmiddle" /></a>
	  <div id="tfp_div" style="display:none">
	  <table cellpadding="3" cellspacing="0" align="right" border="0" width="97%" style="border:1px solid #e5e5e5; background-color:f8f8f8; padding:0;">
	   <tr>
	    <td style="background-color:#f8f8f8"><input type="radio" name="mban[tfp_position]" id="tfp_position" value="fixed" <?php echo $tfp_position_fixed_chk;?> onclick="__mbanShowHideGroup('tfp','tfp_position_fixed_div')" /> 
	      Fixed Alignment</td>
	   </tr>
	   <tr id="tfp_position_fixed_div" style="display:<?php echo $tfp_position_fixed_display;?>">
		<td style="background-color:#f8f8f8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<select name="mban[tfp_position_fixed]" id="tfp_position_fixed">
		 <option value="left" <?php echo $tfp_position_fixed_left;?>>Left</option>
		 <option value="center" <?php echo $tfp_position_fixed_center;?>>Center</option>
		 <option value="right" <?php echo $tfp_position_fixed_right;?>>Right</option>
		</select></td>
	   </tr>
	   <tr>
	    <td style="background-color:#ffffff"><input type="radio" name="mban[tfp_position]" id="tfp_position_random" value="random" <?php echo $tfp_position_random_chk;?> onclick="__mbanShowHideGroup('tfp','tfp_position_random_div')" /> Random</td>
	   </tr>
	   <tr id="tfp_position_random_div" style="display:<?php echo $tfp_position_random_display;?>">
		<td style="background-color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="checkbox" name="mban[tfp_position_random_left]" value="1" id="tfp_position_random" <?php echo $tfp_position_random_left_chk;?>  /> Left &nbsp;&nbsp;&nbsp; 
		<input type="checkbox" name="mban[tfp_position_random_center]" value="1" id="tfp_position_random" <?php echo $tfp_position_random_center_chk;?>  /> Center &nbsp;&nbsp;&nbsp; 
		<input type="checkbox" name="mban[tfp_position_random_right]" value="1" id="tfp_position_random" <?php echo $tfp_position_random_right_chk;?>  /> Right	    </td>
	   </tr>
	   <tr>
	    <td style="background-color:#f8f8f8"><input type="radio" name="mban[tfp_position]" id="tfp_position_custom" value="custom" <?php echo $tfp_position_custom_chk;?> onclick="__mbanShowHideGroup('tfp','tfp_position_custom_div')" /> 
	    Custom </td>
	   </tr>
	   <tr id="tfp_position_custom_div" style="display:<?php echo $tfp_position_custom_display;?>">
		<td style="background-color:#f8f8f8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		Before Code <input type="text" name="mban[tfp_position_custom_prefix]" id="tfp_position_custom_prefix" value="<?php echo $this->mban_zone_settings['tfp_position_custom_prefix']?>" size="20" /> &nbsp;&nbsp; 
		After Code <input type="text" name="mban[tfp_position_custom_suffix]" id="tfp_position_custom_suffix" value="<?php echo $this->mban_zone_settings['tfp_position_custom_suffix']?>" size="20" /></td>
	   </tr>
	  </table>
	  </div></td>
	 </tr>
	 <tr>
	  <td style="background-color:#f1f1f1"><input type="checkbox" name="mban[bottom_of_last_post]" id="bottom_of_last_post" value="1" <?php echo $bottom_of_last_post_chk;?> /> <strong>Bottom of Last Post</strong> (<a style="cursor:hand;cursor:pointer" onclick="__mbanShowHide('blp_div','','')">Adjust Alignment</a>)
      <a href="#" onMouseover="tooltip('<?php echo $mban_tfpblp_txt;?>',480)" onMouseout="hidetooltip()" style="border-bottom:none;"><img src="<?php echo MBAN_LIBPATH;?>images/help.gif" border="0" align="absmiddle" /></a>
	  <div id="blp_div" style="display:none">
	  <table cellpadding="3" cellspacing="0" align="right" border="0" width="97%" style="border:1px solid #e5e5e5; background-color:f8f8f8; padding:0;">
	   <tr>
	    <td style="background-color:#f8f8f8"><input type="radio" name="mban[blp_position]" id="blp_position" value="fixed" <?php echo $blp_position_fixed_chk;?> onclick="__mbanShowHideGroup('blp','blp_position_fixed_div')" /> 
	      Fixed Alignment</td>
	   </tr>
	   <tr id="blp_position_fixed_div" style="display:<?php echo $blp_position_fixed_display;?>">
		<td style="background-color:#f8f8f8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<select name="mban[blp_position_fixed]" id="blp_position_fixed">
		 <option value="left" <?php echo $blp_position_fixed_left;?>>Left</option>
		 <option value="center" <?php echo $blp_position_fixed_center;?>>Center</option>
		 <option value="right" <?php echo $blp_position_fixed_right;?>>Right</option>
		</select> </td>
	   </tr>
	   <tr>
	    <td style="background-color:#ffffff"><input type="radio" name="mban[blp_position]" id="blp_position_random" value="random" <?php echo $blp_position_random_chk;?> onclick="__mbanShowHideGroup('blp','blp_position_random_div')" /> Random</td>
	   </tr>
	   <tr id="blp_position_random_div" style="display:<?php echo $blp_position_random_display;?>">
		<td style="background-color:#ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="checkbox" name="mban[blp_position_random_left]" value="1" id="blp_position_random" <?php echo $blp_position_random_left_chk;?>  /> Left &nbsp;&nbsp;&nbsp; 
		<input type="checkbox" name="mban[blp_position_random_center]" value="1" id="blp_position_random" <?php echo $blp_position_random_center_chk;?>  /> Center &nbsp;&nbsp;&nbsp; 
		<input type="checkbox" name="mban[blp_position_random_right]" value="1" id="blp_position_random" <?php echo $blp_position_random_right_chk;?>  /> Right	    </td>
	   </tr>
	   <tr>
	    <td style="background-color:#f8f8f8"><input type="radio" name="mban[blp_position]" id="blp_position_custom" value="custom" <?php echo $blp_position_custom_chk;?> onclick="__mbanShowHideGroup('blp','blp_position_custom_div')" /> 
	    Custom </td>
	   </tr>
	   <tr id="blp_position_custom_div" style="display:<?php echo $blp_position_custom_display;?>">
		<td style="background-color:#f8f8f8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		Before Code <input type="text" name="mban[blp_position_custom_prefix]" id="blp_position_custom_prefix" value="<?php echo $this->mban_zone_settings['blp_position_custom_prefix']?>" size="20" /> &nbsp;&nbsp; 
		After Code <input type="text" name="mban[blp_position_custom_suffix]" id="blp_position_custom_suffix" value="<?php echo $this->mban_zone_settings['blp_position_custom_suffix']?>" size="20" /></td>
	   </tr>
	  </table>
	  </div></td>
	 </tr>
	 <tr>
	   <td style="background-color:#f1f1f1"><input type="checkbox" name="mban[within_post]" id="within_post" value="1" <?php echo $within_post_chk;?> onclick="__mbanShowHideRow(this,'wp_row','wp_div0');" /> 
	   <strong>Within Post</strong> (<a style="cursor:hand;cursor:pointer" onclick="__mbanShowHideWP('wp_div0','wp_row','wp_div')">Adjust Alignment</a>)
	     <div id="wp_div0" style="display:<?php echo $wp_div_display;?>">
		 <table cellpadding="3" cellspacing="0" align="right" border="0" width="97%" style="border:1px solid #e5e5e5; background-color:#f8f8f8; padding:0;">
		   <tr id="wp_row" style="display:<?php echo $wp_row_display;?>">
	         <td style="background-color:#f8f8f8" width="100%" valign="top">Show in post: 
			 <input type="checkbox" name="mban[wp_show_in_all]" id="wp_show_in_all" value="1" <?php echo $wp_show_in_all_chk;?> onclick="__mbanDisableOtherPosts(this);"> All &nbsp; 
			 <?php 
			 for ( $i=1; $i<=10; $i++ ) { 
			 	$fld_wp_show_in = 'wp_show_in_'.$i;
				$wp_show_in_checked = ($$fld_wp_show_in == 1) ? 'checked' : '';
			    ?>
			    <input type="checkbox" name="mban[wp_show_in_<?php echo $i;?>]" id="wp_show_in_<?php echo $i;?>" value="1" <?php echo $wp_show_in_checked;?>> <?php echo $i;?> &nbsp; 
			 <?php } ?>	</td>
	       </tr>
	       <tr>
	         <td style="background-color:#ffffff" valign="top">
	           <div id="wp_div" style="display:<?php echo $wp_div_display2;?>">
	             <table cellpadding="3" cellspacing="0" border="0" width="100%" style="border:1px solid #eeeeee; padding:0;">
	               <tr>
	                 <td style="background-color:#f8f8f8"><input type="radio" name="mban[wp_position]" id="wp_position" value="fixed" <?php echo $wp_position_fixed_chk;?> onclick="__mbanShowHideGroup('wp','wp_position_fixed_div')" /> Fixed</td>
		           </tr>
	               <tr id="wp_position_fixed_div" style="display:<?php echo $wp_position_fixed_display;?>">
	                 <td style="background-color:#f8f8f8">
					  <table width="98%" align="right" cellpadding="2" cellspacing="0" style="border:1px solid #e8e8e8; background-color:#FDFAF0; padding:0;">
					   <tr>
					    <td colspan="2">Position: 
						<select name="mban[wp_position_fixed]" id="wp_position_fixed">
						 <option value="top" <?php echo $wp_position_fixed_top;?>>Top</option>
						 <!--<option value="middle" <?php echo $wp_position_fixed_middle;?>>Middle</option>-->
						 <option value="bottom" <?php echo $wp_position_fixed_bottom;?>>Bottom</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="mban[wp_wrap]" id="wp_wrap" value="1" <?php echo $wp_wrap_chk;?> /> Wrap Text &nbsp;
					    <a href="#" onMouseover="tooltip('<?php echo $wrap_txt_tooltip;?>',220)" onMouseout="hidetooltip()" style="border-bottom:none;"><img src="<?php echo MBAN_LIBPATH;?>images/help.gif" border="0" align="absmiddle" /></a>
					    </td>
					   </tr>
					   <tr>
					    <td width="32%"><input type="radio" name="mban[wp_preset_custom]" id="wp_preset_align" value="preset" <?php echo $wp_preset_chk;?> onclick="__mbanShowHideRow(document.getElementById('wp_custom'),'wp_custom_row','');" /> Preset Alignment: 
						<select name="mban[wp_preset_position]" id="wp_preset_position">
						 <option value="left" <?php echo $wp_preset_position_left;?>>Left</option>
						 <option value="center" <?php echo $wp_preset_position_center;?>>Center</option>
						 <option value="right" <?php echo $wp_preset_position_right;?>>Right</option>
						</select>
						</td>
					    <td width="68%"><input type="radio" name="mban[wp_preset_custom]" id="wp_custom" value="custom" <?php echo $wp_custom_chk;?> onclick="__mbanShowHideRow(this,'wp_custom_row','');" /> Custom</td>
					   </tr>
					   <tr id="wp_custom_row" style="display:<?php echo $wp_custom_show;?>">
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;
						Before Code <input type="text" name="mban[wp_custom_prefix]" id="wp_custom_prefix" value="<?php echo $this->mban_zone_settings['wp_custom_prefix']?>" style="width:130px;" /> &nbsp;&nbsp; 
						After Code <input type="text" name="mban[wp_custom_suffix]" id="wp_custom_suffix" value="<?php echo $this->mban_zone_settings['wp_custom_suffix']?>" style="width:130px;" /></td>
					   </tr>
					  </table>
					 </td>
		           </tr>
	               <tr>
	                 <td><input type="radio" name="mban[wp_position]" id="wp_position_random" value="random" <?php echo $wp_position_random_chk;?> onclick="__mbanShowHideGroup('wp','wp_position_random_div')" /> Random</td>
		           </tr>
	               <tr id="wp_position_random_div" style="display:<?php echo $wp_position_random_display;?>">
	                 <td>
					  <table width="98%" align="right" cellpadding="4" cellspacing="0" style="border:1px solid #e8e8e8; background-color:#FDFAF0; padding:0;">
					   <tr>
					    <td><input type="checkbox" name="mban[wp_random_top]" value="1" id="wp_random_top" <?php echo $wp_random_top_chk;?> onclick="__mbanShowHideRow(this,'wp_rt','');" /> Top</td>
					   </tr>
					   <tr id="wp_rt" style="display:<?php echo $wp_random_top_show;?>">
					    <td>
						 <table width="97%" align="right" cellpadding="2" cellspacing="0" style="border:1px solid #eeeeee; background-color:#ffffff; padding:0;">
						  <tr>
						   <td width="9%" bgcolor="#ffffff"><input type="checkbox" name="mban[wp_random_topleft]" value="1" id="wp_random_topleft" <?php echo $wp_random_topleft_chk;?> /> Left</td>
						   <td width="19%" bgcolor="#ffffff">
						   <input type="checkbox" name="mban[wp_random_topleft_wrap]" id="wp_random_topleft_wrap" value="1" <?php echo $wp_random_topleft_wrap_chk;?> /> Wrap<br />
						   <input type="checkbox" name="mban[wp_random_topleft_nowrap]" id="wp_random_topleft_nowrap" value="1" <?php echo $wp_random_topleft_nowrap_chk;?> /> No Wrap
						   </td>
						   <td width="18%" bgcolor="#f8f8f8"><input type="checkbox" name="mban[wp_random_topcenter]" value="1" id="wp_random_topcenter" <?php echo $wp_random_topcenter_chk;?> /> Center</td>
						   <td width="10%" bgcolor="#ffffff"><input type="checkbox" name="mban[wp_random_topright]" value="1" id="wp_random_topright" <?php echo $wp_random_topright_chk;?> /> Right</td>
						   <td width="44%" bgcolor="#ffffff">
						   <input type="checkbox" name="mban[wp_random_topright_wrap]" id="wp_random_topright_wrap" value="1" <?php echo $wp_random_topright_wrap_chk;?> /> Wrap<br />
						   <input type="checkbox" name="mban[wp_random_topright_nowrap]" id="wp_random_topright_nowrap" value="1" <?php echo $wp_random_topright_nowrap_chk;?> /> No Wrap
						   </td>
						  </tr>
						 </table>
						</td>
					   </tr>
					   <tr>
					    <td><input type="checkbox" name="mban[wp_random_bottom]" value="1" id="wp_random_bottom" <?php echo $wp_random_bottom_chk;?> onclick="__mbanShowHideRow(this,'wp_rb','');" /> Bottom</td>
					   </tr>
					   <tr id="wp_rb" style="display:<?php echo $wp_random_bottom_show;?>">
					    <td>
						 <table width="97%" align="right" cellpadding="2" cellspacing="0" style="border:1px solid #eeeeee; background-color:#ffffff; padding:0;">
						  <tr>
						   <td width="9%" bgcolor="#ffffff"><input type="checkbox" name="mban[wp_random_bottomleft]" value="1" id="wp_random_bottomleft" <?php echo $wp_random_bottomleft_chk;?> /> Left</td>
						   <td width="19%" bgcolor="#ffffff">
						   <input type="checkbox" name="mban[wp_random_bottomleft_wrap]" id="wp_random_bottomleft_wrap" value="1" <?php echo $wp_random_bottomleft_wrap_chk;?> /> Wrap<br />
						   <input type="checkbox" name="mban[wp_random_bottomleft_nowrap]" id="wp_random_bottomleft_nowrap" value="1" <?php echo $wp_random_bottomleft_nowrap_chk;?> /> No Wrap
						   </td>
						   <td width="18%" bgcolor="#f8f8f8"><input type="checkbox" name="mban[wp_random_bottomcenter]" value="1" id="wp_random_bottomcenter" <?php echo $wp_random_bottomcenter_chk;?> /> Center</td>
						   <td width="10%" bgcolor="#ffffff"><input type="checkbox" name="mban[wp_random_bottomright]" value="1" id="wp_random_bottomright" <?php echo $wp_random_bottomright_chk;?> /> Right</td>
						   <td width="44%" bgcolor="#ffffff">
						   <input type="checkbox" name="mban[wp_random_bottomright_wrap]" id="wp_random_bottomright_wrap" value="1" <?php echo $wp_random_bottomright_wrap_chk;?> /> Wrap<br />
						   <input type="checkbox" name="mban[wp_random_bottomright_nowrap]" id="wp_random_bottomright_nowrap" value="1" <?php echo $wp_random_bottomright_nowrap_chk;?> /> No Wrap
						   </td>
						  </tr>
						 </table>
						</td>
					   </tr>
					  </table>
					 </td>
		           </tr>
	             </table>
		       </div></td>
	       </tr>
         </table>
		 </div></td>
	 </tr>
	 <tr>
	  <td>
	  <input type="hidden" name="mban[aw_position]" value="<?php echo $this->mban_zone_settings['aw_position'];?>" />
	  <input type="hidden" name="mban[aw_position_fixed]" value="<?php echo $this->mban_zone_settings['aw_position_fixed'];?>" />
	  <input type="hidden" name="mban[aw_position_random_left]" value="<?php echo $this->mban_zone_settings['aw_position_random_left'];?>" />
	  <input type="hidden" name="mban[aw_position_random_center]" value="<?php echo $this->mban_zone_settings['aw_position_random_center'];?>" />
	  <input type="hidden" name="mban[aw_position_random_right]" value="<?php echo $this->mban_zone_settings['aw_position_random_right'];?>" />
	  <input type="hidden" name="mban[aw_position_custom_prefix]" value="<?php echo $this->mban_zone_settings['aw_position_custom_prefix'];?>" />
	  <input type="hidden" name="mban[aw_position_custom_suffix]" value="<?php echo $this->mban_zone_settings['aw_position_custom_suffix'];?>" />
	  <input type="checkbox" name="mban[as_widget]" id="as_widget" value="1" <?php echo $as_widget_chk;?> />
	  <strong>Show as Widget</strong> (For easily placing the banner in sidebar)</td>
	 </tr>
   </table>
  </td>
 </tr>
 <?php if ( $zone_id > 0 ) {?>
 <tr>
  <td style="background-color:#ffffff">
  <input type="checkbox" name="mban[zone_disable]" id="zone_disable" value="1" <?php echo $zone_disable_chk;?> /> <strong>Disable</strong>
  </td>
 </tr>
 <?php } ?>
</table>

<h3><a style="cursor:hand;cursor:pointer" onclick="__mbanShowHide('more_option','more_img','<?php echo MBAN_LIBPATH?>');"><img src="<?php echo MBAN_LIBPATH?>images/plus.gif" id="more_img" border="0" /><strong>More Options</strong></a></h3>
<div id="more_option" style="display:none">
<table cellpadding="3" cellspacing="1" border="0" width="100%" style="border:1px solid #dddddd; background-color:#f1f1f1; padding:0;">
 <tr>
  <td style="background-color:#f1f1f1" height="35">
  <strong>Show in:</strong>
  <input type="checkbox" name="mban[mban_in_all]" id="mban_in_all" value="all" <?php echo $mban_in_all_chk;?> /> All Pages &nbsp;&nbsp;
  <input type="checkbox" name="mban[mban_in_home]" id="mban_in_home" value="hom" <?php echo $mban_in_home_chk;?> /> Home Page &nbsp;&nbsp;
  <input type="checkbox" name="mban[mban_in_single]" id="mban_in_single" value="sin" <?php echo $mban_in_single_chk;?> /> Single Post/Page &nbsp;&nbsp;
  <input type="checkbox" name="mban[mban_in_category]" id="mban_in_category" value="cat" <?php echo $mban_in_category_chk;?> /> Category Page &nbsp;&nbsp;
  <input type="checkbox" name="mban[mban_in_archive]" id="mban_in_archive" value="arc" <?php echo $mban_in_archive_chk;?> /> Archive Page &nbsp;&nbsp;
  <input type="checkbox" name="mban[mban_in_search]" id="mban_in_search" value="sea" <?php echo $mban_in_search_chk;?> /> Search Page &nbsp;&nbsp;
  </td>
 </tr>
 <tr>
  <td style="background-color:#ffffff" height="35">Show <input type="text" name="mban[noof_banners]" id="noof_banners" value="<?php echo $this->mban_zone_settings['noof_banners']?>" style="width:25px" maxlength="3" /> Banner(s) at once</td>
 </tr>
 <tr>
  <td style="background-color:#f1f1f1"><input type="checkbox" name="mban[banner_prefix_suffix]" id="banner_prefix_suffix" value="1" <?php echo $banner_prefix_suffix_chk;?> onclick="__mbanShowHide('banner_ps','','')" /> Edit style class, before and after code for banners</td>
 </tr>
 <tr id="banner_ps" style="display:<?php echo $banner_ps_display;?>">
  <td style="background-color:#f1f1f1" valign="top"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Banner Style Class: <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="mban[banner_style_class]" id="banner_style_class" rows="4" cols="35" ><?php echo $this->mban_zone_settings['banner_style_class']?></textarea></p>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Before Code: <input type="text" name="mban[banner_prefix]" id="banner_prefix" value="<?php echo htmlspecialchars($this->mban_zone_settings['banner_prefix']);?>" style="width:180px" /> &nbsp;&nbsp; 
  After Code: <input type="text" name="mban[banner_suffix]" id="banner_suffix" value="<?php echo htmlspecialchars($this->mban_zone_settings['banner_suffix']);?>" style="width:180px" /></p></td>
 </tr>
</table>
</div>

<p>
<input type="hidden" name="mban[zone_id]" value="<?php echo $zone_id;?>" />
<input type="submit" name="mban[addedit_zone]" value="Save" class="button" />
</p>
</form>
</td>
</tr>
</table>