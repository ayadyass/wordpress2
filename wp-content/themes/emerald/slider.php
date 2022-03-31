<?php if(is_front_page() && get_option('emerald_featured_category') && get_option('emerald_featured_category') != -1 ): ?>
<ul class="rslides">
<?php
	global $slider_used; 
	$slider_used = true;
	global $slide;
	$args = array( 'orderby' => 'post_date', 'order' => 'DESC', 'category'=> get_option('emerald_featured_category'), 'post_status' => 'publish' );
	$slides = get_posts( $args );
	foreach($slides as $slide) : setup_postdata($slide);
		$post_thumbnail_id = get_post_thumbnail_id( $slide->ID );
		$post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		if($post_thumbnail):
			$slide_url = get_post_meta($slide->ID, 'slide_url', true);
?>		
		<li>
			<img src="<?php echo $post_thumbnail[0]; ?>" />
			<div class="caption"><a href="<?php echo $slide_url; ?>"><?php echo get_the_title($slide->ID); ?></a></div>
		</li>
<?php endif; endforeach; ?>
</ul>
<?php endif; ?>