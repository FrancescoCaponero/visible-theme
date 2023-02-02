<?php get_header(); ?>

	<?php while (have_posts()) : the_post(); ?>
		<article class="page-stories">
			<?php the_content(); 
			$args = array(
			'post_type' => 'stories',
			'posts_per_page' => -1
			);
			$cpt_posts = new WP_Query( $args );
			if ( $cpt_posts->have_posts() ) {
				while ( $cpt_posts->have_posts() ) {
				  $cpt_posts->the_post();
				  ?>
				  <img src="<?php echo the_post_thumbnail_url('large'); ?>">
				  <?php the_title(); ?>
				  <?php
				}
				wp_reset_postdata();
			  }
			  ?>
		</article>
	<?php endwhile; ?>
	

<?php get_footer(); ?>