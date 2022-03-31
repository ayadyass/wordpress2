<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="post" id="post-<?php the_ID(); ?>">
                <div class="post-top">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php if ( function_exists('the_title_attribute')) the_title_attribute(); else the_title(); ?>"><?php the_title(); ?></a></h2>
					<div class="post_comments"><p><?php comments_number('0', '1', '%'); ?></p></div>
                </div>
				<div class="info">
					Posted on : <?php the_time('d-m-Y') ?> | By : <b><?php the_author() ?></b> | In : <span><?php the_category(', ') ?></span>
				</div>
				<div class="entry">
					<?php theme_google_300_ads_show(); ?>
					<?php the_content('Read the rest of this entry &raquo;'); ?>
					<?php theme_google_468_ads_show(); ?>
				</div>
			</div>
			<div id="comment_container">
			<?php comments_template(); ?>
			</div>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
