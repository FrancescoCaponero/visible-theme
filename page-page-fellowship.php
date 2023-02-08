<?php get_header(); ?>
	<?php the_content(); ?>
	<article class="page-fellowship">
		<?php
		$args = array(
		'post_type' => 'fellowship',
		'posts_per_page' => -1,
		'orderby' => 'meta_value',
		'order' => 'ASC'
		);
		$cpt_posts = new WP_Query( $args );
		?>
		<div class="page-fellowship-wrapper">
		<?php
		if ( $cpt_posts->have_posts() ) {
			while ( $cpt_posts->have_posts() ) {
				$cpt_posts->the_post();
		?>
			<div class="page-fellowship-container">
				<div  class="page-fellowship-container__text-wrap">
					<h2><?php the_title(); ?></h2>
					<button class="blk-btn-small">
						<a href="<?php the_permalink(); ?>">Read More</a>
					</button>
				</div>
			</div>
			<?php
			}
			wp_reset_postdata();
			}
			?>
			</div>
	</article>	
<?php get_footer(); ?>