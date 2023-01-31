<?php
/**
 *
 * Aggiungo slug pagina nelle body class
 *
 */
add_filter( 'body_class', 'MR_add_post_slug_in_body_class' );

function MR_add_post_slug_in_body_class( $classes ) {
  global $post;
  if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}


/**
 *
 * Nascondo l'Admin Bar per tutti gli utenti tranne gli amministratori
 *
 */
add_action('after_setup_theme', 'MR_remove_admin_bar');

function MR_remove_admin_bar() {

  if (!current_user_can('administrator') && !current_user_can('ruoloutente') && !is_admin()) {
    show_admin_bar(false);
  }

}


/**
 * Effettua il debug della variabile
 *
 * @param  [$variabile
 *
 * @return var_dump della variabile
 */
function d( $variable ){

  echo '<pre>';
  var_dump($variable);
  echo '</pre>';

}



/**
 * Funzione che effettua il redirect in base al json standard di risposta all'ajax
 *
 * @param $response         array
 * @param $success_link     link in caso di status=success
 * @param $error_link       link in caso di status=error, se omesso uso il succes link
 * @param $url_data         array di attributi aggiuntivi che verrannoc omposti nell'url come una get
 */
function MR_ajax_response_redirect( $response , $success_link , $error_link , $url_data = array() ){
  global $MR_options;

  if( !empty($response['status']) ){
      switch ($response['status']) {
        case 'success':
          $redirect_url = $success_link;
          if( strpos( $error_link ,'?') === FALSE && count($url_data) ){
               $redirect_url .= '?';
          }
   
          foreach ($url_data as $key => $val) {
              $redirect_url .= '&'.$key.'='.urlencode($val);
          }
   
          wp_redirect( $redirect_url );
          break;
        
        default:
          if($error_link === FALSE) $error_link = $success_link;

          if( strpos( $error_link ,'?') === FALSE ){
              wp_redirect( $error_link.'?error_message='.$response['message'] );
          }else{
              wp_redirect( $error_link.'&error_message='.$response['message'] );
          }
         
          break;
      }
  }else{
      wp_redirect( $MR_options['url'] );
  }
  
  die();
}




/**
 * Funzione che tronca una stringa
 *
 * @param  $string    Stringa da tagliare
 * @param  $limit     Lunghezza taglio
 * @param  $break     Carattere di rottura
 * @param  $pad       Aggiunta dopo taglio
 *
 * @return Stringa tagliata
 */
function MR_truncate($string, $limit, $break=".", $pad=" ...")
{

    if(strlen($string) <= $limit) return $string;
  

  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
      if($breakpoint < strlen($string) - 1) {
        $string = substr($string, 0, $breakpoint) . $pad;
      }
  }
    return $string;
}





