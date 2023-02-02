<?php get_header(); ?>

	<?php while (have_posts()) : the_post(); ?>
		<article class="page-stories">
			<?php the_content(); 
			$args = array(
			'post_type' => 'stories',
			'posts_per_page' => -1,
			'orderby' => 'meta_value',
			'order' => 'ASC'
			);
			$cpt_posts = new WP_Query( $args );
			?>
			<div class="page-stories-wrapper">
			<?php
			if ( $cpt_posts->have_posts() ) {
				while ( $cpt_posts->have_posts() ) {
				  $cpt_posts->the_post();
				  $subtitle = rwmb_meta('sottotitolo');
				  $color = rwmb_meta('colore_del_topic');
				  ?>
				<div class="page-stories-container">
					<div class="page-stories-container__img-wrap">
						<img src="<?php echo the_post_thumbnail_url('large'); ?>">
					</div>
				    <div  class="page-stories-container__text-wrap">
						<h2><?php the_title(); ?></h2>
						<p><?php echo $subtitle ?></p>
						<button class="blk-btn-small">
							<a href="<?php the_permalink(); ?>">Read More</a>
						</button>
						<span data-color="<?php echo $color ?>"></span>
				    </div>
				</div>
				  <?php
				}
				wp_reset_postdata();
			  }
			  ?>
			  </div>
		</article>
	<?php endwhile; ?>
	

<?php get_footer(); ?>