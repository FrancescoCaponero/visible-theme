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
				<h2 class="page-spotlight-post-remain__title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<p class="page-spotlight-post-remain__subtitle"><?php echo $subtitle; ?></p>
				<div class="page-spotlight-post-remain__taxonomies">
					<?php 
					$terms = get_the_terms(get_the_ID(), 'Discover All');
					if ($terms) {
						echo '<ul class="term-discover-all">';
						foreach ($terms as $term) {
							$term_link = get_term_link($term);
							$term_color = get_term_meta($term->term_id);
							$term_single_color = $term_color['color_8m4dc2b2uij'][0];
							echo '<li class="term-discover-all__single-tax " style="border-color:' . $term_single_color . ';">';
							echo '<a href="' . $term_link . '">' . $term->name . '</a>';
							echo '</li>';
							}
						echo '</ul>';
						}
					?>
				</div>
				<p class="page-spotlight-post-remain__date"><?php echo get_the_date('j F Y'); ?></p>

		</div>
			<?php
		}
		wp_reset_postdata();
		}
?>
</div>
<button class="load-more-spotlight blk-btn-small">
	<a>
		LOAD MORE
	</a>
</button>