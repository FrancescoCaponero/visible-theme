<?php

/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// projects			-> slug del custom post type
// projects	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// projects		-> Textdomain per il gettext
// Project		 	-> Nome singolare del cpt con la prima lettera maiscola
// project		 	-> Nome singolare del cpt con la prima lettera minuscola
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
add_action( 'init', 'MR_custom_post_projects' );

//	Aggiorna i label per i post update nel backpanel
add_filter( 'post_updated_messages', 'MR_projects_updated_messages' );

//Registro/Modifico/Elimino le colonne del custom post type
add_filter('manage_edit-projects_columns', 'MR_projects_columns');

//Popolo le colonne precedentemente registrate
add_action( 'manage_projects_posts_custom_column', 'MR_projects_manage_columns', 10, 2 );

// Aggiungo del codice in testa alla pagina di gestione del cpt
add_action('admin_notices','MR_projects_header_html');

// Rimuovo lo Yoast Seo Metabox
add_action( 'add_meta_boxes', 'MR_remove_yoast_metabox_for_projects', 11 );

// Registo i custom metabox
add_filter( 'rwmb_meta_boxes', 'MR_projects_register_meta_boxes' );



// OPTIONALS

//Rimuovo la voce "Aggiungi nuovo custom post type" dal menu
//add_action('admin_menu', 'MR_projects_hide_add_new_in_menu');

//Rimuovo il quiedit 
if (is_admin()) {
	//add_filter('post_row_actions','MR_projects_remove_quick_edit',10,2);
}

// Disabilito la paginazione nell'archive
//add_action( 'pre_get_posts', 'MR_projects_remove_pagesize', 1 );


// STATUS EVENTS

// Publish Action
add_action('publish_projects', 'MR_projects_publish_transition_event' , 10 , 2);

// Pending Action
add_action('pending_projects', 'MR_projects_pending_transition_event' , 10 , 2);

// Draft Action
add_action('draft_projects', 'MR_projects_draft_transition_event' , 10 , 2);

// Delete Action
add_action('delete_projects', 'MR_projects_delete_transition_event' , 10 , 2);



/*=====  End of ACTION & FILTER LIST  ======*/




/**
 *
 * Registro Subscribers
 *
 */

function MR_custom_post_projects() {
  $labels = array(
	  'name'               => _x( 'Project', 'post type general name' ),
	  'singular_name'      => _x( 'Project', 'post type singular name' ),
	  'add_new'            => _x( 'Aggiungi Project', '' ),
	  'add_new_item'       => __( 'Aggiungi una nuova project', 'projects' ),
	  'edit_item'          => __( 'Modifica Project', 'projects' ),
	  'new_item'           => __( 'Nuova Project', 'projects' ),
	  'all_items'          => __( 'Tutte le iscrizioni', 'projects' ),
	  'view_item'          => __( 'Vedi project ', 'projects' ),
	  'search_items'       => __( 'Cerca project', 'projects' ),
	  'not_found'          => __( 'Nessuno project trovato', 'projects' ),
	  'not_found_in_trash' => __( 'Nessuno project trovato nel cestino', 'projects' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Project'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => __( 'Contiene tutti ', 'projects' ),
    'public'        => true,
	'exclude_from_search' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'author', 'thumbnail' ),
    'has_archive'   => true,
    'exclude_from_search' => FALSE,
	'menu_icon'		=> 'dashicons-awards',
	// 'capabilities' => array(
	// 			'edit_post'	 => "edit_projects",
	// 			'read_post'		 => "read_projects",
	// 			'delete_post'		 => "delete_projects",
	// 			'edit_posts'	 => "edit_projectss",
	// 			'edit_others_posts'	 => "edit_others_projectss",
	// 			'publish_posts'		 => "publish_projectss",
	// 			'read'                 => "read",
	// 			'delete_posts'           => "delete_projectss",
	// 			'delete_private_posts'   => "delete_private_projectss",
	// 			'delete_published_posts' => "delete_private_projectss",
	// 			'delete_others_posts'    => "delete_others_projectss",
	// 			'edit_private_posts'     => "delete_others_projectss",
	// 			'edit_published_posts'   => "edit_published_projectss",
	// 			'create_posts'           => FALSE,
	//   ),
	'map_meta_cap' => true,
	'rewrite'		=> array('slug' => 'projects')
  );
  register_post_type( 'projects', $args ); 
}




/**
 *
 *	Rimuove il metabox di yoast dalla pagina del custom post type
 * 
 */
function MR_remove_yoast_metabox_for_projects() {
        remove_meta_box( 'wpseo_meta', 'projects', 'normal' );
        
}


/**
 *
 * Aggiungo messaggi di interfaccia 
 *
 */

function MR_projects_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['projects'] = array(
    0 => '', 
    1 => sprintf( __('Project aggiornato . <a href="%s">Visualizza project</a>' ,'projects'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Dati personalizzati aggiornati.','projects'),
    3 => __('Dati personalizzati cancellato.','projects'),
    4 => __('Project aggiornato.','projects'),
    5 => isset($_GET['revision']) ? sprintf( __('ripristina project a  %s','projects'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project pubblicato <a href="%s">Visualizza project</a>','projects'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project salvato.','projects'),
    8 => sprintf( __('Project inviato. <a target="_blank" href="%s">Visualizza anteprima</a>','projects'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project programmato per : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Visualizza anteprima</a>',' TEXTDOMAIN]'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Bozza project aggiornato. <a target="_blank" href="%s">Visualizza anteprima</a>','projects'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}




/**
 *
 * Aggiongo del codice HTML nella pagina di elenco dei Subscribers
 *
 */
function MR_projects_header_html() {
    global $pagenow ,$post;

    if( !empty($post) && $post->post_type == 'projects' && $pagenow == 'edit.php' ) {

        //$output = '<p>Ciao Mondo!</p>';

        echo $output;
    }
}



function MR_projects_register_meta_boxes( $meta_boxes ) {
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
function MR_projects_columns($columns) {
	
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
function MR_projects_manage_columns( $column, $post_id ) {
	global $post;
	$projects_meta = get_post_meta( $post_id );
	
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
function MR_projects_hide_add_new_in_menu()
{
    global $submenu;
    unset($submenu['edit.php?post_type=projects'][10]);
}



/**
 *
 * Remuovo Quick edit 
 *
 */
function MR_projects_remove_quick_edit( $actions ) {
	global $post;
    if( $post->post_type == 'projects' ) {
		unset($actions['inline hide-if-no-js']);
	}
    return $actions;
}



/**
 *
 * Disabilito la paginazione
 *
 */
function MR_projects_remove_pagesize( $query ) {
    if ( is_post_type_archive( 'projects' ) ) {
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
function MR_projects_publish_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa a In Revisione
 *
 */
function MR_projects_pending_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post passa Bozza
 *
 */
function MR_projects_draft_transition_event( $ID, $post ){


}

/**
 *
 * Funzione chimamata quando il post viene eliminato
 *
 */
function MR_projects_delete_transition_event( $ID, $post ){


}

