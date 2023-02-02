<?php
//Blocco hero-btn
function herobtn_render( $output, $attributes ) { ?>
	<?php ob_start(); ?>
		<button class="lazyblock-hero-btn read-more-btn-black">
			<a href="#">Read more</a>
		</button>
	<?php return ob_get_clean();
}
add_filter( 'lazyblock/herobtn/frontend_callback', 'herobtn_render', 10, 2 );