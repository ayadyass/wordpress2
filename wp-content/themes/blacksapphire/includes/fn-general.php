<?php
/**
 * @package WordPress
 * @subpackage magazine_obsession
 */

/* Get ID of the page, if this is current page */

function obwp_get_page_id () {
	global $wp_query;

	if ( !$wp_query->is_page )
		return -1;

	$page_obj = $wp_query->get_queried_object();

	if ( isset( $page_obj->ID ) && $page_obj->ID >= 0 )
		return $page_obj->ID;

	return -1;
}

/**
 * Get Meta post/pages value
 * $type = string|int
 */
function obwp_get_meta($var, $type = 'string', $count = 0)
{
	$value = stripslashes(get_option($var));
	
	if($type=='string')
	{
		return $value;
	}
	elseif($type=='int')
	{
		$value = intval($value);
		if( !is_int($value) || $value <=0 )
		{
			$value = $count;
		}
		
		return $value;
	}
	
	return NULL;
}

/**
 * Get custom field of the current page
 * $type = string|int
 */
function obwp_getcustomfield($filedname, $page_current_id = NULL)
{
	if($page_current_id==NULL)
		$page_current_id = obwp_get_page_id();

	$value = get_post_meta($page_current_id, $filedname, true);

	return $value;
}
function the_title_limited($length = false, $before = '', $after = '', $echo = true)
{
	$title = get_the_title();

	if ( $length && is_numeric($length) )
	{
		$title = substr( $title, 0, $length );
	}
	if ( strlen($title)> 0 )
	{
		$title = apply_filters('the_title2', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}
if ( !function_exists('the_content_limit') ) 
{
function the_content_limit($max_char, $more_link_text = '', $use_p = false, $stripteaser = 0, $more_file = '')
{
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
	  if($use_p)
      	echo "<p>";
      echo $content;
	  if($use_p)
      	echo "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
	  	if($use_p)
       		echo "<p>";
        echo $content;
        echo "...";
	  	if($use_p)
        	echo "</p>";
   }
   else {
	  if($use_p)
      	echo "<p>";
      echo $content;
	  if($use_p)
      	echo "</p>";
   }
}
}

 
function theme_ads_show()
{
	global $shortname;
	$count = obwp_get_meta(SHORTNAME."_count_banner_125_125",'int');

	if($count>0)
	{
		for($i=1; $i<=$count; $i++)
		{
			$banner_url = obwp_get_meta(SHORTNAME.'_banner_125_125_url_'.$i);
			$banner_img = obwp_get_meta(SHORTNAME.'_banner_125_125_img_'.$i);
			$banner_title = obwp_get_meta(SHORTNAME.'_banner_125_125_title_'.$i);

			if(!empty($banner_url) && !empty($banner_img))
			{
			?><div><a href="<?php echo $banner_url; ?>" title="<?php echo $banner_title; ?>"><img src="<?php echo $banner_img; ?>" alt="<?php echo $banner_title; ?>" /></a></div><?php
			}
		}
	}
}

function theme_google_468_ads_show()
{
	$id = obwp_get_meta(SHORTNAME."_google_id");
	if(!empty($id))
	{
		echo $code = '<div class="banner"><script type="text/javascript"><!--
google_ad_client = "'.$id.'";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text"; 
google_color_border = "666666";
google_color_bg = "ffffff";
google_color_link = "f26521";
google_color_url = "f26521";
google_color_text = "333333"; 
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>';
	}
}

function theme_google_300_ads_show()
{
	$id = obwp_get_meta(SHORTNAME."_google_id");
	if(!empty($id))
	{
		echo $code = '<div class="banner_left"><script type="text/javascript"><!--
google_ad_client = "'.$id.'";
google_ad_width = 300;
google_ad_height = 250;
google_ad_format = "300x250_as";
google_ad_type = "text"; 
google_color_border = "c5c5c5";
google_color_bg = "ffffff";
google_color_link = "9d080d";
google_color_url = "9d080d";
google_color_text = "000000"; 
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>';
	}
}

function get_string_limit($output, $max_char)
{
    $output = str_replace(']]>', ']]&gt;', $output);
    $output = strip_tags($output);

  	if ((strlen($output)>$max_char) && ($espacio = strpos($output, " ", $max_char )))
	{
        $output = substr($output, 0, $espacio).'...';
		return $output;
   }
   else
   {
      return $output;
   }
}

function obwp_recent_comments($number = 10) {
	global $wpdb, $comments, $comment;

	$comments = $wpdb->get_results("SELECT comment_author, comment_author_url, comment_ID, comment_post_ID, comment_content FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT $number");
?>

        <ul><?php
		 $i=0;
		 $last = '';
        if ( $comments ) : foreach ($comments as $comment) :
		 $i++;
		if($i==$number) $last = 'last';
		$comment_content = strip_tags($comment->comment_content);
        echo  '<li class="recentcomments '.$last.'">' . sprintf(__('<b>%1$s</b> : <span>%2$s</span>'), get_comment_author_link(), '<a href="'. get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID . '">' . get_string_limit($comment_content, 200) . '</a>') . '</li>';
        endforeach; endif;?></ul>
<?php
}

function obwp_list_recent_posts($number = 10) {

	$posts = get_posts('cat='.EXCEPT_CAT.'&orderby=date&numberposts='.$number);
	
	?>
    <ul>
    <?
	$countposts = count($posts);
	for($i=0; $i<$countposts; $i++)
	{
		?>
        	<li <?php if($i==($countposts-1)) echo 'class="last"'; ?>><a href="<?=get_permalink($posts[$i]->ID)?>"><?=$posts[$i]->post_title?></a></li>
        <?
	}
	?>
    </ul>
    <?

}
function theme_twitter_show($count=4)
{
	$id = obwp_get_meta(SHORTNAME."_twitter_id");
	if(!empty($id))
	{
	?>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $id; ?>.json?callback=twitterCallback2&amp;count=<?php echo $count; ?>"></script>
	<?php
	}
}

?>