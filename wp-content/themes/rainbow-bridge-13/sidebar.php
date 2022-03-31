<script type="text/javascript"><!--
google_ad_client = "pub-7326145087652185";
google_ad_width = 160;
google_ad_height = 600;
google_ad_format = "160x600_as";
google_ad_type = "text";
google_ad_channel = "1234567891";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "003399";
google_color_text = "333333";
google_color_url = "999999";
//--></script>

<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
	<div id="sidebar" class="sidebars">
		<ul>
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ){
			?>
			<?
			} else { ?>	
            
			<li class="widget_categories">
                <h2>Pages</h2>
                <ul>
                    <?php wp_list_pages('sort_column=menu_order&title_li='); ?>
                </ul>
            </li>
            
			<li class="widget_categories">
                <h2>Category</h2>
                <ul>
                    <?php wp_list_cats('sort_column=name&optioncount=1'); ?>
                </ul>
            </li>

			<li class="widget_archives"><h2>Archives</h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

		<?php } ?>
            
			<li class="widget_archives"><h2>Meta</h2>
				<ul>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>


					<?php wp_meta(); ?>
				</ul>
			</li>

            

        </ul>


	</div>
< br >
<script type="text/javascript"><!--
google_ad_client = "pub-7370616206770089";
/* 300x250, created 12/05/11 */
google_ad_slot = "0998634990";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
< /div>

