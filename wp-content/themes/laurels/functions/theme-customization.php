<?php
/**
* Customization options
**/
$laurels_options = get_option( 'laurels_theme_options' );
// post category list
function laurels_post_category(){
  $cats = array();
  $cats['']='Select Category';
  foreach ( get_categories() as $categories => $category ){
      $cats[$category->term_id] = $category->name;
  }
  return $cats;
}
function laurels_sanitize_checkbox( $checked ) {
  return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
//select sanitization function
function laurels_sanitize_select( $input, $setting ){         
//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
$input = sanitize_key($input); 
//get the list of possible select options 
$choices = $setting->manager->get_control( $setting->id )->choices;                            
return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
}
//URL
function laurels_sanitize_url( $url ) {
  return esc_url_raw( $url );
}
//Get Image ID by image URL
function laurels_get_image_id($image_url) {
  global $wpdb;
  if($image_url != ""){
  $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
    if(!empty($attachment)){
        return $attachment[0]; 
      }
  }
}
function laurels_customize_register( $wp_customize ) {
  $laurels_options = get_option( 'laurels_theme_options' );
  $wp_customize->add_panel(
  'general',
    array(
      'title'       => esc_html__( 'General Settings', 'laurels' ),
      'description' => esc_html__('General Settings','laurels'),
      'priority'    => 20, 
  ));
  $wp_customize->get_section('title_tagline')->panel = 'general';
  $wp_customize->get_section('header_image')->panel = 'general';
  $wp_customize->get_section('static_front_page')->panel = 'general';   
  $wp_customize->get_section('title_tagline')->title = esc_html__( 'Header & Logo', 'laurels'); 
  /* --------------------------- Start General Panel -------------------- */
  // Start Socials Settings Section
  $wp_customize->add_section( 'socials_settings', array(
    'priority'            => 25,
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Socials Settings', 'laurels'),
    'panel'               => 'general'
  ) );
  // Social accounts
  $SocialIconDefault = array(
  array('url'=>isset($laurels_options['facebook'])?$laurels_options['facebook']:'','icon'=>'fa-facebook'),
  array('url'=>isset($laurels_options['twitter'])?$laurels_options['twitter']:'','icon'=>'fa-twitter'),
  array('url'=>isset($laurels_options['pinterest'])?$laurels_options['pinterest']:'','icon'=>'fa-pinterest'),
  array('url'=>isset($laurels_options['googleplus'])?$laurels_options['googleplus']:'','icon'=>'fa-google-plus'),
  array('url'=>isset($laurels_options['rss'])?$laurels_options['rss']:'','icon'=>'fa-rss'),
  array('url'=>isset($laurels_options['linkedin'])?$laurels_options['linkedin']:'','icon'=>'fa-linkedin'),
  );  

  $SocialIcon = array();
  for($i=1;$i <= 6;$i++):  
    $SocialIcon[] =  array( 'slug'=>sprintf('SocialIcon%d',$i),   
      'default'       => $SocialIconDefault[$i-1]['icon'],   
      'label'         => esc_html__( 'Social Account ', 'laurels') .$i,   
      'priority'      => sprintf('%d',$i) );  
  endfor;
  foreach($SocialIcon as $SocialIcons){
    $wp_customize->add_setting(
      $SocialIcons['slug'],
      array( 
       'default'      => $SocialIcons['default'],       
        'capability'  => 'edit_theme_options',
        'type'        => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );
    $wp_customize->add_control(
      $SocialIcons['slug'],
      array(
        'type'        => 'text',
        'section'     => 'socials_settings',
        'input_attrs' => array( 'placeholder' => esc_attr__('fa-twitter','laurels') ),
        'label'       =>   $SocialIcons['label'],
        'priority'    => $SocialIcons['priority']
      )
    );
  }
  $SocialIconLink = array();
  for($i=1;$i <= 6;$i++):  
    $SocialIconLink[] =  array( 'slug'=>sprintf('SocialIconLink%d',$i),   
      'default'       => $SocialIconDefault[$i-1]['url'],   
      'label'         => esc_html__( 'Social Link ', 'laurels' ) .$i,
      'priority'      => sprintf('%d',$i) );  
  endfor;
  foreach($SocialIconLink as $SocialIconLinks){
    $wp_customize->add_setting(
      $SocialIconLinks['slug'],
      array(
        'default'     => $SocialIconLinks['default'],
        'capability'  => 'edit_theme_options',
        'type'        => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
      )
    );
    $wp_customize->add_control(
      $SocialIconLinks['slug'],
      array(
        'type'        => 'text',
        'section'     => 'socials_settings',
        'priority'    => $SocialIconLinks['priority'],
        'input_attrs' => array( 'placeholder' => esc_html__('http://twitter/username','laurels')),
      )
    );
  }
  // End Socials SettingsSection 
  // Start Blog Listing Section 
  $wp_customize->add_section( 'blog_page_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Blog(Archive) Page', 'laurels'),
    'panel'               => 'general'
  ) );
  // Meta Tag Checkbox
  $wp_customize->add_setting( 'hide_post_meta_tag', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_post_meta_tag', array(
    'type'                => 'checkbox',
    'section'             => 'blog_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post meta tag', 'laurels' ),
  ) );
  // Blog Image Checkbox
  $wp_customize->add_setting( 'hide_post_image', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_post_image', array(
    'type'                => 'checkbox',
    'section'             => 'blog_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post image', 'laurels' ),
  ) );
  // Read More Link
  $wp_customize->add_setting( 'hide_post_readmore_button', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_post_readmore_button', array(
    'type'                => 'checkbox',
    'section'             => 'blog_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide read more link', 'laurels' ),
  ) );
  // Post Content Limit
  $wp_customize->add_setting( 'post_content_limit', array(
    'default'             => '40',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'post_content_limit', array(
    'type'                => 'text',
    'priority'            => 10,
    'section'             => 'blog_page_section',
    'label'               => esc_html__( 'Post Content Limit', 'laurels' ),
  ) );
  // Post Button text
  $wp_customize->add_setting( 'post_button_text', array(
    'default'             => 'Read More',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'post_button_text', array(
    'type'                => 'text',
    'priority'            => 10,
    'section'             => 'blog_page_section',
    'label'               => esc_html__( 'Post Button Text', 'laurels' ),
  ) );
  // Blog sidebar setting 
  $wp_customize->add_setting( 'post_sidebar_layout', array(
    'default'             => 'right',
    'sanitize_callback'   => 'laurels_sanitize_select',
  ) );
  $wp_customize->add_control( 'post_sidebar_layout', array(
    'type'                => 'select',
    'section'             => 'blog_page_section',
    'label'               => esc_html__( 'Display Sidebar', 'laurels' ),
    'choices'             => array(
      'right'             => 'Right',
      'left'              => 'Left',
      'full'              => 'Full',
      )
  ) );
  // End Blog Listing Section
  // Start Single Post Page Section
  $wp_customize->add_section( 'single_post_page_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Single Post Page', 'laurels'),
    'panel'               => 'general'
  ) );
  // Single Post Meta Tag Checkbox 
  $wp_customize->add_setting( 'hide_single_post_meta_tag', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_single_post_meta_tag', array(
    'type'                => 'checkbox',
    'section'             => 'single_post_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post meta tag', 'laurels' ),      
  ) );
  // Comment Form 
  $wp_customize->add_setting( 'hide_single_post_comment_form', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_single_post_comment_form', array(
    'type'                => 'checkbox',
    'section'             => 'single_post_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide comment form', 'laurels' ),
  ) );
  // Single Post Image Checkbox 
  $wp_customize->add_setting( 'hide_single_post_image', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_single_post_image', array(
    'type'                => 'checkbox',
    'section'             => 'single_post_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post image', 'laurels' ),
  ) );
  // Single Post Page Sidebar
  $wp_customize->add_setting( 'single_post_sidebar_layout', array(
    'default'             => 'right',
    'sanitize_callback'   => 'laurels_sanitize_select',
  ) );
  $wp_customize->add_control( 'single_post_sidebar_layout', array(
    'type'                => 'select',
    'section'             => 'single_post_page_section',
    'label'               => esc_html__( 'Display Sidebar', 'laurels' ),
    'choices'             => array(
      'right'             => 'Right',
      'left'              => 'Left',
      'full'              => 'Full',
    )
  ) );
  // End Single Posts Page Section
  /* --------------------------- End General Panel -------------------- */
  /* --------------------------- Start Front Page Panel -------------------- */
  $wp_customize->add_panel(
    'homepage_setting',
    array(
    'title'               => esc_html__( 'Front Page Settings', 'laurels' ),
    'description'         => esc_html__('Front Page Settings','laurels'),
    'priority'            => 20, 
    )
  );
  // Start Slider Section 
  $wp_customize->add_section( 'slider_setting', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Slider Section', 'laurels'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox
  $wp_customize->add_setting( 'hide_slider_section', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_slider_section', array(
    'type'                => 'checkbox',
    'section'             => 'slider_setting', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'laurels' ),
  ) );
  // Image
  for($i=1;$i<=5;$i++)
  {
    $image_url=isset($laurels_options['slider-img-'.$i])?$laurels_options['slider-img-'.$i]:'';
    $image_id = laurels_get_image_id($image_url);
    $wp_customize->add_setting( 'slider_image_'.$i, array(
      'default'           => $image_id,
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control(
      new WP_Customize_Cropped_Image_Control(
      $wp_customize,
      'slider_image_'.$i,
      array(
      'label'             => esc_html( 'Slide '.$i ),
      'section'           => 'slider_setting',
      'settings'          => 'slider_image_'.$i,
      'description'       => esc_html__('Upload Image Size : 1299 x 375', 'laurels'),
      'height'            => 375,
      'width'             => 1299,
      'flex_width'        => false,
      'flex_height'       => false,
      )
    ) ); 
    // Slide Link 
    $wp_customize->add_setting( 'slide_link_'.$i, array(   
      'default'           => isset($laurels_options['slidelink-'.$i])?$laurels_options['slidelink-'.$i]:'',
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'laurels_sanitize_url',
    ) );
    $wp_customize->add_control( 'slide_link_'.$i, array(
      'type'              => 'url',
      'priority'          => 10,
      'section'           => 'slider_setting',      
      'input_attrs'       => array(
            'placeholder' => esc_html__( 'Slide Link', 'laurels' ),
      )
    ) );
  }
  // End Slider Section 
  // Start About Us Section
  $wp_customize->add_section( 'about_us', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('About Us Section', 'laurels'),
    'panel'               => 'homepage_setting'
  ) );
   // Checkbox
  $wp_customize->add_setting( 'hide_about_us', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_about_us', array(
    'type'                => 'checkbox',
    'section'             => 'about_us', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'laurels' ),
  ) );
  // Title
  $wp_customize->add_setting( 'about_us_title', array(
    'default'             => isset($laurels_options['home-title'])?$laurels_options['home-title']:'WELCOME TO LAURELS WORDPRESS THEME',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'about_us_title', array(
    'type'                => 'text',
    'section'             => 'about_us',
    'label'               => esc_html__('Title','laurels'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'Enter title', 'laurels' ),
    )
  ) );
  // Description
  $wp_customize->add_setting( 'about_us_description', array(
    'default'             => isset($laurels_options['home-content'])?$laurels_options['home-content']:'Lorem Ispum Lorem Ispum Lorem Ispum Lorem Ispum Lorem Ispum Lorem Ispum Lorem Ispum Lorem Ispum',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'wp_kses_post',
  ) );
  $wp_customize->add_control( 'about_us_description', array(
    'type'                => 'textarea',
    'priority'            => 10,
    'label'               => esc_html__( 'Short Description', 'laurels' ),
    'section'             => 'about_us',
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'Enter Short Description', 'laurels' ),
    )
  ) );
  // End About Us Section
  // Start Key Features Section
  $wp_customize->add_section( 'key_features_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Key Features Section', 'laurels'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox
  $wp_customize->add_setting( 'hide_key_features', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_key_features', array(
    'type'                => 'checkbox',
    'section'             => 'key_features_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'laurels' ),
  ) );
  for($i=1;$i<=4;$i++)
  {
    // Key Feature Icon
    $image_id=laurels_get_image_id($laurels_options['home-icon-'.$i]);
    $wp_customize->add_setting('key_features_section_tab_icon'.$i,array(
      'default'             => $image_id,
      'sanitize_callback'   => 'sanitize_text_field',
      'transport'           => 'postMessage'
    ) );
    $wp_customize->add_control(
      new WP_Customize_Cropped_Image_Control(
      $wp_customize,
      'key_features_section_tab_icon'.$i,
      array(
      'label'               => esc_html__('Tab ','laurels').$i,
      'section'             => 'key_features_section',
      'settings'            => 'key_features_section_tab_icon'.$i,
      'description'         => esc_html__('Upload Image Size : 190 x 189', 'laurels'),
      'height'              => 189,
      'width'               => 190,
      'flex_width'          => false,
      'flex_height'         => false,
      )
    ) ); 
    // Key Feature Title
    $wp_customize->add_setting( 'key_features_section_tab_title'.$i, array(
      'default'             => isset($laurels_options['section-title-'.$i])?$laurels_options['section-title-'.$i]:'',
      'type'                => 'theme_mod',
      'capability'          => 'edit_theme_options',
      'sanitize_callback'   => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'key_features_section_tab_title'.$i, array(
      'type'                => 'text',
      'section'             => 'key_features_section',
      'input_attrs'         => array(
            'placeholder'   => esc_html__( 'Enter title', 'laurels' ),
      )
    ) );
    // Key Feature Sub Title
    $wp_customize->add_setting( 'key_features_section_tab_subtitle'.$i, array(
      'default'             => isset($laurels_options['section-post-'.$i])?$laurels_options['section-post-'.$i]:'',
      'type'                => 'theme_mod',
      'capability'          => 'edit_theme_options',
      'sanitize_callback'   => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'key_features_section_tab_subtitle'.$i, array(
      'type'                => 'text',
      'section'             => 'key_features_section',
      'input_attrs'         => array(
            'placeholder'   => esc_html__( 'Enter Sub title', 'laurels' ),
      )
    ) );
    // Key Feature Description
    $wp_customize->add_setting( 'key_features_section_tab_description'.$i, array(
      'default'             => isset($laurels_options['section-content-'.$i])?$laurels_options['section-content-'.$i]:'',
      'type'                => 'theme_mod',
      'capability'          => 'edit_theme_options',
      'sanitize_callback'   => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'key_features_section_tab_description'.$i, array(
      'type'                => 'textarea',
      'priority'            => 10,
      'section'             => 'key_features_section',
      'input_attrs'         => array(
            'placeholder'   => esc_html__( 'Enter Description', 'laurels' ),
      )
    ) );
    }
  // End Key Features Section
  // Start Recent Posts Section
  $wp_customize->add_section( 'recent_posts_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Recent Posts Section', 'laurels'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox
  $wp_customize->add_setting( 'hide_recent_posts', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_recent_posts', array(
    'type'                => 'checkbox',
    'section'             => 'recent_posts_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'laurels' ),
  ) );
  // Title
  $wp_customize->add_setting( 'recent_posts_section_title', array(
    'default'             => isset($laurels_options['post-title'])?$laurels_options['post-title']:'Recent Posts',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'recent_posts_section_title', array(
    'type'                => 'text',
    'section'             => 'recent_posts_section',
    'label'               => esc_html__('Title','laurels'),
    'input_attrs'         => array(
            'placeholder' => esc_html__( 'Enter Title', 'laurels' ),
      )
  ) );
  // Post Category select box
  $wp_customize->add_setting( 'recent_posts_section_category', array(
    'default'             => isset($laurels_options['post-category'])?$laurels_options['post-category']:'1',
    'sanitize_callback'   => 'laurels_sanitize_select',
  ) );
  $wp_customize->add_control( 'recent_posts_section_category', array(
    'type'                => 'select',
    'choices'             => laurels_post_category(),
    'section'             => 'recent_posts_section',
    'label'               => esc_html__( 'Category', 'laurels' ),
  ) );
  // End Recent Posts Section
  // Start Our Latest Posts Section
  $wp_customize->add_section( 'our_latest_posts_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Our Latest Posts Section', 'laurels'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox
  $wp_customize->add_setting( 'hide_our_latest_posts', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'laurels_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_our_latest_posts', array(
    'type'                => 'checkbox',
    'section'             => 'our_latest_posts_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'laurels' ),
  ) );
  // Our Latest Posts Title
  $wp_customize->add_setting( 'our_latest_section_title', array(
    'default'             => isset($laurels_options['latestpost-title'])?$laurels_options['latestpost-title']:'Our Latest Posts',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'our_latest_section_title', array(
    'type'                => 'text',
    'section'             => 'our_latest_posts_section',
    'label'               => esc_html__('Title','laurels'),
    'input_attrs'         => array(
            'placeholder' => esc_html__( 'Enter Title', 'laurels' ),
      )
  ) );
  // Our Latest Posts Category select box
  $wp_customize->add_setting( 'our_latest_section_category', array(
    'default'             => '1',
    'sanitize_callback'   => 'laurels_sanitize_select',
  ) );
  $wp_customize->add_control( 'our_latest_section_category', array(
    'type'                => 'select',
    'choices'             => laurels_post_category(),
    'section'             => 'our_latest_posts_section',
    'label'               => esc_html__( 'Category', 'laurels' ),
  ) );
  // End Our Latest Posts Section
  
  /* --------------------------- End Front Page Panel -------------------- */
  /* --------------------------- Start Footer Settings Panel ------------- */
  $wp_customize->add_section( 'footer_setting', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Footer Settings', 'laurels'),
  ) );
  $wp_customize->add_setting( 'footerCopyright', array(
    'default'             => isset($laurels_options['footertext'])?$laurels_options['footertext']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'wp_kses_post',
  ) );
  $wp_customize->add_control( 'footerCopyright', array(
    'type'                => 'textarea',
    'section'             => 'footer_setting',
    'label'               => esc_html__('Copyright Text','laurels'),
    'description'         => esc_html__('Some text regarding copyright of your site, you would like to display in the footer.', 'laurels'),
  ) );
  /* --------------------------- End Footer Settings Panel ------------------ */
}
add_action( 'customize_register', 'laurels_customize_register' );
function laurels_custom_css(){ ?>
<style type="text/css">
</style>
<?php }
add_action('wp_head','laurels_custom_css',900);