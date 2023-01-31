<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// library			-> slug del custom post type
// library	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// library		-> Textdomain per il gettext
// Book		 	-> Nome singolare del cpt con la prima lettera maiscola
// book		 	-> Nome singolare del cpt con la prima lettera minuscola
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
add_action( 'init', 'MR_custom_post_library' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_library_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-library_columns', 'MR_library_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_library_posts_custom_column', 'MR_library_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_library_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_library', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_library_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_library_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_library_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_library_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_library', 'MR_library_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_library', 'MR_library_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_library', 'MR_library_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_library', 'MR_library_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_library() {
  $labels = array(
	  'name'               => _x( 'Book', 'post type general name' ),
	  'singular_name'      => _x( 'Book', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi Book', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova book', 'library' ),
	  'edit_item'          => __( 'Modifica Book', 'library' ),
	  'new_item'           => __( 'Nuova Book', 'library' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'library' ),
	  'view_item'          => __( 'Vedi book ', 'library' ),
	  'search_items'       => __( 'Cerca book', 'library' ),
	  'not_found'          => __( 'Nessuno book trovato', 'library' ),
	  'not_found_in_trash' => __( 'Nessuno book trovato nel cestino', 'library' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Book'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutti ', 'library' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_library",
	// 			'read_post'		 => "read_library",
	// 			'delete_post'		 => "delete_library",
	// 			'edit_posts'	 => "edit_librarys",
	// 			'edit_others_posts'	 => "edit_others_librarys",
	// 			'publish_posts'		 => "publish_librarys",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_librarys",
	// 			'delete_private_posts'   => "delete_private_librarys",
	// 			'delete_published_posts' => "delete_private_librarys",
	// 			'delete_others_posts'    => "delete_others_librarys",
	// 			'edit_private_posts'     => "delete_others_librarys",
	// 			'edit_published_posts'   => "edit_published_librarys",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => 'library'),
    'show_in_rest'       => true

  );
  register_post_type( 'library', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_library() {
        remove_meta_box( 'wpseo_meta', 'library', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_library_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['library'] = array(
    0 => '', 
    1 => sprintf( __('Book aggiornato . <a href="%s">Visualizza book</a>' ,'library'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornati.','library'),
    3 => __('Dati personalizzati cancellato.','library'),
    4 => __('Book aggiornato.','library'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina book a  %s','library'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Book pubblicato <a href="%s">Visualizza book</a>','library'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Book salvato.','library'),
    8 => sprintf( __('Book inviato. <a target="_blank" href="%s">Visualizza anteprima</a>','library'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Book programmato per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza book aggiornato. <a target="_blank" href="%s">Visualizza anteprima</a>','library'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_library_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == 'library' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_library_register_meta_boxes( $meta_boxes ) {
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
function MR_library_columns($columns) {
	
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
function MR_library_manage_columns( $column, $post_id ) {
	global $post;
	$library_meta = get_post_meta( $post_id );
	
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
function MR_library_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=library'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_library_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == 'library' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_library_remove_pagesize( $query ) {
    if ( is_post_type_archive( 'library' ) ) {
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
function MR_library_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_library_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_library_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_library_delete_transition_event( $ID, $post ){


}

