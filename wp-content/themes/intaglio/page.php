<?php get_header(); ?>


<div id="main">
	<?php while(have_posts()) : the_post(); ?>
	<div id="featured_content">
		<em><?php the_date('j M Y');?></em><?php the_date('l');?><em><?php the_date('y');?></em><h2 id="single"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<span class="jump_comments"><a href="#">Jump to comments</a></span>
		<div class="clear"></div>
	</div>
	<div id="content">
		<div id="reading">
		<span class="post_meta">Posted in: <?php the_category('seperator=&bull;'); ?></span>
		<p><?php the_content(); ?></p>
					
					<?php comments_template(); ?>
		</div>
	
	<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>