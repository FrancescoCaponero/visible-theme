<?php 

/**
 *
 * Rewrite Rules per nascondere il tema e wordpress dai vari url
 *
 */
add_action('generate_rewrite_rules', 'MR_add_rewrites');
 
function MR_add_rewrites() {
  $theme_name = next(explode('/themes/', get_stylesheet_directory()));
 
  global $wp_rewrite;
  $new_non_wp_rules = array(
    'css/(.*)'       => 'wp-content/themes/'. $theme_name . '/assets/css/$1',
    'js/(.*)'        => 'wp-content/themes/'. $theme_name . '/assets/js/$1',
    'img/(.*)'    => 'wp-content/themes/'. $theme_name . '/assets/img/$1',
  );
  $wp_rewrite->non_wp_rules += $new_non_wp_rules;
}





/**
 *
 * ENDPOINTS
 *
 */
add_action('init', 'MR_add_endpoint');
function MR_add_endpoint()
{	
	//Ricordati di farlo solo all'attivazione del tema
    //add_rewrite_endpoint( 'section', EP_PERMALINK | EP_PAGES );
    //flush_rewrite_rules(  );
}