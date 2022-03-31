<?php
/*
The settings page
*/

function emerald_cp_scripts_styles() {
	if(!is_admin())
		return;
	
	$file_dir = get_template_directory_uri();
	wp_enqueue_style("options_panel_stylesheet", $file_dir."/library/css/options-panel.css", false, "1.0", "all");
	wp_enqueue_script("options_panel_script", $file_dir."/library/js/options-panel.js", false, "1.0");
}
add_action('admin_init', 'emerald_cp_scripts_styles');

function emerald_theme_menu() {
    add_theme_page(  
        'Emerald Settings',            // The title to be displayed in the browser window for this page.  
        'Emerald Settings',            			// The text to be displayed for this menu item
        'administrator',            				// Which type of users can see this menu item  
        'emerald_settings',    							// The unique ID - that is, the slug - for this menu item  
        'emerald_render_settings_page'     				// The name of the function to call when rendering this menu's page  
    );  
  
} // end sandbox_example_theme_menu  
add_action( 'admin_menu', 'emerald_theme_menu' );

function emerald_render_settings_page() {
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"></div>
<h2>Emerald Settings</h2>
<div class="cp-sidebar"><span>Need help?</span><br/><br/><a class="cp-button" target="_blank" href="http://wpgurus.net/hire-me/">Hire Me</a></div>
<div class="sections-wrap">
	<form method="post" action="options.php">
		<?php settings_fields( 'emerald_settings' ); ?>
		<?php do_settings_sections( 'emerald_settings' ); ?>
		</div></div> <!--For the last section-->
	</form>
</div>

</div>
<?php }

function emerald_initialize_theme_options() { 

    // First, we register a section. This is necessary since all future options must belong to a   
    add_settings_section(  
        'general_settings_section',
        '',
        'emerald_general_settings_section_callback',
        'emerald_settings' 
    );
	
	add_settings_section(  
        'social_settings_section',
        '',
        'emerald_social_settings_section_callback', 
        'emerald_settings' 
    );
	
	add_settings_section(  
        'footer_settings_section', 
        '',
        'emerald_footer_settings_section_callback',
        'emerald_settings'
    );
  
    add_settings_field(
        'custom_favicon', 'Custom Favicon', 'emerald_render_settings_field', 'emerald_settings', 'general_settings_section',
		array( 
			'desc' => 'A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image.',
			'id' => 'emerald_favicon',
			'type' => 'text'
		)  
    );
	
	add_settings_field(
        'color_scheme', 'Color Scheme', 'emerald_render_settings_field', 'emerald_settings', 'general_settings_section',
		array(  
			'desc' => 'Select the colour scheme for the theme.',
			'id' => 'emerald_color_scheme',
			'type' => 'select',
			'options' => array("green" => "Green", "blue" => "Blue", "red" => "Red", "orange" => "Orange", "purple" => "Purple")
		)
    );
	
	$categories = get_categories('hide_empty=0&orderby=name');
	$wp_cats = array();
	foreach ($categories as $category_list ) {
		$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
	}
	$wp_cats = array(-1=>"Choose a category") + $wp_cats;

	add_settings_field(
        'featured_category', 'Featured Category', 'emerald_render_settings_field', 'emerald_settings', 'general_settings_section',
		array(
			'desc' => 'Select the category that you want to be used in the homepage slider.',
			'id' => 'emerald_featured_category',
			'type' => 'select',
			'options' => $wp_cats
		)  
    );
	
	add_settings_field(
        'logo_url', 'Logo URL', 'emerald_render_settings_field', 'emerald_settings', 'general_settings_section',
		array(
			'desc' => 'Enter the link to your logo image.',
			'id' => 'emerald_logo',
			'type' => 'text'
		)  
    );
	
	add_settings_field(
        'show_excerpts', 'Show Excerpts', 'emerald_render_settings_field', 'emerald_settings', 'general_settings_section',
		array(  
			'desc' => 'Do you want to show excerpts on homepage?',
			'id' => 'emerald_show_excerpts',
			'type' => 'checkbox'
		)  
    );
	
	add_settings_field(
        'custom_css', 'Custom CSS', 'emerald_render_settings_field', 'emerald_settings', 'general_settings_section', 
		array(
			'desc' => 'Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}',
			'id' => 'emerald_custom_css',
			'type' => 'textarea'
		)
    );
	
	add_settings_field(
        'twitter_url', 'Twitter URL', 'emerald_render_settings_field', 'emerald_settings', 'social_settings_section',
		array( 
			'name' => 'Twitter URL',
			'desc' => 'Enter the URL of your Twitter page.',
			'id' => 'emerald_twitter_url',
			'type' => 'text'
		)
    );
	
	add_settings_field(
        'fb_url', 'Facebook URL', 'emerald_render_settings_field', 'emerald_settings', 'social_settings_section',
		array(
			'desc' => 'Enter the URL of your Facebook fan page.',
			'id' => 'emerald_fb_url',
			'type' => 'text'
		)
    );
	
	add_settings_field(
        'google_plus_url', 'Google Plus URL', 'emerald_render_settings_field', 'emerald_settings', 'social_settings_section',
		array( 
			'desc' => 'Enter the URL of your Google page.',
			'id' => 'emerald_google_plus_url',
			'type' => 'text'
		)
    );
	
	add_settings_field(
        'feedburner', 'Feedburner URL', 'emerald_render_settings_field', 'emerald_settings', 'social_settings_section',
		array( 
			'desc' => 'Feedburner is a Google service that takes care of your RSS feed. Paste your Feedburner URL here to let readers see it in your website',
			'id' => 'emerald_feedburner',
			'type' => 'text'
		)
    );
	
	add_settings_field(
        'footer_text', 'Footer Copyright Text', 'emerald_render_settings_field', 'emerald_settings', 'footer_settings_section',
		array(
			'desc' => 'Enter text used in the left side of the footer.',
			'id' => 'emerald_footer_text',
			'type' => 'text'
		)
    );
	
	add_settings_field(
        'hide_credits', 'Hide credit link?', 'emerald_render_settings_field', 'emerald_settings', 'footer_settings_section',
		array(
			'desc' => 'Do you want to hide the credit link in footer?',
			'id' => 'emerald_hide_credits',
			'type' => 'select',
			'options' => array('sitewide' => 'Show on all pages', 'nofollow' => 'Show but add no-follow attribute', 'homepage' => 'Show only on homepage', 'hide' => 'Hide completely')
		)
    );
	
    // Finally, we register the fields with WordPress 
    register_setting('emerald_settings', 'emerald_favicon');
	register_setting('emerald_settings', 'emerald_color_scheme');
	register_setting('emerald_settings', 'emerald_featured_category');
	register_setting('emerald_settings', 'emerald_logo');
	register_setting('emerald_settings', 'emerald_show_excerpts');
	register_setting('emerald_settings', 'emerald_custom_css');
	register_setting('emerald_settings', 'emerald_twitter_url');
	register_setting('emerald_settings', 'emerald_fb_url');
	register_setting('emerald_settings', 'emerald_google_plus_url');
	register_setting('emerald_settings', 'emerald_feedburner');
	register_setting('emerald_settings', 'emerald_footer_text');
	register_setting('emerald_settings', 'emerald_hide_credits');
	
} // end sandbox_initialize_theme_options 
add_action('admin_init', 'emerald_initialize_theme_options');

function emerald_general_settings_section_callback(){
	echo '<div class="section"><div class="section-title"><h3>General</h3>';
	submit_button('Save Changes', 'secondary','submit', false);
	echo '<div class="clearfix"></div></div><div class="section-options">';
}

function emerald_social_settings_section_callback(){
	echo '</div></div><div class="section"><div class="section-title"><h3>Social Links</h3>';
	submit_button('Save Changes', 'secondary','submit', false);
	echo '<div class="clearfix"></div></div><div class="section-options">';
}

function emerald_footer_settings_section_callback(){
	echo '</div></div><div class="section"><div class="section-title"><h3>Footer</h3>';
	submit_button('Save Changes', 'secondary','submit', false);
	echo '<div class="clearfix"></div></div><div class="section-options">';
}

function emerald_render_settings_field($args){

	if($args['type'] == 'text'){
?>
		<input type="text" id="<?php echo $args['id'] ?>" name="<?php echo $args['id'] ?>" value="<?php echo get_option($args['id']) ?>">
		<small><?php echo $args['desc'] ?></small>
<?php
	}
	else if ($args['type'] == 'select')
	{ 
?>
		<select name="<?php echo $args['id']; ?>" id="<?php echo $args['id']; ?>">
			<?php foreach ($args['options'] as $key=>$option) { ?>
				<option <?php if (get_option( $args['id'] ) == $key) { echo 'selected="selected"'; } echo 'value="'.$key.'"'; ?>><?php echo $option; ?></option><?php } ?>
		</select>
		<small><?php echo $args['desc']; ?></small>
<?php	
	}
	else if($args['type'] == 'checkbox')
	{
?>
		<?php if(get_option($args['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $args['id']; ?>" id="<?php echo $args['id']; ?>" value="true" <?php echo $checked; ?> />
		<small><?php echo $args['desc']; ?></small><div class="clearfix"></div>
<?php
	}
	else if($args['type'] == 'textarea')
	{
?>
		<textarea name="<?php echo $args['id']; ?>" type="<?php echo $args['type']; ?>" cols="" rows=""><?php if ( get_option( $args['id'] ) != "") { echo stripslashes(get_option( $args['id']) ); } ?></textarea>
		<small><?php echo $args['desc']; ?></small><div class="clearfix"></div>
<?php
	}
}

?>