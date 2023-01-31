<?php

/**
 *
 * Redirect da da personalizzare
 *
 */
//add_filter('get_header','MR_redirect_from_A_to_B');

function MR_redirect_from_A_to_B(){
  if( is_user_logged_in() && is_home() || is_page('miapagina') ) { 
    wp_redirect(site_url('/target'));
    exit();
  }
}



/**
 *
 * Disabilito wp-admin e faccio il redirect su pagina a scelta
 *
 */
//add_action( 'admin_init', 'MR_redirect_admin_section' );

function MR_redirect_admin_section(){
  if ( ! defined('DOING_AJAX') && !current_user_can('administrator') ) {
    wp_redirect( site_url('miasezione') );
    exit;   
  }
}
