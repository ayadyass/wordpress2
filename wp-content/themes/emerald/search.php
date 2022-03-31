<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">
						<h1 class="archive-title"><span><?php _e('Search Results for:', 'emeraldtheme'); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<header class="article-header">

									<h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php if(the_title('','',false)){ the_title(); }else{ _e('Untitled', 'emeraldtheme'); } ?></a></h3>
									<p class="byline vcard"><?php
										printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'emeraldtheme'), get_the_time('Y-m-d'), get_the_time(__('F jS, Y', 'emeraldtheme')), emerald_get_the_author_posts_link(), get_the_category_list(', '));
									?></p>

								</header> <!-- end article header -->

								<section class="entry-content">
										<?php the_excerpt('<span class="read-more">' . __('Read more &raquo;', 'emeraldtheme') . '</span>'); ?>

								</section> <!-- end article section -->

								<footer class="article-footer">

								</footer> <!-- end article footer -->

							</article> <!-- end article -->

						<?php endwhile; ?>

						<?php emerald_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e("Sorry, No Results.", "emeraldtheme"); ?></h1>
										</header>
										<section class="entry-content">
										</section>
										<footer class="article-footer">
										</footer>
									</article>

							<?php endif; ?>

						</div> <!-- end #main -->

							<?php get_sidebar(); ?>

					</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
