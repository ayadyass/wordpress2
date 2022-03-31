<div class="sidebar1">
<ul>

	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

	<?php if (function_exists('get_highest_rated')): ?>
	<li><h2>Top Rated Posts</h2>
	<ul>
	<?php get_highest_rated('post', 1, 5); ?>
	</ul>
	</li>
	<?php endif; ?>

	<?php if (function_exists('get_most_viewed')): ?>
	<li><h2>Popular Posts</h2>
	<ul>
	<?php get_most_viewed('post', 5); ?>
	</ul>
	</li>
	<?php endif; ?>
	
	<?php endif; ?>

</ul>
</div>