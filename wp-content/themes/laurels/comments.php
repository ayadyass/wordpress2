<?php
/*
 * Comment Template File.
 */
if ( post_password_required() )
	return; ?>
<div class="clearfix"></div>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : 	?>
    <h2 class="comments-title">
    <?php
      /* translators: 1: comment count number */
     printf(esc_html(_n('%1$s Comment', '%1$s Comments', get_comments_number(), 'laurels')), esc_attr(number_format_i18n(get_comments_number())), get_the_title()); ?>
	</h2>
    <ul>
    <?php	
		wp_list_comments( array( 'callback' => 'laurels_comment', 'short_ping' => true) ); ?>
    </ul>
       <?php paginate_comments_links(); ?>     
	<?php endif; // have_comments() ?>
	<?php comment_form(); ?>
</div><!-- #comments .comments-area -->