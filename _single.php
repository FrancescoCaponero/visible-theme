<?php get_header(); ?>

	<?php while (have_posts()) : the_post(); ?>
		<article class="single">
			<h1 class="single-title" id="post-<?php the_ID(); ?>"> <?php the_title(); ?></h1>
		<?php the_content(); ?>
		</article>
	<?php endwhile; ?>

<?php get_footer(); ?>