<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// fellowship			-> slug del custom post type
// fellowship	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// fellowship		-> Textdomain per il gettext
// Fellowship		 	-> Nome singolare del cpt con la prima lettera maiscola
// fellowship		 	-> Nome singolare del cpt con la prima lettera minuscola
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
add_action( 'init', 'MR_custom_post_fellowship' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_fellowship_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-fellowship_columns', 'MR_fellowship_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_fellowship_posts_custom_column', 'MR_fellowship_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_fellowship_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_fellowship', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_fellowship_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_fellowship_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_fellowship_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_fellowship_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_fellowship', 'MR_fellowship_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_fellowship', 'MR_fellowship_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_fellowship', 'MR_fellowship_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_fellowship', 'MR_fellowship_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_fellowship() {
  $labels = array(
	  'name'               => _x( 'Fellowship', 'post type general name' ),
	  'singular_name'      => _x( 'Fellowship', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi Fellowship', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova fellowship', 'fellowship' ),
	  'edit_item'          => __( 'Modifica Fellowship', 'fellowship' ),
	  'new_item'           => __( 'Nuova Fellowship', 'fellowship' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'fellowship' ),
	  'view_item'          => __( 'Vedi fellowship ', 'fellowship' ),
	  'search_items'       => __( 'Cerca fellowship', 'fellowship' ),
	  'not_found'          => __( 'Nessuna fellowship trovata', 'fellowship' ),
	  'not_found_in_trash' => __( 'Nessuna fellowship trovata nel cestino', 'fellowship' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Fellowship'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutte ', 'fellowship' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_fellowship",
	// 			'read_post'		 => "read_fellowship",
	// 			'delete_post'		 => "delete_fellowship",
	// 			'edit_posts'	 => "edit_fellowships",
	// 			'edit_others_posts'	 => "edit_others_fellowships",
	// 			'publish_posts'		 => "publish_fellowships",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_fellowships",
	// 			'delete_private_posts'   => "delete_private_fellowships",
	// 			'delete_published_posts' => "delete_private_fellowships",
	// 			'delete_others_posts'    => "delete_others_fellowships",
	// 			'edit_private_posts'     => "delete_others_fellowships",
	// 			'edit_published_posts'   => "edit_published_fellowships",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => 'fellowship')

  );
  register_post_type( 'fellowship', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_fellowship() {
        remove_meta_box( 'wpseo_meta', 'fellowship', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_fellowship_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['fellowship'] = array(
    0 => '', 
    1 => sprintf( __('Fellowship aggiornata . <a href="%s">Visualizza fellowship</a>' ,'fellowship'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornate.','fellowship'),
    3 => __('Dati personalizzati cancellata.','fellowship'),
    4 => __('Fellowship aggiornata.','fellowship'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina fellowship a  %s','fellowship'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Fellowship pubblicata <a href="%s">Visualizza fellowship</a>','fellowship'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Fellowship salvata.','fellowship'),
    8 => sprintf( __('Fellowship inviata. <a target="_blank" href="%s">Visualizza anteprima</a>','fellowship'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Fellowship programmata per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza fellowship aggiornata. <a target="_blank" href="%s">Visualizza anteprima</a>','fellowship'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_fellowship_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == 'fellowship' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_fellowship_register_meta_boxes( $meta_boxes ) {
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
function MR_fellowship_columns($columns) {
	
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
function MR_fellowship_manage_columns( $column, $post_id ) {
	global $post;
	$fellowship_meta = get_post_meta( $post_id );
	
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
function MR_fellowship_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=fellowship'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_fellowship_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == 'fellowship' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_fellowship_remove_pagesize( $query ) {
    if ( is_post_type_archive( 'fellowship' ) ) {
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
function MR_fellowship_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_fellowship_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_fellowship_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_fellowship_delete_transition_event( $ID, $post ){


}

