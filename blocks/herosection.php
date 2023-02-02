<?php
//Blocco hero-section
function herosection_render( $output, $attributes ) { ?>
	<?php ob_start(); ?>
		<div class="lazyblock-hero-section">
			<?= $attributes['container-hero']?>
		</div>
	<?php return ob_get_clean();
}
add_filter( 'lazyblock/herosection/frontend_callback', 'herosection_render', 10, 2 );