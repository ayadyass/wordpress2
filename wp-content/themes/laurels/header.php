<?php
/*
 * Header For Laurels Theme.
 */
$laurels_options = get_option('laurels_theme_options'); ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
  <!--<![endif]-->
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
      wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <header>
      <div class="header_top">
        <div class="container webpage-container">
          <div class="col-md-12 no-padding top-header">
            <div class="col-md-6 col-sm-4"></div>      
            <?php $SocialIconDefault = array(
            array('url'=>isset($laurels_options['facebook'])?$laurels_options['facebook']:'','icon'=>'fa-facebook'),
            array('url'=>isset($laurels_options['twitter'])?$laurels_options['twitter']:'','icon'=>'fa-twitter'),
            array('url'=>isset($laurels_options['pinterest'])?$laurels_options['pinterest']:'','icon'=>'fa-pinterest'),
            array('url'=>isset($laurels_options['googleplus'])?$laurels_options['googleplus']:'','icon'=>'fa-google-plus'),
            array('url'=>isset($laurels_options['rss'])?$laurels_options['rss']:'','icon'=>'fa-rss'),
            array('url'=>isset($laurels_options['linkedin'])?$laurels_options['linkedin']:'','icon'=>'fa-linkedin'),
            ); 
            $social_links_flag=""; 
            for($i=1; $i<=6; $i++) : 
                if(get_theme_mod('SocialIconLink'.$i,$SocialIconDefault[$i-1]['url'])!='' && get_theme_mod('SocialIcon'.$i,$SocialIconDefault[$i-1]['icon'])!=''):
                 $social_links_flag=true; 
                endif;
            endfor; ?>   
            <?php if($social_links_flag != ''){ ?>
            <div class="col-md-4 col-sm-5">            
              <ul class="list-inline logo_div">
                <?php for($i=1; $i<=6; $i++) : 
                        if(get_theme_mod('SocialIconLink'.$i,$SocialIconDefault[$i-1]['url'])!='' && get_theme_mod('SocialIcon'.$i,$SocialIconDefault[$i-1]['icon'])!=''): ?>
                       <li><a href="<?php echo esc_url(get_theme_mod('SocialIconLink'.$i,$SocialIconDefault[$i-1]['url'])); ?>" class="icon" title="" target="_blank">
                            <i class="fa <?php echo esc_attr(get_theme_mod('SocialIcon'.$i,$SocialIconDefault[$i-1]['icon'])); ?>"></i>
                        </a></li>
                <?php endif; endfor;?> 
              </ul>    
            </div>      
            <?php } ?>        
            <div class="col-md-2 col-sm-3  no-padding search-box">       	
              <form method="get" id="searchform" action="<?php echo esc_url(home_url()); ?>/">
                <input type="text" class="input-medium search-query search-input" name="s" placeholder="<?php esc_html_e('Search..', 'laurels'); ?>" id="s" value="<?php the_search_query(); ?>">
                <button type="submit" class="add-on" id="searchsubmit">
                  <span class="fa fa-search"></span>
                </button>      
              </form>              
            </div>                				
          </div>            
        </div>
      </div>
      <div class="header_bottom">
        <div class="container webpage-container">
          <div class="col-md-12 no-padding "> 
            <div class="header_menu">    
              <div class="col-sm-2 col-md-2 logo-display  no-padding">
                <?php
                if(has_custom_logo() ): 
                  the_custom_logo();
                endif; 
                if(display_header_text()){ ?>
                  <h1 class="laurels-site-name"><a href="<?php echo esc_url(get_site_url()); ?>"><?php echo esc_html(get_bloginfo('name')); ?></h1>
                  <p class="laurels-tagline"><?php echo esc_html(get_bloginfo('description')); ?></p></a>
                <?php } ?>
              </div>    
              <div class="col-sm-10 col-md-10 no-padding">                  
                <nav class="navbar-default main_menu navigation-deafault" role="navigation">
                  <div class="navbar-header res-nav-header toggle-respon">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                  </div>
                  <?php
                  $laurels_defaults = array(
                      'theme_location' => 'primary',
                      'container' => 'div',
                      'container_class' => 'collapse navbar-collapse nav_coll main-menu-ul no-padding',
                      'container_id' => '',
                      'menu_class' => 'collapse navbar-collapse nav_coll main-menu-ul no-padding',
                      'menu_id' => '',
                      'echo' => true,
                      'fallback_cb' => 'wp_page_menu',
                      'before' => '',
                      'after' => '',
                      'link_before' => '',
                      'link_after' => '',
                      'items_wrap' => '<ul>%3$s</ul>',
                      'depth' => 0,
                      'walker' => ''
                  );
                  wp_nav_menu($laurels_defaults); ?>
                </nav>	             
              </div>
            </div>				
          </div>
        </div> 
      </div>                
    </header>