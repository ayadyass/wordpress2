<?php
/**
 * Footer
 */
$laurels_options = get_option( 'laurels_theme_options' ); ?>
<footer>
	<div class="section_bottom">
    	<div class="container webpage-container">
        	<div class="col-sm-4 col-md-4 no-padding column-footer">
				<div class="bottum_hr">
					<?php if ( is_active_sidebar( 'footer-1' ) ) {  dynamic_sidebar( 'footer-1' ); } ?>
                </div>            
            </div>
            <div class="col-sm-4 col-md-4 no-padding column-footer">
            	<div class="bottum_hr">
					<?php if ( is_active_sidebar( 'footer-2' ) ) {  dynamic_sidebar( 'footer-2' ); } ?>
				 </div>  
             </div>
            <div class="col-sm-4 col-md-4 no-padding column-footer">
            	<div class="bottum_hr">
					<?php if ( is_active_sidebar( 'footer-3' ) ) {  dynamic_sidebar( 'footer-3' ); } ?>
                 </div> 
            </div>
        </div>
   	</div>
	<div class="container webpage-container">
   		<div class="col-sm-6 col-md-8  no-padding bottom-footer">
               <?php if(get_theme_mod('footerCopyright',isset($laurels_options['footertext'])?$laurels_options['footertext']:'') != '') {
                 echo wp_kses_post(get_theme_mod('footerCopyright',isset($laurels_options['footertext'])?$laurels_options['footertext']:'')).' '; 
                }  ?>
			<span class='foot_txt text-left'>
                <?php esc_html_e('Powered By ','laurels'); ?>
                <a href="<?php echo esc_url('https://fasterthemes.com/wordpress-themes/laurels'); ?>"><?php esc_html_e(' Laurels WordPress Theme','laurels'); ?></a>
			</span>
        </div>
        <?php $SocialIconDefault = array(
            array('url'=>isset($laurels_options['facebook'])?$laurels_options['facebook']:'','icon'=>'fa-facebook facebook-hover'),
            array('url'=>isset($laurels_options['twitter'])?$laurels_options['twitter']:'','icon'=>'fa-twitter twitter-hover'),
            array('url'=>isset($laurels_options['pinterest'])?$laurels_options['pinterest']:'','icon'=>'fa-pinterest googleplus-hover'),
            array('url'=>isset($laurels_options['googleplus'])?$laurels_options['googleplus']:'','icon'=>'fa-google-plus googleplus-hover'),
            array('url'=>isset($laurels_options['rss'])?$laurels_options['rss']:'','icon'=>'fa-rss rss-hover'),
            array('url'=>isset($laurels_options['linkedin'])?$laurels_options['linkedin']:'','icon'=>'fa-linkedin linkedin-hover'),
            ); 
            $social_links_flag=""; 
            for($i=1; $i<=6; $i++) : 
                if(get_theme_mod('SocialIconLink'.$i,$SocialIconDefault[$i-1]['url'])!='' && get_theme_mod('SocialIcon'.$i,$SocialIconDefault[$i-1]['icon'])!=''):
                 $social_links_flag=true; 
                endif;
            endfor; ?>   
        <?php if($social_links_flag != ''){ ?>
        <div class="col-sm-6 col-md-4 no-padding bottom-footer">
        	<ul>
             <?php for($i=1; $i<=6; $i++) : 
                    if(get_theme_mod('SocialIconLink'.$i,$SocialIconDefault[$i-1]['url'])!='' && get_theme_mod('SocialIcon'.$i,$SocialIconDefault[$i-1]['icon'])!=''): ?>
                   <li><a href="<?php echo esc_url(get_theme_mod('SocialIconLink'.$i,$SocialIconDefault[$i-1]['url'])); ?>" class="icon" title="" target="_blank">
                        <i class="fa <?php echo esc_attr(get_theme_mod('SocialIcon'.$i,$SocialIconDefault[$i-1]['icon'])); ?>"></i>
                    </a></li>
            <?php endif; endfor;?> 
            </ul>
        </div>  
        <?php } ?>     
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>