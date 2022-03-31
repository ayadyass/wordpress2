<?php 
/*
 * Single Post Template File.
 */
get_header(); ?>
<section>   
    <div class="laurels_menu_bg">
        <div class="webpage-container container">
            <div class="laurels_menu">
            <h1><?php the_title(); ?></h1>
            <div class="breadcrumb site-breadcumb">
                <?php if (function_exists('laurels_custom_breadcrumbs')) laurels_custom_breadcrumbs(); ?>
            </div>
            </div>
        </div>
    </div>
    <div class="container webpage-container">
        <article class="blog-article">     
        <?php
        $custom_class = (get_theme_mod('single_post_sidebar_layout', 'right') == 'left') ? "9" : ((get_theme_mod('single_post_sidebar_layout', 'right') == 'right') ? "9" : "12");  
        if ( get_theme_mod( 'single_post_sidebar_layout','right'  ) == "left" ) { ?>
        <div class="left-side-cls">
           <?php get_sidebar(); ?>
        </div>
        <?php } ?>   
    <div id="post-<?php the_ID(); ?>" <?php post_class("col-md-$custom_class col-sm-8 blog-page"); ?>> 
      <?php while ( have_posts() ) : the_post(); ?>
                <div class="blog">
                    <div class="blog-data">
                        <div class="blog-date text-center">
                            <h2 class="color_txt"> <?php echo get_the_date('d'); ?></h2>
                            <h3><?php echo get_the_date('M'); ?></h3>
                        </div>
                        <div class="blog-info">
                            <h2><?php the_title(); ?></h2>
                            <?php if ( get_theme_mod( 'hide_single_post_meta_tag' ) == "" ) {  ?>
                            <div class="breadcrumb blog-breadcumb">
                               <?php laurels_entry_meta(); ?>   
                            </div>
                            <?php } ?>
                        </div>
                        <div class="blog-rightsidebar-img">
                    <?php 
                      if ( get_theme_mod( 'hide_single_post_image' ) == "" ) { 
                       if ( has_post_thumbnail() ) { ?>
                          <?php the_post_thumbnail('',array( 'class' => 'img-responsive' )); ?>
                    <?php } } ?>
                    </div>
                        <div class="blog-content">
                            <?php the_content();
                                wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'laurels' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                            ) ); ?>
                        </div>
                    </div>
                </div> 
          <?php endwhile; ?>  
          <div class="col-md-12 laurels-default-pagination">
            <span class="laurels-previous-link"><?php previous_post_link(); ?></span>
            <span class="laurels-next-link"><?php next_post_link(); ?></span>
          </div>     
          <?php if ( get_theme_mod( 'hide_single_post_comment_form' ) == "" ){ ?>
                <div class="comments">
                     <?php  comments_template( '', true ); ?>
                </div>              
        <?php } ?>
            </div>
          <?php if ( get_theme_mod( 'single_post_sidebar_layout','right'  ) == "right" ) {
                 get_sidebar();
            } ?>
        </article>
    </div>
</section>
<?php get_footer();