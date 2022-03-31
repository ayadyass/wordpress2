<?php 
/*
 * laurels Enqueue css and js files
*/
function laurels_enqueue()
{
	wp_enqueue_style('google-font-api-scada','//fonts.googleapis.com/css?family=Scada');
	wp_enqueue_style('font-awesome',get_template_directory_uri().'/css/font-awesome.css',array());
	wp_enqueue_style('bootstrap',get_template_directory_uri().'/css/bootstrap.css',array(),'','');
	wp_enqueue_style('laurels-custom',get_template_directory_uri().'/css/custom.css',array());
	wp_enqueue_style('laurels-media',get_template_directory_uri().'/css/media.css',array());
	
	wp_enqueue_script('bootstrap',get_template_directory_uri().'/js/bootstrap.js',array('jquery'));
	if(is_page_template('page-template/home-page.php')){
		wp_enqueue_script('owl-carousel',get_template_directory_uri().'/js/owl.carousel.js',array('jquery'));
		wp_enqueue_style('owl-carousel',get_template_directory_uri().'/css/owl.carousel.css',array());
        wp_enqueue_script('laurels-default',get_template_directory_uri().'/js/default.js',array('jquery'));
	}
	wp_enqueue_script( 'ie_html5shiv', get_template_directory_uri().'/js/html5shiv.js',array('jquery'));
    wp_script_add_data( 'ie_html5shiv', 'conditional', 'lt IE 9' );

	if ( is_singular() ) wp_enqueue_script( "comment-reply" ); 
	wp_enqueue_style('laurels-style',get_stylesheet_uri(),array());
}
add_action('wp_enqueue_scripts', 'laurels_enqueue');