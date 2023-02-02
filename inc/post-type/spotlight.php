<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// spotlight			-> slug del custom post type
// spotlight	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// spotlight		-> Textdomain per il gettext
// Spotlight		 	-> Nome singolare del cpt con la prima lettera maiscola
// spotlight		 	-> Nome singolare del cpt con la prima lettera minuscola
// [PLUUPP]		 	-> Nome plurale del cpt con la prima lettera maiscola
// [PLULOW]		 	-> Nome plurale del cpt con la prima lettera minuscola
// o			-> se femminile mettere "a" se maschile mettere "o"
// i			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/


/*============================================
=            ACTION & FILTER LIST            =
============================================*/

// Inizializzo il post type
add_action( 'init', 'MR_custom_post_spotlight' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_spotlight_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-spotlight_columns', 'MR_spotlight_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_spotlight_posts_custom_column', 'MR_spotlight_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_spotlight_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_spotlight', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_spotlight_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_spotlight_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_spotlight_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_spotlight_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_spotlight', 'MR_spotlight_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_spotlight', 'MR_spotlight_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_spotlight', 'MR_spotlight_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_spotlight', 'MR_spotlight_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_spotlight() {
  $labels = array(
	  'name'               => _x( 'Spotlight', 'post type general name' ),
	  'singular_name'      => _x( 'Spotlight', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi Spotlight', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova spotlight', 'spotlight' ),
	  'edit_item'          => __( 'Modifica Spotlight', 'spotlight' ),
	  'new_item'           => __( 'Nuova Spotlight', 'spotlight' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'spotlight' ),
	  'view_item'          => __( 'Vedi spotlight ', 'spotlight' ),
	  'search_items'       => __( 'Cerca spotlight', 'spotlight' ),
	  'not_found'          => __( 'Nessuno spotlight trovato', 'spotlight' ),
	  'not_found_in_trash' => __( 'Nessuno spotlight trovato nel cestino', 'spotlight' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Spotlight'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutti ', 'spotlight' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'thumbnail' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_spotlight",
	// 			'read_post'		 => "read_spotlight",
	// 			'delete_post'		 => "delete_spotlight",
	// 			'edit_posts'	 => "edit_spotlights",
	// 			'edit_others_posts'	 => "edit_others_spotlights",
	// 			'publish_posts'		 => "publish_spotlights",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_spotlights",
	// 			'delete_private_posts'   => "delete_private_spotlights",
	// 			'delete_published_posts' => "delete_private_spotlights",
	// 			'delete_others_posts'    => "delete_others_spotlights",
	// 			'edit_private_posts'     => "delete_others_spotlights",
	// 			'edit_published_posts'   => "edit_published_spotlights",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => 'spotlight')
  );
  register_post_type( 'spotlight', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_spotlight() {
        remove_meta_box( 'wpseo_meta', 'spotlight', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_spotlight_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['spotlight'] = array(
    0 => '', 
    1 => sprintf( __('Spotlight aggiornato . <a href="%s">Visualizza spotlight</a>' ,'spotlight'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornati.','spotlight'),
    3 => __('Dati personalizzati cancellato.','spotlight'),
    4 => __('Spotlight aggiornato.','spotlight'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina spotlight a  %s','spotlight'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Spotlight pubblicato <a href="%s">Visualizza spotlight</a>','spotlight'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Spotlight salvato.','spotlight'),
    8 => sprintf( __('Spotlight inviato. <a target="_blank" href="%s">Visualizza anteprima</a>','spotlight'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Spotlight programmato per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza spotlight aggiornato. <a target="_blank" href="%s">Visualizza anteprima</a>','spotlight'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_spotlight_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == 'spotlight' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_spotlight_register_meta_boxes( $meta_boxes ) {
    // 1st meta box
    $meta_boxes[] = array(
        'id'         => 'data-expositor',
        'title'      => __( 'Contenuti Espositore', 'eicma' ),
/*         'post_types' => array( e_news ),
 */        'context'    => 'normal',
        'priority'   => 'high',
        'fields' => array(
            array(
                'name'  => __( 'Immagini', 'eicma' ),
                'id'    => 'MR_images',
                'type'  => 'image_advanced',
                'max_file_uploads' => 150,
            ),
        )
    );
    
    return $meta_boxes;
}



/**
 *
 * Registro le colonne per Subscribers
 *
 */
function MR_spotlight_columns($columns) {
	
	// Aggiungo le colonne
	// $columns['status'] = 'abcdef';

	// Rinomino le colonne
	// $columns['title'] = 'abcdef';

	//Rimuovo le colonne
	//unset($columns['language']);
	
    return $columns;
}





/**
 *
 * Popolo le colonne aggiunte per Subscribers
 *
 */
function MR_spotlight_manage_columns( $column, $post_id ) {
	global $post;
	$spotlight_meta = get_post_meta( $post_id );
	
	switch( $column ) {
	
	    case 'actions' :

	    	//echo 'Ciao colonna!'
	    	
	        break;

	     
	    default :
	        break;
	}
}





/**
 *
 * Disabilito l'aggiunta di una sottoscrizione dal lato admin
 *
 */
function MR_spotlight_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=spotlight'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_spotlight_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == 'spotlight' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_spotlight_remove_pagesize( $query ) {
    if ( is_post_type_archive( 'spotlight' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', -1 );
        return;
    }
    return;
}







/**
 *
 * Funzione chimamata quando il post passa a Pubblicato
 *
 */
function MR_spotlight_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_spotlight_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_spotlight_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_spotlight_delete_transition_event( $ID, $post ){


}

