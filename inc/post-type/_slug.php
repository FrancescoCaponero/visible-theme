<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// [SLUG]			-> slug del custom post type
// [REWRITESLUG]	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// [TEXTDOMAIN]		-> Textdomain per il gettext
// [SINUPP]		 	-> Nome singolare del cpt con la prima lettera maiscola
// [SINLOW]		 	-> Nome singolare del cpt con la prima lettera minuscola
// [PLUUPP]		 	-> Nome plurale del cpt con la prima lettera maiscola
// [PLULOW]		 	-> Nome plurale del cpt con la prima lettera minuscola
// [GENDERSING]			-> se femminile mettere "a" se maschile mettere "o"
// [GENDERPLUR]			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/


/*============================================
=            ACTION & FILTER LIST            =
============================================*/

// Inizializzo il post type
add_action( 'init', 'MR_custom_post_[SLUG]' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_[SLUG]_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-[SLUG]_columns', 'MR_[SLUG]_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_[SLUG]_posts_custom_column', 'MR_[SLUG]_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_[SLUG]_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_[SLUG]', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_[SLUG]_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_[SLUG]_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_[SLUG]_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_[SLUG]_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_[SLUG]', 'MR_[SLUG]_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_[SLUG]', 'MR_[SLUG]_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_[SLUG]', 'MR_[SLUG]_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_[SLUG]', 'MR_[SLUG]_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_[SLUG]() {
  $labels = array(
	  'name'               => _x( '[SINUPP]', 'post type general name' ),
	  'singular_name'      => _x( '[SINUPP]', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi [SINUPP]', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova [SINLOW]', '[TEXTDOMAIN]' ),
	  'edit_item'          => __( 'Modifica [SINUPP]', '[TEXTDOMAIN]' ),
	  'new_item'           => __( 'Nuova [SINUPP]', '[TEXTDOMAIN]' ),
	  'all_items'          => __( 'Tutte le iscrizioni', '[TEXTDOMAIN]' ),
	  'view_item'          => __( 'Vedi [SINLOW] ', '[TEXTDOMAIN]' ),
	  'search_items'       => __( 'Cerca [SINLOW]', '[TEXTDOMAIN]' ),
	  'not_found'          => __( 'Nessun[GENDERSING] [SINLOW] trovat[GENDERSING]', '[TEXTDOMAIN]' ),
	  'not_found_in_trash' => __( 'Nessun[GENDERSING] [SINLOW] trovat[GENDERSING] nel cestino', '[TEXTDOMAIN]' ), 
    'parent_item_colon'  => '',
    'menu_name'          => '[SINUPP]'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutt[GENDERPLUR] ', '[TEXTDOMAIN]' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    // 'supports'      => array( 'title', 'thumbnail','custom-fields' ),
    'supports'      => array( 'title', 'thumbnail' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_[SLUG]",
	// 			'read_post'		 => "read_[SLUG]",
	// 			'delete_post'		 => "delete_[SLUG]",
	// 			'edit_posts'	 => "edit_[SLUG]s",
	// 			'edit_others_posts'	 => "edit_others_[SLUG]s",
	// 			'publish_posts'		 => "publish_[SLUG]s",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_[SLUG]s",
	// 			'delete_private_posts'   => "delete_private_[SLUG]s",
	// 			'delete_published_posts' => "delete_private_[SLUG]s",
	// 			'delete_others_posts'    => "delete_others_[SLUG]s",
	// 			'edit_private_posts'     => "delete_others_[SLUG]s",
	// 			'edit_published_posts'   => "edit_published_[SLUG]s",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => '[REWRITESLUG]')
  );
  register_post_type( '[SLUG]', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_[SLUG]() {
        remove_meta_box( 'wpseo_meta', '[SLUG]', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_[SLUG]_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['[SLUG]'] = array(
    0 => '', 
    1 => sprintf( __('[SINUPP] aggiornat[GENDERSING] . <a href="%s">Visualizza [SINLOW]</a>' ,'[TEXTDOMAIN]'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornat[GENDERPLUR].','[TEXTDOMAIN]'),
    3 => __('Dati personalizzati cancellat[GENDERSING].','[TEXTDOMAIN]'),
    4 => __('[SINUPP] aggiornat[GENDERSING].','[TEXTDOMAIN]'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina [SINLOW] a  %s','[TEXTDOMAIN]'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('[SINUPP] pubblicat[GENDERSING] <a href="%s">Visualizza [SINLOW]</a>','[TEXTDOMAIN]'), esc_url( get_permalink($post_ID) ) ),
    7 => __('[SINUPP] salvat[GENDERSING].','[TEXTDOMAIN]'),
    8 => sprintf( __('[SINUPP] inviat[GENDERSING]. <a target="_blank" href="%s">Visualizza anteprima</a>','[TEXTDOMAIN]'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('[SINUPP] programmat[GENDERSING] per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza [SINLOW] aggiornat[GENDERSING]. <a target="_blank" href="%s">Visualizza anteprima</a>','[TEXTDOMAIN]'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_[SLUG]_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == '[SLUG]' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_[SLUG]_register_meta_boxes( $meta_boxes ) {
    // 1st meta box
    $meta_boxes[] = array(
        'id'         => 'data-expositor',
        'title'      => __( 'Contenuti Espositore', 'eicma' ),
        'post_types' => array( e_news ),
        'context'    => 'normal',
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
function MR_[SLUG]_columns($columns) {
	
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
function MR_[SLUG]_manage_columns( $column, $post_id ) {
	global $post;
	$[SLUG]_meta = get_post_meta( $post_id );
	
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
function MR_[SLUG]_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=[SLUG]'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_[SLUG]_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == '[SLUG]' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_[SLUG]_remove_pagesize( $query ) {
    if ( is_post_type_archive( '[SLUG]' ) ) {
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
function MR_[SLUG]_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_[SLUG]_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_[SLUG]_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_[SLUG]_delete_transition_event( $ID, $post ){


}

