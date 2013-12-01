				<div id="sidebar1" class="sidebar col four mobile-full" role="complementary">

					<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar1' ); ?>

					<?php else : ?>

						<?php // This content shows up if there are no widgets defined in the backend. ?>

						<div class="alert alert-help">
							<p><?php _e( 'Please activate some Widgets.', 'baretheme' );  ?></p>
						</div>

					<?php endif; ?>

				</div>