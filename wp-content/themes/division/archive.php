<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<div class="post_header">
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1>Archive for <?php the_time('F jS, Y'); ?></h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1>Archive for <?php the_time('F, Y'); ?></h1>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1>Archive for <?php the_time('Y'); ?></h1>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1>Author Archive</h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1>Blog Archives</h1>
	<?php } ?>
	</div>
	
	<?php while (have_posts()) : the_post(); ?>
	<div class="post">
		<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="postinfo">
		<div class="info">Posted by <?php the_author_posts_link(); ?> on <?php the_time('j F, Y'); ?></div>
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