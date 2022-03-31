<?php 
/*
 * thumbnail list
 * Add default menu style if menu is not set from the backend.
 */
function laurels_add_menuid ($page_markup) {
preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $laurels_matches);
$laurels_divclass = '';
if(!empty($laurels_matches)) { $laurels_divclass = $laurels_matches[1]; }
$laurels_toreplace = array('<div class="'.$laurels_divclass.' pull-right-res">', '</div>');
$laurels_replace = array('<div class="collapse navbar-collapse nav_coll main-menu-ul no-padding">', '</div>');
$laurels_new_markup = str_replace($laurels_toreplace,$laurels_replace, $page_markup);
$laurels_new_markup= preg_replace('/<ul/', '<ul', $laurels_new_markup);
return $laurels_new_markup; }
add_filter('wp_page_menu', 'laurels_add_menuid');

/*
 * laurels Set up post entry meta.
 *
 * Meta information for current post: categories, tags, permalink, author, and date.
 */
function laurels_entry_meta() {
	$laurels_year = get_the_time( 'Y');
	$laurels_month = get_the_time( 'm');
	$laurels_day = get_the_time( 'd');
	
	$laurels_category_list = get_the_category_list() ?  '<li><i class="fa fa-folder-open"></i> '.get_the_category_list(', ').'</li>' : '';
	
	$laurels_tag_list = get_the_tag_list() ? '<li><i class="fa fa-tags"></i> '.get_the_tag_list('',', ').'</li>' : '';
	
	$laurels_date = sprintf( '<li><i class="fa fa-calendar"></i> <a href="%1$s" title="%2$s"><time datetime="%3$s">%4$s</time></a></li>',
		esc_url( get_day_link( $laurels_year, $laurels_month, $laurels_day)),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('d M, Y') )
	);
	$laurels_author = sprintf( '<li><i class="fa fa-user"></i> <a href="%1$s" title="%2$s" >%3$s</a></li>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		/* translators: 1: author name */
		esc_attr( sprintf( __( 'View all posts by %s', 'laurels' ), get_the_author() ) ),
		get_the_author()
	);
	if(comments_open()) { 
		if(get_comments_number()>=1)
			$laurels_comments = '<li><i class="fa fa-comment"></i> '.get_comments_number().'</li>';
		else
			$laurels_comments = '';
	} else {
		$laurels_comments = '';
	}
	if(is_front_page()) {
		printf('%1$s %3$s %5$s',
		$laurels_category_list,
		$laurels_date,
		$laurels_author,		
		$laurels_comments,
		$laurels_tag_list
	);
	} else{
	printf('%1$s %2$s %3$s %4$s %5$s',
		$laurels_category_list,
		$laurels_date,
		$laurels_author,		
		$laurels_comments,
		$laurels_tag_list
	); }
}
if ( ! function_exists( 'laurels_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own laurels_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function laurels_comment( $comment, $laurels_args, $depth ) {

	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments. ?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <p>
    <?php esc_html_e( 'Pingback:', 'laurels' ); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link( __( '(Edit)', 'laurels' ), '<span class="edit-link">', '</span>' ); ?>
  </p>
</li>
<?php break;
		default :
		if($comment->comment_approved==1)
		{
		global $post; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
<article id="comment-<?php comment_ID(); ?>" class="comment col-md-12 no-padding">
		<div class="comments-box">                    	
			<div class="media comment-media"> 
				 <figure class="avtar"> <a href="#" class="pull-left" >
							<?php echo get_avatar( get_the_author_meta(), '80'); ?></a> 
				</figure>
				<div class="laurels-comment-name txt-holder">
					  <?php printf( '<b class="fn">%1$s'.'</b>',
								get_comment_author_link(),
								( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author ', 'laurels' ) . '</span>' : '' 
							); ?>
				</div>
				<div class="media-body"> 
					<span class="color_txt">
						<?php echo '<a href="#" class="reply pull-right">'.comment_reply_link( array_merge( $laurels_args, array( 'reply_text' => __( 'Reply', 'laurels' ), 'after' => '', 'depth' => $depth, 'max_depth' => $laurels_args['max_depth'] ) ) ).'</a>'; ?>
					</span>
					<span><?php echo get_comment_date('M j, Y \a\t g:i a'); ?> </span>
				</div>
				<?php comment_text(); ?>
			</div>  
        </div>
</article>                    
<!-- #comment-## -->
<?php }
	break;
	endswitch; // end comment_type check
}
endif;

function laurels_read_more() {
if(get_theme_mod('hide_post_readmore_button') == '')
	{
		return '<a class="color_txt readmore" href="'. get_permalink() . '">'.esc_html(get_theme_mod('post_button_text','Read More')).'</a>';
	}
}
add_filter( 'excerpt_more', 'laurels_read_more' ); 

/**length post text**/
function laurels_custer_excerpt_length( $length ) {
	return (is_front_page()) ? 40 : get_theme_mod('post_content_limit', 40);
}
add_filter( 'excerpt_length', 'laurels_custer_excerpt_length', 999 );