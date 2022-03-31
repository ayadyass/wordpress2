<?php get_header(); ?>


<div id="main">
	<div id="featured_content">
<h2 id="single"><?php the_category('seperator='); ?></h2>
<span class="jump_comments"><?php next_posts_link('&laquo; Older Entries') ?>&nbsp;&nbsp;&nbsp;<?php previous_posts_link('Newer Entries &raquo;') ?></span>
	<div class="clear"></div>
	</div>
	<div id="content">
		<div id="reading">
			
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<div class="post_excerpt">
		<span class="date"><?php the_time('<\e\m>j</\e\m> M <\e\m>Y</\e\m>'); ?></span>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<span class="post_meta">Posted in: <?php the_category('seperator=&bull;'); ?></span>
		<div class="clear"></div>
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>" class="read_more">Read More</a>
		</div>
		<?php endwhile; else:?>
		<?php endif;?>
		
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		<div class="clear"></div>
		</div>	
	

<?php get_sidebar(); ?>

<?php get_footer(); ?>