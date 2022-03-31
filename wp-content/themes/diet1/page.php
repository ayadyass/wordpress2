<?php get_header(); ?>
	<div class="column mid ">
<?php include (TEMPLATEPATH . "/sidebar_left.php"); ?>
<div class="column content_column content ">
	<div align="center"><?php include (TEMPLATEPATH . '/468x60.php'); ?></div>
	<div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
		</div>
	</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
