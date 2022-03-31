<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>
		<div class="postinfo">
		<div class="info">Posted by <?php the_author_posts_link(); ?> on <?php the_time('j F, Y'); ?></div>
		<div class="commentnum"><?php comments_number('No comments yet','1 comment so far','% Comments'); ?></div><div class="clear"></div>
		</div>
		<div class="category">This item was filled under <?php the_category(', '); ?></div>
		<div class="entry">

		<?php the_content('Continue reading...'); ?><div class="clear"></div>
		<?php if(function_exists('the_ratings')) { echo '<div class="ratings"><strong>Rate this topic:</strong>'; the_ratings(); echo '</div>'; } ?>
		<?php if(function_exists('the_views')) { echo '<div class="views"><strong>Popularity:</strong> '; the_views(); echo '</div>'; } ?>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link('Edit this Entry', '<p class="edit">', '</p>'); ?>
		
		</div>
		<?php the_tags('<div class="tags">Tagged with: ', ', ', '</div><div class="clear"></div>'); ?>
	</div>
	
	<div class="post_follow">
		You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.
		<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
		You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.
		<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { ?>
		Responses are currently closed, but you can <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.
		<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
		You can skip to the end and leave a response. Pinging is currently not allowed.
		<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { ?>
		Both comments and pings are currently closed.
		<?php } ?>
	</div>

	<?php comments_template(); ?>

	<!--
	<?php trackback_rdf(); ?>
	-->

	<?php endwhile; ?>
	
	<!-- Post Navigation -->
	<div class="nav">
	<div class="nav_left"> <?php next_post_link('&laquo; <strong>%link</strong>'); ?></div>
	<div class="nav_right"> <?php previous_post_link('<strong>%link</strong> &raquo;'); ?> </div>
	<div class="clear"></div>
	</div>
	<!-- End -->
	
	<?php else : ?>
	<div class="post">
	<h1>No posts were found.</h1>
	<p>Sorry! the page you are looking for does not exist.</p>
	<h3>Blog Search</h3>
	<?php include(TEMPLATEPATH."/searchform.php"); ?>
	</div>
	<?php endif; ?>
	
	</div>
	
<?php get_sidebar(); ?>

<div class="clear"></div>
</div>

<?php get_footer(); ?>