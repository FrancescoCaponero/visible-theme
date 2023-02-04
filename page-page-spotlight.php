<?php get_header(); ?>
		<article class="page-spotlight">
			<?php the_content(); ?>

			<?php
				// First template part for a single post
				get_template_part('parts/single-post-spotlight');

				// Second template part for the remaining posts
				get_template_part('parts/remain-posts-spotlight');
				?>
			
		</article>
<?php get_footer(); ?>