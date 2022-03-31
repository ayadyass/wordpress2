<?php
/*
Template Name: Fullwidth
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title"><?php if(the_title('','',false)){ the_title(); }else{ _e('Untitled', 'emeraldtheme'); } ?></h1>
									<p class="byline vcard"><?php
										printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span>.', 'emeraldtheme'), get_the_time('Y-m-d'), get_the_time(__('F jS, Y', 'emeraldtheme')), emerald_get_the_author_posts_link());
									?></p>


								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<p class="clearfix"><?php the_tags('<span class="tags">' . __('Tags:', 'emeraldtheme') . '</span> ', ', ', ''); ?></p>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->

							<?php endwhile; else : ?>

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

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
