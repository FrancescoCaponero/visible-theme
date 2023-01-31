<?php
/**
 *
 * Setto indirzzo e nome di chi invia le mail
 *
 */
add_filter( 'wp_mail_from_name', function( $name ) {
  return 'Nome Mostrato';
});

add_filter( 'wp_mail_from', function( $email ) {
  return 'Mail Usata';
});


/**
 *
 * MAILER
 *
 */
function MR_mailer( $to , $subject , $template = 'default' , $data = array() ){

    add_filter( 'wp_mail_content_type', 'MR_set_html_content_type' );

    $header = file_get_contents(get_template_directory().'/inc/mail-template/header.html');
    $body = file_get_contents(get_template_directory().'/inc/mail-template/'.$template.'.html');
    $footer = file_get_contents(get_template_directory().'/inc/mail-template/footer.html');

    foreach ($data as $key => $value) {
       $body = str_replace($key, $value, $body);
    }
    

    $mail_result = wp_mail( $to, $subject, $header.$body.$footer  );

    $mail_result = ($mail_result)?'Sent':'Error';

    
    $log  = "Data : ".date("F j, Y, g:i a").PHP_EOL.
            "Destinatario : ".$to.PHP_EOL.
            "Oggetto : ".$subject.PHP_EOL.
            "Template : ".$template.PHP_EOL.
            "Risultato : ".$mail_result.PHP_EOL.
            "Email DATA : ".json_encode($data).PHP_EOL.
            "--------------------------------------------".PHP_EOL.
            "============================================".PHP_EOL.
            "--------------------------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents(get_template_directory().'/inc/log/mailer.log', $log, FILE_APPEND);



    remove_filter( 'wp_mail_content_type', 'MR_set_html_content_type' );

}


/**
 *
 * Setto il content ytpe delle mail
 *
 */
function MR_set_html_content_type() {
  return 'text/html';
}