<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// library			-> slug del custom post type
// library	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// library		-> Textdomain per il gettext
// library		 	-> Nome singolare del cpt con la prima lettera maiscola
// library		 	-> Nome singolare del cpt con la prima lettera minuscola
// [PLUUPP]		 	-> Nome plurale del cpt con la prima lettera maiscola
// [PLULOW]		 	-> Nome plurale del cpt con la prima lettera minuscola
// a			-> se femminile mettere "a" se maschile mettere "o"
// e			-> se femminile mettere "e" se maschile mettere "i"
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
	  'name'               => _x( 'Library', 'post type general name' ),
	  'singular_name'      => _x( 'library', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi library', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova library', 'library' ),
	  'edit_item'          => __( 'Modifica library', 'library' ),
	  'new_item'           => __( 'Nuova library', 'library' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'library' ),
	  'view_item'          => __( 'Vedi library ', 'library' ),
	  'search_items'       => __( 'Cerca library', 'library' ),
	  'not_found'          => __( 'Nessuna library trovata', 'library' ),
	  'not_found_in_trash' => __( 'Nessuna library trovata nel cestino', 'library' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Library'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutte ', 'library' ),
    'public'        => true,
    'menu_position' => 8,
    'supports' => array( 'title', 'thumbnail', 'excerpt'),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-book',
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
	'rewrite'		=> array('slug' => 'library')
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
    1 => sprintf( __('library aggiornata . <a href="%s">Visualizza library</a>' ,'library'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornate.','library'),
    3 => __('Dati personalizzati cancellata.','library'),
    4 => __('library aggiornata.','library'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina library a  %s','library'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('library pubblicata <a href="%s">Visualizza library</a>','library'), esc_url( get_permalink($post_ID) ) ),
    7 => __('library salvata.','library'),
    8 => sprintf( __('library inviata. <a target="_blank" href="%s">Visualizza anteprima</a>','library'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('library programmata per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza library aggiornata. <a target="_blank" href="%s">Visualizza anteprima</a>','library'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
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

