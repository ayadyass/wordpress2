
<?php if (!art_sidebar(1)): ?>

<div class="Block">
  <div class="Block-body">
<div class="BlockHeader">
Search
  <div class="l"></div>
  <div class="r"><div></div></div>
</div>

<div class="BlockContent">
  <div class="BlockContent-body">
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" style="width: 95%;" />

<button class="Button" type="submit" name="search">
  <span class="btn">
    <span class="t">Search</span>
    <span class="r"><span></span></span>
    <span class="l"></span>
  </span>
</button>

</form>

  </div>
</div>

  </div>
</div>

<div class="Block">
  <div class="Block-body">
<div class="BlockHeader">
Categories
  <div class="l"></div>
  <div class="r"><div></div></div>
</div>

<div class="BlockContent">
  <div class="BlockContent-body">
<ul>
  <?php wp_list_categories('show_count=1&title_li='); ?>
</ul>
  </div>
</div>

  </div>
</div>

<div class="Block">
  <div class="Block-body">
<div class="BlockHeader">
Bookmarks
  <div class="l"></div>
  <div class="r"><div></div></div>
</div>

<div class="BlockContent">
  <div class="BlockContent-body">
<ul>
      <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
      </ul>
  </div>
</div>

  </div>
</div>

<div class="Block">
  <div class="Block-body">
<div class="BlockHeader">
Archive
  <div class="l"></div>
  <div class="r"><div></div></div>
</div>

<div class="BlockContent">
  <div class="BlockContent-body">
     <?php if ( is_404() || is_category() || is_day() || is_month() ||
            is_year() || is_search() || is_paged() ) {
      ?>
      <?php /* If this is a 404 page */ if (is_404()) { ?>
      <?php /* If this is a category archive */ } elseif (is_category()) { ?>
      <p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>

      <?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
      <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
      for the day <?php the_time('l, F jS, Y'); ?>.</p>

      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
      for <?php the_time('F, Y'); ?>.</p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
      for the year <?php the_time('Y'); ?>.</p>

      <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
      <p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
      for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

      <?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>

      <?php } ?>

      <?php }?>
      
      <ul>
      <?php wp_get_archives('type=monthly&title_li='); ?>
      </ul>
    
  </div>
</div>

  </div>
</div>

<?php endif ?>