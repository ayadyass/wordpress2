<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
if (!empty($post->post_password)) { // if there's a password
if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>

<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

<?php
return;
}
}
$oddcomment = 'class="alt" ';
?>

<!-- Begin Comments List -->
<?php if ($comments) : ?>
<div class="commentlistdiv">
<h1 id="comments"><?php comments_number('No Comments', 'One Comment', '% Comments' );?> on &#8220;<?php the_title(); ?>&#8221;</h1>
<ul class="commentlist">
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type == 'comment') { ?>
<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">

<div class="pane_l">
<div class="c_author"><?php comment_author_link() ?></div>
<div class="c_avatar"><?php echo get_avatar( $comment, 32 ); ?></div>
<div class="c_date"><?php comment_date('j F, Y, G:i'); ?><?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></div>
<div class="c_approved"><?php if ($comment->comment_approved == '0') : ?>Your comment is awaiting approval.<?php endif; ?></div>
</div>

<div class="pane_r">
<?php comment_text() ?>
</div>
<div class="clear"></div>

</li>
<?php $oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : ''; ?>
<?php } else { $trackback = true; } /* End of is_comment statement */ ?>
<?php endforeach; ?>
</ul>
</div>
<!-- End Comments List -->

<!-- Setup Trackbacks box -->
<?php if ($trackback == true) { ?>
<div class="post_ping">
<h1>Trackbacks</h1>
<ol>
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type != 'comment') { ?>
<li><?php comment_author_link() ?></li>
<?php } ?>
<?php endforeach; ?>
</ol>
</div>
<?php } ?>
<!-- End Trackbacks display -->

<!-- Leave a Reply Box -->
<?php else : ?>
<!-- this is displayed if there are no comments so far -->

<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->

<?php else : // comments are closed ?>
<!-- If comments are closed. -->

<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div class="reply">
<h1 id="respond">Leave a Comment</h1>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>

<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<fieldset>

<?php if ( $user_ID ) : ?>
<p style="line-height: 1.5em">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" class="replytext" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" class="replytext" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="email">Mail <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" class="replytext" />
<label for="url">Website</label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" tabindex="4" class="replyarea"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Send Comment" class="replybutton" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</fieldset>
</form>
</div>
<!-- End Leave a Reply Box -->

<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>