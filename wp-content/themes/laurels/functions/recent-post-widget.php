<?php
/* 
 *	laurels post widget	
 */
class laurels_randompostwidget extends WP_Widget {
function __construct()
{
$laurels_widget_ops = array('classname' => 'laurels_recentpostwidget', 'description' => 'Displays a recent post with thumbnail' );
parent::__construct('laurels_recentpostwidget', 'Laurels Recent Post', $laurels_widget_ops);
}

function form($laurels_instance)
{
$laurels_instance = wp_parse_args( (array) $laurels_instance, array( 'title' => '' ) );
$laurels_instance['title'];
if(!empty($laurels_instance['post_number'])) { $laurels_instance['post_number']; } ?>
        <p>
            <label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'laurels'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php if(!empty($laurels_instance['title'])) { echo esc_html($laurels_instance['title']); } ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_html($this->get_field_id( 'post_number' )); ?>"><?php esc_html_e('Number of post to show:', 'laurels'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id( 'post_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_number' )); ?>" value="<?php if(!empty($laurels_instance['post_number'])) { echo esc_html($laurels_instance['post_number']); } else { echo '5'; } ?>" style="width:100%;" />
        </p>
<?php
}

function update($laurels_new_instance, $laurels_old_instance)
{
$laurels_instance = $laurels_old_instance;
$laurels_instance['title'] = $laurels_new_instance['title'];
$laurels_instance['post_number'] = $laurels_new_instance['post_number'];
return $laurels_instance;
}

function widget($laurels_args, $laurels_instance)
{
extract($laurels_args, EXTR_SKIP);

echo $before_widget;
$laurels_title = empty($laurels_instance['title']) ? ' ' : apply_filters('widget_title', $laurels_instance['title']);

if (!empty($laurels_title))
echo $before_title . $laurels_title . $after_title;;

//widget code here ?>
<div class="laurels-custom-widget">
<div class="main-post">
          <?php $laurels_args = array('posts_per_page'   => $laurels_instance['post_number'],
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'post_type'        => 'post',
					'post_status'      => 'publish'
				);
				$laurels_single_post = new WP_Query( $laurels_args );
				while ( $laurels_single_post->have_posts() ) { $laurels_single_post->the_post(); ?>
			<div class="media blog-media ">	  
            <?php $laurels_feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
			if($laurels_feat_image!="") { ?>
					<a href="<?php echo esc_url(get_permalink());?>" title="<?php echo get_the_title(); ?>" class="pull-left"> 
						<img src="<?php echo esc_url($laurels_feat_image); ?>" alt="<?php the_title(); ?>" class="media-object" />
					</a>
            <?php }else{ ?>
					<a href="<?php echo esc_url(get_permalink());?>" title="<?php echo get_the_title(); ?>"  class="pull-left"> 
						<img src="<?php echo get_template_directory_uri(); ?>/images/img-not-available.jpg" class="media-object" /> 
					</a>
            <?php } ?>
            <div class="media-body">
					<p class="clearfix">
						<a class="media-heading" href="<?php echo esc_url(get_permalink());?>" title="Post Page">
							<?php the_title(); ?>
						</a>
					</p>
  				   <p class="text-left clearfix">
					   <span><?php comments_number( '0', '1', '%' ); ?>   <?php esc_html_e('Comments','laurels'); ?></span>
				   </p>
            </div>
            </div>
          
          <?php  } ?>
        </div>
</div>
<?php	
echo $after_widget;
}
}
add_action('widgets_init', 'laurels_recentpost_widget');
function laurels_recentpost_widget() {
    register_widget('laurels_randompostwidget');
}