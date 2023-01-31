<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// stories			-> slug del custom post type
// Stories	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// stories		-> Textdomain per il gettext
// Story		 	-> Nome singolare del cpt con la prima lettera maiscola
// story		 	-> Nome singolare del cpt con la prima lettera minuscola
// [PLUUPP]		 	-> Nome plurale del cpt con la prima lettera maiscola
// [PLULOW]		 	-> Nome plurale del cpt con la prima lettera minuscola
// a			-> se femminile mettere "a" se maschile mettere "o"
// i			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/


/*============================================
=            ACTION & FILTER LIST            =
============================================*/

// Inizializzo il post type
add_action( 'init', 'MR_custom_post_stories' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_stories_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-stories_columns', 'MR_stories_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_stories_posts_custom_column', 'MR_stories_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_stories_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_stories', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_stories_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_stories_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_stories_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_stories_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_stories', 'MR_stories_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_stories', 'MR_stories_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_stories', 'MR_stories_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_stories', 'MR_stories_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_stories() {
  $labels = array(
	  'name'               => _x( 'Story', 'post type general name' ),
	  'singular_name'      => _x( 'Story', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi Story', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova story', 'stories' ),
	  'edit_item'          => __( 'Modifica Story', 'stories' ),
	  'new_item'           => __( 'Nuova Story', 'stories' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'stories' ),
	  'view_item'          => __( 'Vedi story ', 'stories' ),
	  'search_items'       => __( 'Cerca story', 'stories' ),
	  'not_found'          => __( 'Nessuna story trovata', 'stories' ),
	  'not_found_in_trash' => __( 'Nessuna story trovata nel cestino', 'stories' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Story'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutti ', 'stories' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_stories",
	// 			'read_post'		 => "read_stories",
	// 			'delete_post'		 => "delete_stories",
	// 			'edit_posts'	 => "edit_storiess",
	// 			'edit_others_posts'	 => "edit_others_storiess",
	// 			'publish_posts'		 => "publish_storiess",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_storiess",
	// 			'delete_private_posts'   => "delete_private_storiess",
	// 			'delete_published_posts' => "delete_private_storiess",
	// 			'delete_others_posts'    => "delete_others_storiess",
	// 			'edit_private_posts'     => "delete_others_storiess",
	// 			'edit_published_posts'   => "edit_published_storiess",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => 'Stories'),
    'show_in_rest'       => true

  );
  register_post_type( 'stories', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_stories() {
        remove_meta_box( 'wpseo_meta', 'stories', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_stories_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['stories'] = array(
    0 => '', 
    1 => sprintf( __('Story aggiornata . <a href="%s">Visualizza story</a>' ,'stories'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornati.','stories'),
    3 => __('Dati personalizzati cancellata.','stories'),
    4 => __('Story aggiornata.','stories'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina story a  %s','stories'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Story pubblicata <a href="%s">Visualizza story</a>','stories'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Story salvata.','stories'),
    8 => sprintf( __('Story inviata. <a target="_blank" href="%s">Visualizza anteprima</a>','stories'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Story programmata per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza story aggiornata. <a target="_blank" href="%s">Visualizza anteprima</a>','stories'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_stories_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == 'stories' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_stories_register_meta_boxes( $meta_boxes ) {
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
function MR_stories_columns($columns) {
	
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
function MR_stories_manage_columns( $column, $post_id ) {
	global $post;
	$stories_meta = get_post_meta( $post_id );
	
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
function MR_stories_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=stories'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_stories_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == 'stories' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_stories_remove_pagesize( $query ) {
    if ( is_post_type_archive( 'stories' ) ) {
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
function MR_stories_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_stories_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_stories_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_stories_delete_transition_event( $ID, $post ){


}

