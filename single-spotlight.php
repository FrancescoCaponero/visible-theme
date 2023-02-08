<?php get_header(); ?>
	<?php 
		$subtitle = rwmb_meta('sottotitolo');
		$content = rwmb_meta('contenuto');
		$images = rwmb_meta( 'image-spotlight', ['size' => 'large'] );
		$image = reset( $images );
	?>
	<div>
		<article class="single-spotlight-style">
			<div class="single-spotlight-style__lefty">
				<p class="single-spotlight-style__lefty--date"><?php echo get_the_date('j F Y'); ?></p>
				<h1 class="single-spotlight-style__lefty--title" id="post-<?php the_ID(); ?>"> <?php the_title(); ?></h1>
				<p class="single-spotlight-style__lefty--subtitle"><?php echo $subtitle ?></p>
				<p class="single-spotlight-style__lefty--content"><?php echo $content ?></p>
				<div class="single-spotlight-style__lefty--socials social-bar">
					<a class="social-bar__single-social"href="">Twitter</a>
					<a class="social-bar__single-social"href="">Facebook</a>
					<a class="social-bar__single-social"href="">Linkedin</a>
					<a class="social-bar__single-social"href="">Twitter</a>
				</div>
			</div>
			<div class="single-spotlight-style__righty">
				<div class="single-spotlight-style__righty--img">
					<img src="<?= $image['url']; ?>">
				</div>
				<div class="single-spotlight-style__righty--taxonomies">
					<?php 
					$terms = get_the_terms(get_the_ID(), 'Discover All');
					if ($terms) {
						echo '<ul class="term-discover-all">';
						foreach ($terms as $term) {
							$term_link = get_term_link($term);
							$term_color = get_term_meta($term->term_id);
							$term_single_color = $term_color['color_8m4dc2b2uij'][0];
							echo '<li class="term-discover-all__single-tax" style="border-color:' . $term_single_color . ';"><a href="' . $term_link . '">' . $term->name . '</a></li>';
						}
						echo '</ul>';
						}
					?>
				</div>
			</div>
		</article>
	</div>
<?php get_footer(); ?>