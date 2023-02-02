<?php get_header(); ?>

	<?php while (have_posts()) : the_post(); ?>
		<article class="page">
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
	

<?php get_footer(); ?>