<?php get_header(); ?>


<div id="main">
	<div id="featured_content">
	<?php
	$args = "cat=".$intaglio->option['featured']."&showposts=1";
	query_posts($args);
	while(have_posts()) : the_post();
	?>
		<a href="<?php the_permalink(); ?>">
		<?php
		$featured_thumb = get_post_meta($post->ID,'thumbnail', TRUE);
				
				if($featured_thumb!=""){
				?>
				<img src="<? echo get_post_meta($post->ID,'thumbnail', TRUE); ?>" alt="<?php the_title(); ?>"/>
				<?php
				}else{
				?>
				<img src="<?php echo get_settings('home'); ?>/wp-content/themes/intaglio/images/thumb.gif" alt="<?php the_title(); ?>"/>
				<?php
				}
				?>

		</a>
		<div id="post_summary">
		<h3>Featured Content</h3>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php the_excerpt(); ?>
		</div>
	<?php endwhile; ?>
	<div class="clear"></div>
	</div>
	<div id="content">
		<div id="reading">
			
		<?php 
		query_posts('showposts=5');
		while(have_posts()) : the_post(); ?>
		<div class="post_excerpt">
		<span class="date"><?php the_time('<\e\m>j</\e\m> M <\e\m>Y</\e\m>'); ?></span>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="comment_count"><?php comments_popup_link('0', '1', '%'); ?><span></h2>
		<span class="post_meta">Posted in: <?php the_category('&bull;'); ?></span>
		<span class="post_meta_tags"><br/><?php the_tags('Tags: ', ' &bull; ', '<br />'); ?></span>
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>" class="read_more">Read More</a>
		</div>
		<?php endwhile; ?>
			
		</div>	
	

<?php get_sidebar(); ?>

<?php get_footer(); ?>