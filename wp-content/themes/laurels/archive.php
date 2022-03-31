<?php 
/*
 * Archive Template File.
 */
get_header(); ?>
<section>	
    <div class="laurels_menu_bg">
    	<div class="webpage-container container">
       	<div class="laurels_menu">
     	<h1><?php  if ( have_posts() ) : esc_html_e('Archives','laurels'); echo " : ". get_the_date('M-Y');  endif;?></h1>
	    <div class="breadcrumb site-breadcumb">
			<?php if (function_exists('laurels_custom_breadcrumbs')) laurels_custom_breadcrumbs(); ?>
        </div>
       </div>
   	</div>
  </div>
   <div class="container webpage-container">
      <article class="blog-article">    
         <?php $custom_class = (get_theme_mod('post_sidebar_layout', 'right') == 'left') ? "9" : ((get_theme_mod('post_sidebar_layout', 'right') == 'right') ? "9" : "12");  
          if ( get_theme_mod( 'post_sidebar_layout','right'  ) == "left" ) { ?>
                <div class="left-side-cls">
               <?php get_sidebar(); ?>
             </div>
          <?php } ?>    
            <div class="col-md-<?php echo esc_attr($custom_class); ?> col-sm-8 blog-page">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
                <div class="blog">                
                    <div class="blog-data">
                        <div class="blog-date text-center">
                            <h2 class="color_txt"> <?php echo get_the_date('d'); ?></h2>
                            <h3><?php echo get_the_date('M'); ?></h3>
                        </div>
                        <div class="blog-info">
                            <a href="<?php echo  esc_url(get_permalink()); ?>" class="heading"><?php the_title(); ?></a>
                            <div class="breadcrumb blog-breadcumb">
                              <?php if ( get_theme_mod( 'hide_post_meta_tag' ) == "" ) { 
                                    laurels_entry_meta(); } ?>
                            </div>
                         </div>
                         <?php
                            if ( get_theme_mod( 'hide_post_image' ) == "" ) { 
                           if ( has_post_thumbnail() ) { ?>
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                              <?php the_post_thumbnail('',array( 'class' => 'img-responsive' )); ?>
                            </a>
                            <?php } } ?>
                        <div class="blog-content">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>  
    <?php endwhile; endif; // end of the loop. ?>
        <div class="col-md-12 laurels-default-pagination">
            <?php
             the_posts_pagination( array(
            'type'  => 'div',
            'screen_reader_text' => ' ',
            'prev_text'          => esc_html__( '<< Previous', 'laurels' ),
            'next_text'          => esc_html__('Next >>','laurels'),
            ) ); ?>
        </div>
      </div>
       <?php 
        if ( get_theme_mod( 'post_sidebar_layout','right'  ) == "right" ) {
             get_sidebar();
        } ?> 
      </article>
    </div>
</section>
<?php get_footer();