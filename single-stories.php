<?php get_header(); ?>
	<?php if ( $cpt_posts->have_posts() ) {
		while ( $cpt_posts->have_posts() ) {
		$cpt_posts->the_post();
		$subtitle = rwmb_meta('sottotitolo');
		$images = rwmb_meta( 'image-spotlight', ['size' => 'large'] );
		$image = reset( $images );
	?>
	<article class="">
		<p class=""><?php echo get_the_date('j F Y'); ?></p>
		<h1 class="" id="post-<?php the_ID(); ?>"> <?php the_title(); ?>ciao sono single stories</h1>
	</article>
	<?php
		}
		wp_reset_postdata();
		}
	?>
<?php get_footer(); ?>