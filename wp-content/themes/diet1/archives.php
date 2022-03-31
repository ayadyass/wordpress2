<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

	<div class="column mid ">
<?php include (TEMPLATEPATH . "/sidebar_left.php"); ?>
<div class="column content_column content ">

	<div id="content">

<?php include (TEMPLATEPATH . '/searchform.php'); ?>

<h2>Archives by Month:</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

<h2>Archives by Subject:</h2>
	<ul>
		 <?php wp_list_categories(); ?>
	</ul>


		</div>
	</div>


<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

