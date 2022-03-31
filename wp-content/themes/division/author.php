<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<div class="post_header">
	<h1><?php the_author(); ?>'s Archive</h1>
	</div>
	
	<!-- show author bio? ONLY if there is one -->
	<?php if (get_the_author_description()) { ?><div class="post_author"><?php the_author_description(); ?></div><?php } ?>
	<!-- thats it! -->
	
	<?php while (have_posts()) : the_post(); ?>
	<div class="post">
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="postinfo">
		<div class="info">This entry was posted on <?php the_time('j F, Y'); ?></div>
		<div class="commentnum"><?php comments_popup_link('No comments yet', '1 comment so far', '% Comments'); ?></div><div class="clear"></div>
		</div>
		<div class="category">This item was filled under <?php the_category(', '); ?></div>
		<div class="entry">

		<?php the_excerpt(); ?><div class="clear"></div>
		<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="more-link">Continue reading...</a></p>
		
		</div>
		<?php the_tags('<div class="tags">Tagged with: ', ', ', '</div><div class="clear"></div>'); ?>
	</div>
	<?php endwhile; ?>

	<!-- Plugin Navigation -->
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
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