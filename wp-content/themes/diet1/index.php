<?php get_header(); ?>
<div class="column mid ">
<?php include (TEMPLATEPATH . "/sidebar_left.php"); ?>
<div class="column content_column content "><br />
	<div align="center"><?php include (TEMPLATEPATH . '/468x60.php'); ?></div>
	<div id="content">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>				
			    <small> <span class="date"><strong><?php the_time('F jS, Y') ?></strong></span> <span class="user">by <?php the_author() ?></span> </small>			
				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
                <p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in &nbsp;<span class="folder_icon"> <?php the_category(', ') ?></span> | <?php edit_post_link('Edit', '', ' | '); ?> <span class="comments"> <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> </span></p>
			</div>
		<?php endwhile; ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
	<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>
		</div>
	</div>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>