<div class="page-spotlight-wrapper-remain">
<?php
	$args = array(
		'post_type' => 'spotlight',
		'posts_per_page' => -1,
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'showposts'     => 6,
		'offset'        => 1,
		);
		$cpt_posts = new WP_Query( $args );
	if ( $cpt_posts->have_posts() ) {
		while ( $cpt_posts->have_posts() ) {
		$cpt_posts->the_post();
		$subtitle = rwmb_meta('sottotitolo');
		$images = rwmb_meta( 'image-spotlight', ['size' => 'large'] );
		$image = reset( $images );
		?>
		<div class="page-spotlight-post-remain">
			<div class="page-spotlight-post-remain__img-wrap">
				<img src="<?= $image['url']; ?>">
			</div>
				<h2 class="page-spotlight-post-remain__title"><?php the_title(); ?></h2>
				<p class="page-spotlight-post-remain__subtitle"><?php echo $subtitle; ?></p>
				<div class="page-spotlight-post-remain__taxonomies">
					<?php 
					$terms = get_the_terms(get_the_ID(), 'Discover All');
					if ($terms) {
						echo '<ul>';
						foreach ($terms as $term) {
							$term_link = get_term_link($term);
							print_r($term_link);
							echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
						}
						echo '</ul>';
						}
					?>
				<p class="page-spotlight-post-remain__date"><?php echo get_the_date('j F Y'); ?></p>
			</div>
		</div>
			<?php
		}
		wp_reset_postdata();
		}
?>
</div>