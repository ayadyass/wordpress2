<form method="get" action="<?php bloginfo('url'); ?>/" class="searchform">
<fieldset>
<input type="text" value="<?php the_search_query(); ?>" name="s" class="searchterm" style="border:1px solid #eee;" />
<input type="submit" value="Search" class="searchbutton" />
</fieldset>
</form>