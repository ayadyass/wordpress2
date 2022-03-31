<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">

							<?php if (is_category()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e("Posts Categorized:", "emeraldtheme"); ?></span> <?php single_cat_title(); ?>
								</h1>

							<?php } elseif (is_tag()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e("Posts Tagged:", "emeraldtheme"); ?></span> <?php single_tag_title(); ?>
								</h1>

							<?php } elseif (is_author()) {
								global $post;
								$author_id = $post->post_author;
							?>
								<h1 class="archive-title h2">

									<span><?php _e("Posts By:", "emeraldtheme"); ?></span> <?php the_author_meta('display_name', $author_id); ?>

								</h1>
							<?php } elseif (is_day()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e("Daily Archives:", "emeraldtheme"); ?></span> <?php the_time('l, F j, Y'); ?>
								</h1>

							<?php } elseif (is_month()) { ?>
									<h1 class="archive-title h2">
										<span><?php _e("Monthly Archives:", "emeraldtheme"); ?></span> <?php the_time('F Y'); ?>
									</h1>

							<?php } elseif (is_year()) { ?>
									<h1 class="archive-title h2">
										<span><?php _e("Yearly Archives:", "emeraldtheme"); ?></span> <?php the_time('Y'); ?>
									</h1>
							<?php } ?>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
								<?php if( has_post_thumbnail() ): ?>
									<div class="post-thumb">
										<?php the_post_thumbnail( 'emerald-thumb-150-square' ); ?>
									</div>
								<div class="post-container">	
								<?php endif; ?>
									<header class="article-header">

										<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php if(the_title('','',false)){ the_title(); }else{ _e('Untitled', 'emeraldtheme'); } ?></a></h2>
										<p class="byline vcard"><?php
											printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'emeraldtheme'), get_the_time('Y-m-d'), get_the_time(__('F jS, Y', 'emeraldtheme')), emerald_get_the_author_posts_link(), get_the_category_list(', '));
										?></p>

									</header> <!-- end article header -->
									<section class="entry-content clearfix">
										<?php the_excerpt(); ?>

									</section> <!-- end article section -->

									<footer class="article-footer">
									</footer> <!-- end article footer -->
								<?php if( has_post_thumbnail() ): ?>
								</div>
								<?php endif; ?>
							</article> <!-- end article -->

							<?php endwhile; ?>

							<?php emerald_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e("Oops, Post Not Found!", "emeraldtheme"); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "emeraldtheme"); ?></p>
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
