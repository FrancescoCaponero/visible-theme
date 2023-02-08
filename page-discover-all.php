<?php get_header(); ?>
<div class="page-discover-all">
<?php
	$args = array(
		'post_type' => array('spotlight' , 'fellowship' , 'parliaments', 'Discover All' ),
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'meta_value',
		'order' => 'DESC'
		);
		$cpt_posts = new WP_Query( $args );
	if ( $cpt_posts->have_posts() ) {
		while ( $cpt_posts->have_posts() ) {
		$cpt_posts->the_post();
		?>
		<div class="page-discover-all">
				<h2 class="page-discover-all__title"><?php the_title(); ?></h2>
				<div class="page-discover-all__taxonomies">
					<?php 
					$terms = get_the_terms(get_the_ID(), 'Discover All');
					if ($terms) {
						echo '<ul class="term-discover-all">';
						foreach ($terms as $term) {
							$term_link = get_term_link($term);
							$term_color = get_term_meta($term->term_id);
							$term_single_color = $term_color['color_8m4dc2b2uij'][0];
							print_r($term_link);
							echo '<li class="term-discover-all__single-tax" style="border-color:' . $term_single_color . ';"><a href="' . $term_link . '">' . $term->name . '</a></li>';
						}
						echo '</ul>';
						}
					?>
				<p class="page-discover-all__date"><?php echo get_the_date('j F Y'); ?></p>
			</div>
		</div>
			<?php
		}
		wp_reset_postdata();
		}
?>
</div>
<?php get_footer(); ?>