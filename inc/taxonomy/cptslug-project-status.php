<?php
/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// project-status			-> slug della tassonomia
// project-status		-> slug del post type di riferimento
// project-status	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// project-status		-> Textdomain per il gettext
// project-status		 	-> Nome singolare della tassonomia con la prima lettera maiscola
// project-status		 	-> Nome singolare della tassonomia con la prima lettera minuscola
// project-status		 	-> Nome plurale della tassonomia con la prima lettera maiscola
// project-status		 	-> Nome plurale della tassonomia con la prima lettera minuscola
// o			-> se femminile mettere "a" se maschile mettere "o"
// i			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/

//taxonomies

/* 
project-status
Climate Crisis
Gender&Queer Based Violence 
Social Justice 
Rural & Food Politics Gentrifcation 
Indigenous Rights 
Policies of Care 
Social Design 
Pedagogy and Education
 */

/*============================================
=            ACTION & FILTER LIST            =
============================================*/



/*=======================================
=            ACTION & FILTER            =
=======================================*/

// Inizializzo la tassonomia
add_action( 'init', 'MR_taxonomy_project_status', 0 );

// Gestisco le colonne della tassonomia
add_filter('manage_edit-project-status_columns', 'MR_project_status_manage_taxonomy_columns');

// Popolo le colonne
add_action( 'manage_project-status_custom_column', 'MR_manage_project_status_taxonomy_columns', 10, 3 );

/*=====  End of ACTION & FILTER  ======*/



/**
 *
 * Registro la tassonomia Categoria Partecipazione 
 *
 */

function MR_taxonomy_project_status() {
  $labels = array(
	  'name'              => _x( 'Project Status', 'taxonomy general name' ),
	  'singular_name'     => _x( 'project status', 'taxonomy singular name' ),
	  'search_items'      => __( 'Cerca tra i projects', 'project-status' ),
	  'all_items'         => __( 'Tutti gli status' , 'project-status'),
	  'parent_item'       => __( 'Genitore dello project-status' , 'project-status'),
	  'parent_item_colon' => __( 'Genitore:', 'project-status' ),
	  'edit_item'         => __( 'Modifica lo project-status ' , 'project-status'), 
	  // 'capabilities' => array(
			// 			      'manage_terms'=> 'manage_project-status',
			// 			      'edit_terms'=> 'manage_project-status',
			// 			      'delete_terms'=> 'manage_project-status',
			// 			      'assign_terms' => 'read'
			// 			    ),
	  'update_item'       => __( 'Aggiorno la project-status' ),
	  'add_new_item'      => __( 'Aggiungi nuovo project-status' ),
	  'new_item_name'     => __( 'Nuovo project-status' ),
	  'menu_name'         => __( 'Project Status' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'show_in_nav_menus' => true,
  );

  register_taxonomy( 'project-status', array('projects', 'stories'), $args );
 
}




/**
 *
 * Registro le colonne per Race
 *
 */
function MR_project_status_manage_taxonomy_columns($columns) {
	if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'project_status' ){
		

	}else{
		
		// Aggiungo colonne
		// $columns['price'] = 'Quota Iscrizione';

		// Modifico Colonne
		// $columns['posts'] = 'Iscritti';
		

		// Elimino Colonne
		//unset($columns['description']);
		//unset($columns['slug']);
		
		
	}
    return $columns;
}


/**
 *
 * Popolo le colonne create per Race
 *
 */
function MR_manage_project_status_taxonomy_columns( $value, $column_name, $tax_id) {
	switch( $column_name ) {
	
	   
	    case 'price' :
	
	  		echo 'Ciao mondo';
	
	        break;
			
		
	    default :
	        break;
	}
}
