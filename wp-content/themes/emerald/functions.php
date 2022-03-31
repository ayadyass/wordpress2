<?php

// add support for WP 3+ features
add_action('after_setup_theme','emerald_theme_support', 16);

// enqueue base scripts
add_action('wp_enqueue_scripts', 'emerald_scripts', 999);

// enqueue base styles
add_action('wp_enqueue_scripts', 'emerald_styles', 999);

// add sidebars to Wordpress
add_action( 'widgets_init', 'emerald_register_sidebars' );

add_filter( 'the_category', 'remove_cat_rel' );
function remove_cat_rel( $text ) {
	$text = str_replace('rel="tag"', "", $text); return $text;
}

// clean up gallery output in wp
add_filter('gallery_style', 'emerald_gallery_style');

// remove injected CSS from gallery
function emerald_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/*********************
SCRIPTS & ENQUEUEING
*********************/

function emerald_styles() {
  if (!is_admin()) {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	
	// register main stylesheet
    wp_register_style( 'emerald-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );
	wp_register_style( 'slider-stylesheet', get_stylesheet_directory_uri() . '/library/css/home-slider.css', array(), '', 'all' );
	
    // ie-only style sheet
    wp_register_style( 'emerald-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );
	
	wp_enqueue_style( 'emerald-stylesheet' );
	wp_enqueue_style( 'slider-stylesheet' );
    wp_enqueue_style('emerald-ie-only');
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,300,700|Arvo:400,700' );

    $wp_styles->add_data( 'emerald-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet
  }
}

// loading modernizr and jquery, and reply script
function emerald_scripts() {
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'emerald_modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'emerald_js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );
	
	//Responsive slider
	wp_register_script( 'emerald_responsive_slides', get_template_directory_uri().'/library/js/libs/responsiveslides.min.js', array('jquery') );
	wp_register_script( 'emerald_responsive_slides_settings', get_template_directory_uri().'/library/js/libs/responsiveslides-hooks-settings.js', array('responsive_slides') );
	
	//Hover intent
	wp_register_script( 'emerald_hover_intent', get_template_directory_uri().'/library/js/libs/hoverIntent.min.js', array('jquery') );
	//Fit Vids
	wp_register_script( 'emerald_fit_vids', get_template_directory_uri().'/library/js/libs/jquery.fitvids.js', array('jquery') );
		
    // enqueue styles and scripts
    wp_enqueue_script( 'emerald_modernizr' );
    wp_enqueue_script( 'emerald_fit_vids' );
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'emerald_js' );
	wp_enqueue_script( 'emerald_hover_intent' );
	
	if( is_home() ){
    	wp_enqueue_script( 'emerald_responsive_slides' );
		wp_enqueue_script( 'emerald_responsive_slides_settings' );
		
	}
  }
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function emerald_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);
	
	// Thumbnail sizes
	add_image_size( 'emerald-thumb-600', 600, 150, true );
	add_image_size( 'emerald-thumb-300', 300, 100, true );
	add_image_size( 'emerald-thumb-250-square', 250, 250, true );
	add_image_size( 'emerald-thumb-200-square', 200, 200, true );
	add_image_size( 'emerald-thumb-150-square', 150, 150, true );

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',  // background image default
	    'default-color' => '', // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'emeraldtheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'emeraldtheme' ) // secondary nav in footer
		)
	);
} /* end emerald theme support */

/*********************
WP Title
*********************/

function emerald_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'emeraldtheme' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'emerald_wp_title', 10, 2 );

/*********************
MENUS & NAVIGATION
*********************/
// the main menu
function emerald_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
    	'menu' => __( 'The Main Menu', 'emeraldtheme' ),  // nav name
    	'menu_class' => 'nav top-nav clearfix',         // adding custom nav class
    	'theme_location' => 'main-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'emerald_main_nav_fallback'      // fallback function
	));
} /* end emerald main nav */

// the footer menu (should you choose to use one)
function emerald_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => '',                              // remove nav container
    	'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    	'menu' => __( 'Footer Links', 'emeraldtheme' ),   // nav name
    	'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'emerald_footer_links_fallback'  // fallback function
	));
} /* end emerald footer link */

// this is the fallback for header menu
function emerald_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => 'nav top-nav clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}

// this is the fallback for footer menu
function emerald_footer_links_fallback() {
	/* you can put a default here if you like */
}

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function emerald_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="emerald_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'emeraldtheme' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'emeraldtheme' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// cleaning up random code around images
add_filter('the_content', 'emerald_filter_ptags_on_images');
	
// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function emerald_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// cleaning up excerpt
add_filter('excerpt_more', 'emerald_excerpt_more');

// This removes the annoying […] to a Read More link
function emerald_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'emeraldtheme') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'emeraldtheme') .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function emerald_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s', "emeraldtheme" ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

/********************************************************************/

/************* INCLUDE NEEDED FILES ***************/

include('options-panel.php');

require_once('library/translation/translation.php'); // this comes turned off by default

/************** CONTENT WIDTH *********************/

if ( ! isset( $content_width ) ) $content_width = 600;

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function emerald_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar-1',
		'name' => __('Main Sidebar', 'emeraldtheme'),
		'description' => __('The main sidebar.', 'emeraldtheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

} // don't remove this bracket!

function emerald_prev_next_links(){ ?>
<div class="prev-next-links">
	<?php if(is_attachment()): ?>
		<div class="alignright"><?php next_image_link(0, 'Next Image') ?></div><div class="alignleft"><?php previous_image_link(0, 'Previous Image'); ?></div>
	<?php else: ?>
		<div class="alignright"><?php next_post_link(); ?></div><div class="alignleft"><?php previous_post_link(); ?></div>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php
}

/************* COMMENT LAYOUT *********************/

// Comment Layout
function emerald_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'emeraldtheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'emeraldtheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'emeraldtheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'emeraldtheme') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// adding the emerald search form (created in functions.php)
    add_filter( 'get_search_form', 'emerald_wpsearch' );
	
// Search Form
function emerald_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'emeraldtheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!

/************** NAV ***************************/

function emerald_header_dropdown_nav(){
	$return_val = '<div class="dropdown-menu"><select name="page-dropdown" onchange=\'document.location.href=this.options[this.selectedIndex].value;\'> 
	<option value="">';
	$return_val .= esc_attr( __( 'Select Page', "emeraldtheme") ) . '</option>';
	$menu_name = 'main-nav';

		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	if($pages = wp_get_nav_menu_items($menu->term_id)){
	  foreach ( $pages as $key => $page ) {
		$return_val .= '<option value="' . $page->url . '">';
		$menu_item_title =  $page->title;
		$return_val  .= $menu_item_title;
		$return_val  .= '</option>';
	  }
	}
	}

	if(!isset($pages)){
		$pages = get_pages(); 
	  foreach ( $pages as $page ) {
		$return_val .= '<option value="' . get_page_link( $page->ID ) . '">';
		$return_val .= $page->post_title;
		$return_val .= '</option>';
	  }
	}
	$return_val .= '</select></div>';

	return $return_val;
}

function emerald_credit_links($type){
	if($type == 'nofollow') 
		_e('Theme by <a href="http://profiles.wordpress.org/khaxan/" rel="nofollow">WP Gurus</a>.', 'emeraldtheme');
	elseif(($type == 'homepage' && !is_front_page()) || $type == 'hide')
		return;
	else
		_e('Theme by <a href="http://profiles.wordpress.org/khaxan/">WP Gurus</a>.', 'emeraldtheme');
}

add_action('after_switch_theme', 'emerald_theme_activation');
function emerald_theme_activation(){
	header('Location: ' . admin_url() . 'themes.php?page=emerald_settings');
}

?>