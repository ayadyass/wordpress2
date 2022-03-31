<?php get_header(); ?>

<div id="content">

	<div id="column">

	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	
	<div class="post" id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>
		<?php the_content('Continue reading...'); ?><div class="clear"></div>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php edit_post_link('Edit this page', '<p>', '</p>'); ?>
	</div>

	<?php endwhile; ?>
	<?php endif; ?>
	
	</div>
	
<?php get_sidebar(); ?>

<div class="clear"></div>
</div>

<?php get_footer(); ?>