<?php
/*
 * Main Sidebar File.
 */ ?>
<div class="col-md-3 col-sm-4 no-padding-left main-sidebar">
	<div class="sidebar-widgets">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : dynamic_sidebar( 'sidebar-1' ); endif; ?>
	</div>
</div>