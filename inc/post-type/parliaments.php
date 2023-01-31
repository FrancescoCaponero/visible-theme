<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// parliaments			-> slug del custom post type
// parliaments	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// parliaments		-> Textdomain per il gettext
// Parliaments		 	-> Nome singolare del cpt con la prima lettera maiscola
// parliament		 	-> Nome singolare del cpt con la prima lettera minuscola
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
add_action( 'init', 'MR_custom_post_parliaments' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_parliaments_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-parliaments_columns', 'MR_parliaments_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_parliaments_posts_custom_column', 'MR_parliaments_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_parliaments_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_parliaments', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_parliaments_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_parliaments_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_parliaments_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_parliaments_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_parliaments', 'MR_parliaments_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_parliaments', 'MR_parliaments_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_parliaments', 'MR_parliaments_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_parliaments', 'MR_parliaments_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_parliaments() {
  $labels = array(
	  'name'               => _x( 'Parliaments', 'post type general name' ),
	  'singular_name'      => _x( 'Parliaments', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi Parliaments', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova parliament', 'parliaments' ),
	  'edit_item'          => __( 'Modifica Parliaments', 'parliaments' ),
	  'new_item'           => __( 'Nuova Parliaments', 'parliaments' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'parliaments' ),
	  'view_item'          => __( 'Vedi parliament ', 'parliaments' ),
	  'search_items'       => __( 'Cerca parliament', 'parliaments' ),
	  'not_found'          => __( 'Nessuno parliament trovato', 'parliaments' ),
	  'not_found_in_trash' => __( 'Nessuno parliament trovato nel cestino', 'parliaments' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Parliaments'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutti ', 'parliaments' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_parliaments",
	// 			'read_post'		 => "read_parliaments",
	// 			'delete_post'		 => "delete_parliaments",
	// 			'edit_posts'	 => "edit_parliamentss",
	// 			'edit_others_posts'	 => "edit_others_parliamentss",
	// 			'publish_posts'		 => "publish_parliamentss",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_parliamentss",
	// 			'delete_private_posts'   => "delete_private_parliamentss",
	// 			'delete_published_posts' => "delete_private_parliamentss",
	// 			'delete_others_posts'    => "delete_others_parliamentss",
	// 			'edit_private_posts'     => "delete_others_parliamentss",
	// 			'edit_published_posts'   => "edit_published_parliamentss",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => 'parliaments'),
    'show_in_rest'       => true

  );
  register_post_type( 'parliaments', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_parliaments() {
        remove_meta_box( 'wpseo_meta', 'parliaments', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_parliaments_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['parliaments'] = array(
    0 => '', 
    1 => sprintf( __('Parliaments aggiornato . <a href="%s">Visualizza parliament</a>' ,'parliaments'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornati.','parliaments'),
    3 => __('Dati personalizzati cancellato.','parliaments'),
    4 => __('Parliaments aggiornato.','parliaments'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina parliament a  %s','parliaments'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Parliaments pubblicato <a href="%s">Visualizza parliament</a>','parliaments'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Parliaments salvato.','parliaments'),
    8 => sprintf( __('Parliaments inviato. <a target="_blank" href="%s">Visualizza anteprima</a>','parliaments'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Parliaments programmato per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza parliament aggiornato. <a target="_blank" href="%s">Visualizza anteprima</a>','parliaments'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_parliaments_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == 'parliaments' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_parliaments_register_meta_boxes( $meta_boxes ) {
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
function MR_parliaments_columns($columns) {
	
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
function MR_parliaments_manage_columns( $column, $post_id ) {
	global $post;
	$parliaments_meta = get_post_meta( $post_id );
	
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
function MR_parliaments_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=parliaments'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_parliaments_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == 'parliaments' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_parliaments_remove_pagesize( $query ) {
    if ( is_post_type_archive( 'parliaments' ) ) {
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
function MR_parliaments_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_parliaments_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_parliaments_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_parliaments_delete_transition_event( $ID, $post ){


}

