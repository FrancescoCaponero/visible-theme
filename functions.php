<?php

/*===============================================
=            FIND & REPLACE GLOBAL VARIABLE     =
===============================================*/

// MR     -> prefisso da appendere ad ogni  funzione 
// visible   -> Textdomain per il gettext

// Effettuare un find & replace su tutti i file del tema !!

/*=====  End of FIND & REPLACE GLOBAL VARIABLE  ======*/


/*========================================
=            AUTO FILE LOADER            =
========================================*/

/*============================================
=            VARIABLES & COSTANTS            =
============================================*/

define( 'MR_VERS', '1.0');

define( 'MR_PATH', __DIR__);
define( 'MR_GLOB_OPTION', 'mr_options' );

define( 'MR_META_PREFIX' , 'mr_' );


define( 'MR_AJAX_NONCE'  , '#forzaVale46');



/*=====  End of VARIABLES & COSTANTS  ======*/



/**
 *
 * Carico tutti i custom post type
 *
 */
foreach (glob(__DIR__."/inc/post-type/[!_]*.php") as $filename)
{
    include_once $filename;
}

/**
 *
 * Carico tutte tassonomie
 *
 */
foreach (glob(__DIR__."/inc/taxonomy/[!_]*.php") as $filename)
{
    include_once $filename;
}


/**
 *
 * Carico il core del tema
 *
 */
foreach (glob(__DIR__."/inc/core/[!_]*.php") as $filename)
{
    include_once $filename;
    
}


/*=====  End of AUTO FILE LOADER  ======*/




/*==================================
=            INIT CLASS            =
==================================*/

// Inizializzo la cache delle ozpioni 
$MR_options = MR_get_global_option();



/*=====  End of INIT CLASS  ======*/




/*======================================
=            THEME SUPPORTS            =
======================================*/

add_theme_support( 'post-thumbnails' ); 
//add_theme_support( 'woocommerce' ); 

/*=====  End of THEME SUPPORTS  ======*/



/*========================================
=            SCRIPTS & STYLES            =
========================================*/

/**
 *
 * Registro gli script e styles
 *
 */
add_action( 'wp_enqueue_scripts', 'MR_load_scripts' );
function MR_load_scripts() {
  
    wp_enqueue_script('jmin', get_bloginfo('url') . '/js/main.js',  array('jquery') , '1.0.0' , true );
    wp_enqueue_script('modernizr', get_bloginfo('url') . '/js/modernizr.js',  array('jquery') , '1.0.0' , true );
    wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css' );
  
}

/**
 *
 * lazyblock folder
 *
 */
$dir = __DIR__ . '/blocks'; //la nostra cartella

foreach (glob("$dir/*") as $path) {
	if (preg_match('/\.php$/', $path)) {
		require_once $path;
	}
}


/**
 *
 * Registro gli script e styles per lato admin
 *
 */
add_action( 'wp_admin_enqueue_scripts', 'MR_load_admin_scripts' );
function MR_load_admin_scripts() {
  
  wp_enqueue_script('visible-admin-js', get_template_directory_uri() . 'assets/js/admin/admin.js', array('jquery'));
  
}


/*=====  End of SCRIPTS & STYLES  ======*/




/*==================================
=            NAVIGATION            =
==================================*/

if (function_exists('register_nav_menus')) 
{
  register_nav_menus( array(
    'main-nav' => 'Primary Menu'  
  ) );
}

/*=====  End of NAVIGATION  ======*/



/**
 *
 * CACHE GLOBALS OPTIONS
 *
 */
function MR_get_global_option(){
    $MR_get_global_option = get_option(MR_GLOB_OPTION);
    if ($MR_get_global_option === false){
        global $wp_version;
        $lang = get_locale();
        $lang = str_replace('_', '-', $lang);
        $MR_get_global_option = array(
            'url' => home_url(),
            'wpurl' => site_url(),
            'description' => get_option('blogdescription'),
            'theme_path'  => get_stylesheet_directory(),
            'theme_url'  => get_bloginfo('template_url'),
            'stylesheet_url' => get_stylesheet_uri(),
            'stylesheet_directory' => get_stylesheet_directory_uri(),
            'template_url' => get_template_directory_uri(),
            'admin_email' => get_option('admin_email'),
            'html_type' => get_option('html_type'),
            'version' => $wp_version,
            'language' => $lang     
        );
        update_option(MR_GLOB_OPTION,$MR_get_global_option);
    }
    return $MR_get_global_option;
}



/*===================================================
=            LOGIN STYLE & CUSTOMIZATION            =
===================================================*/

function MR_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'MR_login_logo_url' );

function MR_login_logo_url_title() {
    return 'Nome sito';
}
add_filter( 'login_headertitle', 'MR_login_logo_url_title' );




/*=====  End of LOGIN STYLE & CUSTOMIZATION  ======*/



/*=============================================
=            CUSTOMIZE SEARCH FORM            =
==============================================*/

function custom_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="" >
      <div class="custom-form"><label class="screen-reader-text hidden-input" for="s">' . __( 'Search:' ) . '</label>
      <input placeholder="search something" class="hidden-input" type="text" value="' . get_search_query() . '" name="s" id="s" />
      <button type="submit" id="searchsubmit" value="'. esc_attr__( 'CERCA' ) .'">
      <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="6.21154" cy="5.71154" r="4.96154" stroke="white" stroke-width="1.5"/>
        <line x1="10.376" y1="8.81342" x2="14.5299" y2="12.9673" stroke="white" stroke-width="1.5"/>
        </svg>
        </button>
    </div>
    </form>';

    return $form;
  }
  add_filter( 'get_search_form', 'custom_search_form', 40 );

  /*=====  End of CUSTOMIZE SEARCH FORM  ======*/

  //set the excerpt num of charaters
  function custom_excerpt_length( $length ) {
    return 20;
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



?>