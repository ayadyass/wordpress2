<?php
/*
Plugin Name: WordpressPDF
Plugin URI: http://rusterra.com/wordpresspdf/
Description: Embed PDF into your Wordpress Blog. Includes GPL Zviewer. Usage: <code>[wp-pdf-view swf='/source_swf.swf' /]</code>
Version: 0.6.4
Author: Digitalist 
Author URI: http://rusterra.com/wordpresspdf
*/

 
class wp_pdf_view
{
	var $plugin_folder ='wordpresspdf';
	var $version="0.1";
	var $user_attr ;
	var $update_result='';
	
	var $admin_setting_menu='&#8226;WordpressPDF';
	var $admin_setting_title='WordpressPDF Default Configuration';
	var $plugin_url;

	//when new player is added , add to below two arrays
	var $player_used= array('1'=> 0);
	var $player_base= array('1'=>'zviewer');
   
	var $default_attr=array(
						'player'=>'1',  // 1 : zviewer
						'width'=>'500',
						'height'=>'400'
						);
						
	function wp_pdf_view() {
		$this->user_attr = get_option('wppdf_options');
		
		if (! $this->user_attr) 
			$this->user_attr = $this->default_attr;
		
			
		$this->plugin_url=get_bloginfo("wpurl") . "/wp-content/plugins/$this->plugin_folder";
		
	}

	function bind_hooks() {

		// third arg should be large enough . If executed early in the filter chain, so we do not see <br />
		add_filter('the_content', array(&$this,'wp_pdf_return') , 1);
		add_action('admin_menu' , array(&$this,'wp_pdf_admin_menu') );
		add_filter('the_excerpt', array(&$this,'wp_pdf_return_excerpt') , 1);
		
		// init process for button control
		add_action('init', array(&$this,'wp_pdf_addbuttons'));
		add_action('admin_print_scripts',array(&$this,'admin_javascript'));
		add_action('admin_footer',array(&$this,'admin_footer'));
	}
	
	function wp_pdf_return($content) {
		if (is_feed() ){
			return preg_replace('|\[wp-pdf-view(.*?)/\]|ims', '', $content);
		}
		return preg_replace_callback('|\[wp-pdf-view(.*?)/\]|ims', array(&$this,'wp_pdf_callback'), $content);
		
	}
	
  	function wp_pdf_return_excerpt($content) {
		if (is_feed() ){
			return preg_replace('|\[wp-pdf-view(.*?)/\]|ims', '', $content);
		}
		return preg_replace_callback('|\[wp-pdf-view(.*?)/\]|ims', array(&$this,'wp_pdf_callback'), get_the_content());
		
	}
	function wp_pdf_admin_menu() {
		if ( function_exists('add_options_page') ) {
			add_options_page($this->admin_setting_title,$this->admin_setting_menu, 1, __FILE__,array(&$this,'wp_pdf_options_page'));

		}
	}
	
	function wp_pdf_callback($arg) {

		//print($arg[1]);
		$attr_array=$this->parse_attributes($arg[1]);
	
		
	
		$flv_attr=array();
		$div_attr=array();
		
		$key_list = array_keys($attr_array);
		
		foreach ($key_list as $key ) {
			$flv_attr[$key]=$attr_array[$key];
		}
		
		reset($flv_attr);
		while(list($key,$value) = each($flv_attr)){
			if ($key != 'swf' && $key != 'clickurl' && $key !='splashimage' && $key != 'more_2' && $key != 'more_3' )
				$flv_attr[$key] = strtolower($value);
		}
		
		if (! array_key_exists('player',$flv_attr)){
			$flv_attr['player']=$this->user_attr['player'];
		}
	    if (! array_key_exists('width',$flv_attr)){
			$flv_attr['width']=$this->user_attr['width'];
	    }
		if (! array_key_exists('height',$flv_attr)){
			$flv_attr['height']=$this->user_attr['height'];
	    }
	
	    if (! array_key_exists('swf',$flv_attr)){
			
	    	return '<div style="color:#f00;font-weight:bold;">[wp-pdf-view] : "swf" attribute is missing for the swf file\'s URL.</div>'."\n".'<!-- '. $arg[1] .'-->';	
	    }
	    
	   
	    $div_attr_string = $this->construct_attributes($div_attr);
	 
	    $player=$flv_attr['player'];


//wpZviewer
	    if ($player == '1' ) {
		//$flv_attr['width']=500;
		//$flv_attr['height']=400;
		$this->player_used[$player] += 1;
		$playerbase=$this->plugin_url."/".$this->player_base[$player];
		$playerf=$playerbase."/zviewer.swf";
		$zviewer_id = 'wp_pdf_zviewer_' . $this->player_used[$player]; 
		$output.="<script type='text/javascript' src='".$playerbase."/swfobject/swfobject.js'></script>
	
<script type='text/javascript'>
var flashvars = {
	doc_url: '".$flv_attr['swf']."'
};
var params = {
menu: 'false',
bgcolor: '#efefef',
allowFullScreen: 'true'
};
var attributes = {
id: '".$zviewer_id."'
};swfobject.embedSWF('".$playerf."?r=11', '".$zviewer_id."', '".$flv_attr['width']."', '".$flv_attr['height']."', '9.0.45','swfobject/expressinstall.swf', flashvars, params, attributes);
</script>

<div id='".$zviewer_id."'>
<p align='center' class='style1'>In order to view this page you need Flash Player 9+ support!</p>
<p align='center'>
<a href='http://www.adobe.com/go/getflashplayer'>
<img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a></p>
</div>";
}
//	wpZviewer end

    	return  $output;

    }
	

    
	function wp_pdf_options_page() {

		//global  $_POST;
		if ( $this->update_result != '' ) 
			print '<div id="message" class="updated fade"><p>' . $this->update_result . '</p></div>';
	?>
<div class="wrap">
	<h2>Configuration for WordpressPDF V<?php echo $this->version; ?></h2>
	<p>
	Embed the pdf in your WordPress Blog. 
	Uses Zviewer (other viewers may be added).
	GPL.
    </p>
    <p>
	You can place a specific tag element <code>[wp-pdf-view]</code> in the article where you want to show. The 'swf' attribute is mandatory. There are other optional attributes. 
	Default values for the options can be defined in this pages. See the <a href="#example">bottom of the page</a> for the example.
    </p>		

 	
	<hr size='1'>
	
	<h3>Default Settings</h3>
	<form action="" method="post">
	<fieldset  class="options">
	<table id="optiontable" class="editform">
		<tr>
			<th valign="top">Default Player:</th>
			<td><select name="wppdf_player">
			<option value="1" <?php if ($this->user_attr['player'] == '1' ) print "selected"; ?> >1. zviewer</option>
			</select>
			</td>
		</tr>
		<tr>
			<th valign="top">Default Width</th>
			<td><input type='text' name="wppdf_width" value="<?php print $this->user_attr['width'];?>" size='4' maxlength='4'> 
			</td>
		</tr>
		<tr>
			<th valign="top">Default Height</th>
			<td><input type='text' name="wppdf_height" value="<?php print $this->user_attr['height'];?>" size='4' maxlength='4'> 
			</td>
		</tr>
		
	</table>
	<p class="submit"><input name="submit" value="Update Options &raquo;" type="submit"></p>
	</fieldset>
	</form>

<hr size='1'>
<a name="example" ></a>
   <p>
	<h3>Usage Example:</h3>
	<pre style="padding: 10px; border:1px dotted black">
[wp-pdf-view 
    swf="<?php print $this->plugin_url; ?>/test.swf"
    width="500"
    height="400"
  
/]</pre>
<p>When you defined any attribute, please make sure that you use single or double quotes around the attribute value, or my plugin may not recognize the attribute. 
</p>

	Attributes explained:
	<ul>
		<li><strong>swf</strong>: URL of the swf file. This is mandatory.</li>
		<li><strong>width</strong>: Width of the Flash player.</li>
		<li><strong>height</strong>: Height of the Flash player.</li>
		
	</ul>

    
    <div><u><strong>Note:</strong> Be careful when you use other website's swf file as the swf source. Since swf files are usually large is size they can use up the bandwidth quickly. 
    So you should ask for the owner's permission before using that link to the file.</u></div>
	</p>
    <p>Thank you for using my plugin. - <a href='http://wwww.rusterra.com/wordpresspdf'>digitalist</a></p>
 
<!-- script type="text/javascript" src="http://neox.net/plugin_news.php?id=wp-pdf-view"> < script -->
    
</div>

<?php

	}

	function wp_pdf_options_update(){
		
		if ( isset($_POST['wppdf_player']) ) {
			if ( is_numeric($_POST['wppdf_player']) ){
				$this->user_attr['player'] = $_POST['wppdf_player'];
			}
		}

		if ( isset($_POST['wppdf_width']) ) {
			if ( is_numeric($_POST['wppdf_width']) )
				$this->user_attr['width'] = $_POST['wppdf_width'];
		}
		
		if ( isset($_POST['wppdf_height']) ) {
			if ( is_numeric($_POST['wppdf_height']) )
				$this->user_attr['height'] = $_POST['wppdf_height'];
		}
		
	
		//print_r ($this->user_attr);
		
		update_option('wppdf_options',$this->user_attr);
		//$this->user_attr = get_option('wppdf_options');
		
		$this->update_result="Settings are updated";
		
	}
    	

    //Support function-----------------------------------------------------

    
    function parse_attributes($attrib_string){

		//first str_replace \n => ' '
		// new line are already stored as <br \> , so need to convert to space
		$search_arr = array("\n","<br />","\t");
	    $replace_arr = array(" "," "," ");	
		$attrib_string = str_replace($search_arr,$replace_arr,$attrib_string);
	
		//print ($attrib_string);	
		
	    $regex='@([^\s=]+)\s*=\s*(\'[^<\']*\'|"[^<"]*"|\S*)@';
		
	    preg_match_all($regex, $attrib_string, $matches);
	
		$attr=array();
	
		//print_r($matches);
		for ($i=0; $i< count($matches[0]); $i++) {
	  		if ( ! empty($matches[0][$i]) && ! empty($matches[1][$i]))  {
				
	  			
	  			if (preg_match("/^'(.*)'$/",$matches[2][$i],$vmatch)) {
					$value=$vmatch[1];	
				}else 
				if (preg_match('/^"(.*)"$/',$matches[2][$i],$vmatch)) {
					$value=$vmatch[1];	
				}else{
					$value=$matches[2][$i];
				}
				$key=strtolower($matches[1][$i]);
				$attr[$key]= $value ;
				
			}
		}
	   
		//print "<pre>";
		//print_r($attr);
		//print "</pre>"; 
		return $attr;
		
	}
	
	function construct_attributes($arr){
	
		$output="";
		
		reset($arr);
		while (list($key, $value) = each ($arr)) {
			$envelop_char='"';
			
			if (strstr($value,'"') !== false) {
				
				$envelop_char='\'';			
			}
			$output .= " $key=".$envelop_char.$value.$envelop_char;
		}
		
		return $output;
	}
	
    	
	function wp_pdf_addbuttons() {
	   	// Don't bother doing this stuff if the current user lacks permissions
	   	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
	    	return;
	    //rich_editing
	   // add_filter("mce_external_plugins", array(&$this,'add_tinymce_plugin'));
	    add_filter('mce_buttons', array(&$this,'register_button'));
	     
	    //for html editing 
	    add_action('edit_form_advanced', array(&$this,'print_javascript'));
		add_action('edit_page_form',array(&$this,'print_javascript'));
	    //add_action('admin_footer','print_javascript');
	}
	 
	function register_button($buttons) {
	   	array_push($buttons,  "hfplayer");
	   	return $buttons;
	}
	 
	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	/*function add_tinymce_plugin($plugin_array) {
	   	$plugin_array['wppdfplayer'] = $this->plugin_url . '/tinymce3/editor_plugin.js';
	   	return $plugin_array;
	}*/

	function admin_javascript(){
		//show only when editing a post or page.
		if (strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php') || strpos($_SERVER['REQUEST_URI'], 'page-new.php') || strpos($_SERVER['REQUEST_URI'], 'page.php')) {
		
			//wp_enqueue_script only works  in => 'init'(for all), 'template_redirect'(for only public) , 'admin_print_scripts' for admin only
			if (function_exists('wp_enqueue_script')) {
				$jspath='/'. PLUGINDIR  . '/'. $this->plugin_folder.'/jqModal/jqModal.js';
				wp_enqueue_script('jqmodal_wppdf', $jspath, array('jquery'));
			}

		}
		
	}
	function print_javascript () {
	 
?>
   <!--  for popup dialog -->
   <link href="<?php echo $this->plugin_url . '/jqModal/jqModal.css'; ?>" type="text/css" rel="stylesheet" />

   <script type="text/javascript">
   	jQuery(document).ready(function(){
		// Add the buttons to the HTML view
		jQuery("#ed_toolbar").append('<input type=\"button\" class=\"ed_button\" onclick=\"jQuery(\'#dialog_wppdf\').jqmShow();\" title=\"WordpressPDF\" value=\"WordpressPDF\" />');
   	});

	jQuery(document).ready(function () {
			jQuery('#dialog_wppdf').jqm();
	});

	function update_wppdfplayer(){
		var f=document.wppdfoptions;
		if (f== null) return;


		
		
		
		
		
		
		
		
		
		
		
		
		text='[wp-pdf-view swf="'+f.swf.value+'"\n';

		if (f.width.value.length >0 )
			text +='    width="'+f.width.value+'" \n';
		if (f.height.value.length > 0 )
			text +='    height="'+f.height.value+'" \n';

		text +='    player="'+f.player[f.player.selectedIndex].value+'" \n';
		text += ' /]';
		
		if (text.length > 0){
			if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
				ed.focus();
				if (tinymce.isIE)
					ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

				ed.execCommand('mceInsertContent', false, text);
			} else
				edInsertContent(edCanvas, text);
			 
		}	
		 
		
		jQuery('#dialog_wppdf').jqmHide();
	}

	
   	</script>

	<?php   
	  //end of print_javascript 
	}

	function admin_footer(){
		
		if (strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php') || strpos($_SERVER['REQUEST_URI'], 'page-new.php') || strpos($_SERVER['REQUEST_URI'], 'page.php')) {
		
		?>
		<div id="dialog_wppdf" class='jqmWindow' >
	<div style='width:100%;text-align:center'>
	<h3><a href='http://rusterra.com/wp-pdf-view-wordpress-plugin/' target='_new'>WordpressPDF</a></h3>
	 

	<form name='wppdfoptions' onsubmit='return false;' >
	
	<table style='text-align:left;width:100%;'>
		<tr> 
			<td valign='top'>swf(required)</td>
			<td><input type='text' size='50' name='swf' /></td>
		</tr>	
		<tr>
			<td valign="top">Flash Player:</td>
			<td><select name="player">
			<option value="1" <?php if ($this->user_attr['player'] == '1' ) print "selected"; ?> >1.Zviewer (GPL)</option>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">Width</td>
			<td><input type='text' name="width" value="<?php print $this->user_attr['width'];?>" size='4' maxlength='4' /> 
			</td>
		</tr>
		<tr>
			<td valign="top">Height</td>
			<td><input type='text' name="height" value="<?php print $this->user_attr['height'];?>" size='4' maxlength='4' /> 
			</td>
		</tr>

	</table>

	 	<p class='submit'><input type='button' value='OK' onclick='update_wppdfplayer()'; >
	 	<input type='button' value='Cancel' onclick="jQuery('#dialog_wppdf').jqmHide();" >
	 	</p>
	</div>	
	
	</form>	 
			
	 
	
	</div>
	  <?php 
		}
	}
	
}


//this is to return back the ampersand .
if (!class_exists('wppdf_ampersand')){

class wppdf_ampersand 


{
	var $target = array("&#8217;","&#8220;","&#8221;","&#038;","\'","&#8242;", "&#8216;");
	var $replace= array("'",'"','"',"&","'","'","'");
	

	function wppdf_return_ampersand (){
		
	}

	function bind_hooks(){
		// must be executed at the end to guarantee that it is not modified by other plugin	
		add_filter('the_content', array(&$this,'filter_callback'), '100');
	}
	

	function filter_callback($content) {
		return preg_replace_callback('|<wppdf-ampersand>(.*?)</wppdf-ampersand>|ims', array(&$this,'replace_callback'), $content);
	}
		
	function replace_callback($arg) {
		return str_replace($this->target,$this->replace,clean_pre($arg[1]));
	}
}

}

$wppdf_swf = new wp_pdf_view();

$wppdf_swf->bind_hooks();


// admin option page update
if ( isset($_POST['wppdf_player']) ) {
	$wppdf_flv->wp_pdf_options_update();
}


// Below is to convert &#038 back to '&'
$wppdf_amp = new wppdf_ampersand();
$wppdf_amp->bind_hooks();

function wp_pdf_view_template_call($arg){
	global $wppdf_swf;
	
	if(!$wppdf_swf){
		$wppdf_swf = new wp_pdf_view();
	}
	
	return $wppdf_swf->wp_pdf_callback(array('',$arg));
}

