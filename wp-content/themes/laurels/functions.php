<?php
/*
 * Theme function file.
 */
if ( ! function_exists( 'laurels_setup' ) ) :
function laurels_setup() {
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 770;
	}
	/*
	 * Make laurels theme available for translation.
	 */
	load_theme_textdomain( 'laurels', get_template_directory() . '/languages' );
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', laurels_font_url() ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'laurels-home-thumbnail-image', 311, 186, true );
	add_image_size( 'laurels-home-latestpost-thumbnails',130,80, true );
	add_theme_support( "title-tag" );
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Header Menu', 'laurels' ),
	) );
	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	// Add theme support for Custom hEADER.
	add_theme_support('custom-header', apply_filters('laurels_custom_header_args', array(
        'default-text-color' => 'fff',
        'width' => 1299,
        'height' => 345,
        'flex-height' => true,
        'header_text' =>true,       
    )));
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid html5shiv.
	 */
	add_theme_support( 'html5shiv', array(
		'search-form', 'comment-form', 'comment-list',
	) );
	add_theme_support( 'custom-background', apply_filters( 'laurels_custom_background_args', array(
	'default-color' => 'f5f5f5',
	) ) );
	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'laurels_get_featured_posts',
		'max_posts' => 6,
	) );
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // laurels_setup
add_action( 'after_setup_theme', 'laurels_setup' );

// Laurels Pro Version Menu
add_action( 'admin_menu', 'laurels_admin_menu');
function laurels_admin_menu( ) {
    add_theme_page( __('Pro Feature','laurels'), __('Laurels Pro','laurels'), 'manage_options', 'laurels-pro-buynow', 'laurels_buy_now', 300 );   
}
function laurels_buy_now(){ ?>
<div class="laurels_pro_version">
  <a href="<?php echo esc_url('https://fasterthemes.com/wordpress-themes/laurels/'); ?>" target="_blank">    
    <img src ="<?php echo esc_url(get_template_directory_uri()); ?>/images/laurels_pro_features.png" width="70%" height="auto" />
  </a>
</div>
<?php
}
/*
 * Register Lato Google font for laurels.
 */
function laurels_font_url() {
	$laurels_font_url = '';

	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'laurels' ) ) {
		$laurels_font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $laurels_font_url;
}

/*
 * Function for laurels theme title.
 */
function laurels_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$laurels_site_description = get_bloginfo( 'description', 'display' );
	if ( $laurels_site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $laurels_site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		/* translators: 1: page number */
		$title = "$title $sep " . sprintf( __( 'Page %s', 'laurels' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'laurels_wp_title', 10, 2 );

/*
 * Register widget areas.
 */
function laurels_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'laurels' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'laurels' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Area One', 'laurels' ),
		'id'            => 'footer-1',
		'description'   => __( 'Footer Area One that appears on the right.', 'laurels' ),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="no-padding text-left">',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Area Two', 'laurels' ),
		'id'            => 'footer-2',
		'description'   => __( 'Footer Area Two that appears on the center.', 'laurels' ),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="no-padding text-left">',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Area Three', 'laurels' ),
		'id'            => 'footer-3',
		'description'   => __( 'Footer Area Three that appears on the left.', 'laurels' ),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget no-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="no-padding text-left">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'laurels_widgets_init' );
add_filter( 'comment_form_default_fields', 'laurels_comment_placeholders' );
/**
 * Change default fields, add placeholder and change type attributes.
 *
 * @param  array $fields
 * @return array
 */
function laurels_comment_placeholders( $fields )
{
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="'
        /* Replace 'theme_text_domain' with your theme’s text domain.
         * I use _x() here to make your translators life easier. :)
         * See http://codex.wordpress.org/Function_Reference/_x
         */
            . _x(
                'First Name',
                'comment form placeholder',
                'laurels'
                )
            . '"',
        $fields['author']
    );
    $fields['email'] = str_replace(
        '<input',
        '<input id="email" name="email" type="text" placeholder="'
            . _x(
                'Email Id',
                'comment form placeholder',
                'laurels'
                )
            . '"',
        $fields['email']
        
    );
    return $fields;
}
add_filter( 'comment_form_defaults', 'laurels_textarea_insert' );
function laurels_textarea_insert( $fields )
{
        $fields['comment_field'] = str_replace(
            '</textarea>',
            ''. _x(
                'Comment',
                'comment form placeholder',
                'laurels'
                )
            . ''. '</textarea>',
            $fields['comment_field']
        );
    return $fields;
}
/*** Enqueue css and js files ***/
require get_template_directory() . '/functions/enqueue-files.php';

/*** Theme Default Setup ***/
require get_template_directory() . '/functions/theme-default-setup.php';

/*** Breadcrumbs ***/
require get_template_directory() . '/functions/breadcrumbs.php';

/************ Widget For Subscribe ***********/
require get_template_directory() . '/functions/recent-post-widget.php';

/*** Theme Customizer Option ***/
require get_template_directory() . '/functions/theme-customization.php';