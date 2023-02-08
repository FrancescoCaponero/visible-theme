<div class="page-spotlight-wrapper-single">

<?php
			$args = array(
                'post_type' => 'spotlight',
                'posts_per_page' => 1,
                'orderby' => 'meta_value',
                'order' => 'DESC'
                );
                $cpt_posts = new WP_Query( $args );
			if ( $cpt_posts->have_posts() ) {
				while ( $cpt_posts->have_posts() ) {
				$cpt_posts->the_post();
				$subtitle = rwmb_meta('sottotitolo');
				$images = rwmb_meta( 'image-spotlight', ['size' => 'large'] );
                $image = reset( $images );
				?>
				<div class="page-spotlight-post-single">
				    <div  class="page-spotlight-post-single__text-wrap">
						<h2 class="page-spotlight-post-single__text-wrap--title"><?php the_title(); ?></h2>
                        <p class="page-spotlight-post-single__text-wrap--date"><?php echo get_the_date('j F Y'); ?></p>
						<p class="page-spotlight-post-single__text-wrap--subtitle"><?php echo $subtitle; ?></p>
						<div class="page-spotlight-post-single__text-wrap--taxonomies">
							
						<!-- 	 TAKE THE TERMS
							$terms = get_the_terms(get_the_ID(), 'Discover All');
							if ($terms) {
								echo '<ul class="term-discover-all">';
								foreach ($terms as $term) {
									$term_link = get_term_link($term);
									$term_color = get_term_meta($term->term_id);
									$term_single_color = $term_color['color_8m4dc2b2uij'][0];
									echo '<li class="term-discover-all__single-tax " style="border-color:' . $term_single_color . '; color :' . $term_single_color . '">';
									echo '<a href="' . $term_link . '">' . $term->name . '</a>';
									echo '</li>';
								}
								echo '</ul>';
							  }
							  
							 -->
							
						</div>
                        <button class="blk-btn-small">
                            <a href="<?php the_permalink(); ?>">Read More</a>
                        </button>
				    </div>
                    <div class="page-spotlight-post-single__img-wrap">
						<img src="<?= $image['url']; ?>">
					</div>
				</div>
				  <?php
				}
				wp_reset_postdata();
			  }
			  ?>
              </div>