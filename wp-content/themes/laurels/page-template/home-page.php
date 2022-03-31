  <?php 
/*
 * Template Name: Home Page 
 */
get_header();
$laurels_options = get_option( 'laurels_theme_options' ); ?>
<section>
  <?php 
  if(get_theme_mod('hide_slider_section') == ''){ ?>
   <div class="banner">     
         <!--Carousel-->
          <div id="sidebar-carousel-1" class="carousel slide " data-ride="carousel">
      <div class="carousel-inner">
        <?php 
        $laurels_first_slide=0;
        for($laurels_loop=1;$laurels_loop<=5;$laurels_loop++){ 
        $image_url = wp_get_attachment_url(get_theme_mod('slider_image_'.$laurels_loop)); 
        if(get_theme_mod('slider_image_'.$laurels_loop) != ''){
          $image_url = wp_get_attachment_url(get_theme_mod('slider_image_'.$laurels_loop));
        }else{
          $image_url=$laurels_options['slider-img-'.$laurels_loop];
        }
        if($image_url != ""){ ?>
        <div <?php  echo ($laurels_first_slide == 0) ? "class='item active'" : "class='item'"; ?> >
                  <?php if(get_theme_mod('slide_link_'.$laurels_loop,isset($laurels_options['slidelink-'.$laurels_loop])?$laurels_options['slidelink-'.$laurels_loop]:'') != '') { ?>
                <a href="<?php echo esc_url(get_theme_mod('slide_link_'.$laurels_loop,isset($laurels_options['slidelink-'.$laurels_loop])?$laurels_options['slidelink-'.$laurels_loop]:''));?>" target="_blank"><img src="<?php echo esc_url($image_url); ?>" alt="" /></a>
              <?php }else{?>
              <img src="<?php echo esc_url($image_url); ?>" alt="" />
              <?php } ?>
                </div>
            <?php $laurels_first_slide++; } } ?>
      </div>
             <!-- Controls -->
            <?php if($laurels_first_slide > 1){ ?>
            <a class="left carousel-control slider_button" href="#sidebar-carousel-1" data-slide="prev">
              <i class='fa fa-angle-left'></i>
            </a>
            <a class="right carousel-control slider_button" href="#sidebar-carousel-1" data-slide="next">
              <i class='fa fa-angle-right'></i>
            </a>
            <?php } ?>
    </div><!--/Carousel-->
    </div>
    <?php } ?> 
    <div class="container webpage-container">
     <?php if(get_theme_mod('hide_about_us') == ''){ ?>
      <div class="section_row_1 text-center col-md-12">
          <h2><?php if(get_theme_mod('about_us_title',isset($laurels_options['home-title'])?$laurels_options['home-title']:'About Us') != '') { echo esc_html(get_theme_mod('about_us_title',isset($laurels_options['home-title'])?$laurels_options['home-title']:'WELCOME TO LAURELS WORDPRESS THEME')); } ?></h2>
          <p><?php echo esc_html(get_theme_mod('about_us_description',isset($laurels_options['home-content'])?$laurels_options['home-content']:'Lorem Ispum Lorem Ispum Lorem Ispum Lorem Ispum')); ?></p>              
        </div>
 
        <?php } 
          if(get_theme_mod('hide_key_features') == ''){ ?>
     <div class="section_row_2 col-md-12 no-padding">         
    <?php for($laurels_loop=1 ; $laurels_loop <=4 ; $laurels_loop++): ?>
         <?php        
          if(get_theme_mod('key_features_section_tab_icon'.$laurels_loop) != ''){
            $image_url = wp_get_attachment_url(get_theme_mod('key_features_section_tab_icon'.$laurels_loop));
          }else{
            $image_url=$laurels_options['home-icon-'.$laurels_loop];
          }
           if($image_url != '') { ?>
            <div class="col-sm-6 col-md-3">
                <div class="img_inline text-center center-block">
          
            <div class="row_img">
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" class="img-circle"  />
           
            <?php if((get_theme_mod('key_features_section_tab_title'.$laurels_loop,isset($laurels_options['section-title-'.$laurels_loop])?$laurels_options['section-title-'.$laurels_loop]:'') !='')|| (get_theme_mod('key_features_section_tab_subtitle'.$laurels_loop,isset($laurels_options['section-post-'.$laurels_loop])?$laurels_options['section-post-'.$laurels_loop]:'') !='')) 
              { 
                echo "<p>";
                echo esc_html(get_theme_mod('key_features_section_tab_title'.$laurels_loop,isset($laurels_options['section-title-'.$laurels_loop])?$laurels_options['section-title-'.$laurels_loop]:'')); 
             ?>
              <span> <?php if(get_theme_mod('key_features_section_tab_subtitle'.$laurels_loop,isset($laurels_options['section-post-'.$laurels_loop])?$laurels_options['section-post-'.$laurels_loop]:'') !='') 
                { 
                  echo esc_html(get_theme_mod('key_features_section_tab_subtitle'.$laurels_loop,isset($laurels_options['section-post-'.$laurels_loop])?$laurels_options['section-post-'.$laurels_loop]:'')); 
                } ?></span>
                </p>
                <?php } ?>
              </div>
              <div class="row_content">
                  <p> <?php if(get_theme_mod('key_features_section_tab_description'.$laurels_loop,isset($laurels_options['section-content-'.$laurels_loop])?$laurels_options['section-content-'.$laurels_loop]:'') != '') 
                    { 
                      echo esc_html(get_theme_mod('key_features_section_tab_description'.$laurels_loop,isset($laurels_options['section-content-'.$laurels_loop])?$laurels_options['section-content-'.$laurels_loop]:'')); 
                    } ?></p>
              </div>
              </div>
            </div>   
            <?php } ?>
      <?php endfor; ?> 
    </div>   
    <?php } ?>
   </div>
   <?php if(get_theme_mod('hide_recent_posts') == ''){
       if(get_theme_mod('recent_posts_section_category',isset($laurels_options['post-category'])?$laurels_options['post-category']:'1') != ''){ ?>
    <div class="container webpage-container">
        <div class="section_row_3">                           
            <div class="col-md-12 title lx no-padding">
              <h3><?php 
                echo esc_html(get_theme_mod('recent_posts_section_title',isset($laurels_options['homeblogtitle'])?$laurels_options['homeblogtitle']:'Recent Posts')); ?>
                </h3>
            </div>
            <div class="row">
            <?php $laurels_args = array(
            'cat'  => get_theme_mod('recent_posts_section_category',isset($laurels_options['post-category'])?$laurels_options['post-category']:'1'),
            'meta_query' => array(
            array(
              'key' => '_thumbnail_id',
              'compare' => 'EXISTS'
              ),
            ) );  
            $laurels_query=new $wp_query($laurels_args);
        if ( $laurels_query->have_posts() ) { ?>  
      <div class="gallary">
        <?php while($laurels_query->have_posts()) {  $laurels_query->the_post();
          $laurels_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'laurels-home-thumbnail-image', true ); ?>
                    <div class="col-sm-6 col-md-4">
                      <div class="box">
                          <div class="gallery-img">
                            <?php if ( has_post_thumbnail() ) { ?>
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                              <?php the_post_thumbnail('laurels-home-thumbnail-image'); ?>
                            </a>
                            <?php } ?>
                            </div>
                            <div class="prod_detail">
                                <h5><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_title(); ?></a></h5>  
                            </div>                        
                        </div>                      
                    </div>
                    <?php } ?>
            </div>
            <?php } else { echo '<p class="no-post-found-cls">no posts found</p>'; } ?>
            </div>            
        </div>  
    </div>
  <?php } } 
   if(get_theme_mod('hide_our_latest_posts') == ''){
    if(get_theme_mod('our_latest_section_category','1') != ''){
  ?>
    <div class="container webpage-container">   
        <div class="section_row_4">
          <div class="header_line">          
                <div class="col-md-12 title no-padding">
                <h3>
                <?php 
                echo esc_html(get_theme_mod('our_latest_section_title',isset($laurels_options['latestpost-title'])?$laurels_options['latestpost-title']:'Our Latest Posts')); ?>
                </h3>
                </div>                               
                <div class="customNavigation">
                    <a class="btn prev btn-default btn_lr">
                    <i class="fa fa-angle-left"></i></a>
                    <a class="btn next btn-default btn_lr">
                    <i class="fa fa-angle-right"></i></a>
                </div>                 
            </div> 
            <div class="media_blog">
            <div class="" id="laurels_slide">                    
     <?php $laurels_args = array(
      'cat'  => get_theme_mod('our_latest_section_category',''),
          'orderby'      => 'post_date', 
          'order'        => 'DESC',
          'post_type'    => 'post',
          'post_status'    => 'publish' 
          );
    $laurels_query = new WP_Query($laurels_args);
    if ($laurels_query->have_posts() ) : while ($laurels_query->have_posts()) : $laurels_query->the_post();  ?>
      <div class="owl-item">
                        <div class="media media_left">
                          <?php if ( has_post_thumbnail() ) { ?>
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                              <?php the_post_thumbnail('laurels-home-latestpost-thumbnails'); ?>
                            </a>
                            <?php } ?>
                            <div class="media-body"> 
                            <h4 class="media-heading"> <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4> 
                            <?php the_excerpt(); ?>
                            </div> 
                        </div>
                    </div>
                 <?php endwhile; endif; // end of the loop. ?>   
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>
</section>
<?php get_footer();