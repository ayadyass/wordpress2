<?php get_header(); ?>
<div class="contentLayout">
<div class="content">


<div class="Block">
  <div class="Block-body">


<div class="BlockContent">
  <div class="BlockContent-body">

<h2>Archives by Month:</h2>
<ul><?php wp_get_archives('type=monthly'); ?></ul>
<h2>Archives by Subject:</h2>
<ul><?php wp_list_categories(); ?></ul>

  </div>
</div>


  </div>
</div>


</div>
<div class="sidebar1">

					<?php include (TEMPLATEPATH . '/sidebar1.php'); ?>
					
</div>

</div>

<?php get_footer(); ?>