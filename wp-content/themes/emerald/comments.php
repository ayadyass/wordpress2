<?php
/*
The comments page for emerald
*/

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<div class="alert alert-help">
			<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "emeraldtheme"); ?></p>
		</div>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments" class="h2"><?php comments_number(__('<span>No</span> Responses', 'emeraldtheme'), __('<span>One</span> Response', 'emeraldtheme'), _n('<span>%</span> Response', '<span>%</span> Responses', get_comments_number(),'emeraldtheme') );?> to &#8220;<?php if(the_title('','',false)){ the_title(); }else{ _e('Untitled', 'emeraldtheme'); } ?>&#8221;</h3>

	<nav id="comment-nav">
		<ul class="clearfix">
				<li><?php previous_comments_link() ?></li>
				<li><?php next_comments_link() ?></li>
		</ul>
	</nav>

	<ol class="commentlist">
		<?php wp_list_comments('callback=emerald_comments'); ?>
	</ol>

	<nav id="comment-nav">
		<ul class="clearfix">
				<li><?php previous_comments_link() ?></li>
				<li><?php next_comments_link() ?></li>
		</ul>
	</nav>

	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
			<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>

	<!-- If comments are closed. -->
	<!--p class="nocomments"><?php _e("Comments are closed.", "emeraldtheme"); ?></p-->

	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<section id="respond" class="respond-form">
		<?php comment_form(); ?>
	</section>
<?php endif; ?>