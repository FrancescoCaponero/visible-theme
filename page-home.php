<?php 
    get_header();
    $args = array(
    'post_type' => 'stories',
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
	'order' => 'ASC'
    );
    $cpt_posts = new WP_Query( $args );
    ?>
    <div class="container-page-home">
        <div class="container-page-home__img-container">
            <img src="">
        </div>
		<article class="wrapper-text-select-page-home white-box-dimension">
            <h3 class="hero-home-central-font-black">visible is <span>
            <select class="page-home__select">
            <?php
            if ( $cpt_posts->have_posts() ) {
              while ( $cpt_posts->have_posts() ) {
                $cpt_posts->the_post();
                ?>
                <option data-img="<?php echo the_post_thumbnail_url('large'); ?>" value="<?php the_permalink(); ?>">
                <?php the_title(); ?>
                </option>
                <?php
              }
              wp_reset_postdata();
            }
            ?>
          </select>
        </span>seen through art</h3>
		</article>
        <button class='vlet-btn violet-top-box-dimension' type="button" id="go-to-permalink">go to the story</button>
        <div class="spotlight-btn-and-post">
        
            <button class='blk-btn'>
                <a class="footer-basic-typo" href="<?php echo esc_url( get_permalink( get_page_by_title( 'spotlight' ) ) ); ?>">Discover All Spotlights</a>
            </button>
        
        <?php
        $args = array(
        'post_type' => 'spotlight',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
        );

        $latest_post = new WP_Query( $args );

        if ( $latest_post->have_posts() ) {
            while ( $latest_post->have_posts() ) {
                $latest_post->the_post();
                $images = rwmb_meta( 'image-spotlight', ['size' => 'large'] );
                $image = reset( $images );
                ?>
                <div class="spotlight-btn-and-post__txt-and-img footer-basic-typo">
                    <div class="spotlight-btn-and-post__txt-and-img--img">  
                        <img src="<?= $image['url']; ?>">
                    </div>      
                     <div class="spotlight-wrap">
                         <p class="spotlight-btn-and-post__txt-and-img--txt"> <?php the_title(); ?> </p>
                        <button class="read-more-btn-white">
                          <a class="footer-basic-typo" href="<?php the_permalink(); ?>">Read More</a>
                        </button>
                     </div>
                   
                </div>
                
                <?php
            }
            wp_reset_postdata();
        }
        ?>
        </div>
    </div>
<?php get_footer(); ?>