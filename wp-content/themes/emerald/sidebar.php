				<div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary">

					<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar-1' ); ?>

					<?php else : ?>

						

						<div class="alert alert-help">
							<p><?php _e("Please activate some Widgets.", "emeraldtheme");  ?></p>
						</div>

					<?php endif; ?>

				</div>