<?php
/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// library			-> slug della tassonomia
// library		-> slug del post type di riferimento
// library	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// library		-> Textdomain per il gettext
// library		 	-> Nome singolare della tassonomia con la prima lettera maiscola
// library		 	-> Nome singolare della tassonomia con la prima lettera minuscola
// library		 	-> Nome plurale della tassonomia con la prima lettera maiscola
// library		 	-> Nome plurale della tassonomia con la prima lettera minuscola
// o			-> se femminile mettere "a" se maschile mettere "o"
// i			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/

//taxonomies

/* 
library
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
add_action( 'init', 'MR_taxonomy_library', 0 );

// Gestisco le colonne della tassonomia
add_filter('manage_edit-library_columns', 'MR_library_manage_taxonomy_columns');

// Popolo le colonne
add_action( 'manage_library_custom_column', 'MR_manage_library_taxonomy_columns', 10, 3 );

/*=====  End of ACTION & FILTER  ======*/



/**
 *
 * Registro la tassonomia Categoria Partecipazione 
 *
 */

function MR_taxonomy_library() {
  $labels = array(
	  'name'              => _x( 'Library', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Library', 'taxonomy singular name' ),
	  'search_items'      => __( 'Cerca tra i library', 'library' ),
	  'all_items'         => __( 'Tutte i library' , 'library'),
	  'parent_item'       => __( 'Genitore dello library' , 'library'),
	  'parent_item_colon' => __( 'Genitore:', 'library' ),
	  'edit_item'         => __( 'Modifica lo library ' , 'library'), 
	  // 'capabilities' => array(
			// 			      'manage_terms'=> 'manage_library',
			// 			      'edit_terms'=> 'manage_library',
			// 			      'delete_terms'=> 'manage_library',
			// 			      'assign_terms' => 'read'
			// 			    ),
	  'update_item'       => __( 'Aggiorno la library' ),
	  'add_new_item'      => __( 'Aggiungi nuovo library' ),
	  'new_item_name'     => __( 'Nuovo library' ),
	  'menu_name'         => __( 'Library' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'show_in_nav_menus' => true,
  );

  register_taxonomy( 'library', array( 'projects', 'stories'), $args );
 
}




/**
 *
 * Registro le colonne per Race
 *
 */
function MR_library_manage_taxonomy_columns($columns) {
	if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'library' ){
		

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
function MR_manage_library_taxonomy_columns( $value, $column_name, $tax_id) {
	switch( $column_name ) {
	
	   
	    case 'price' :
	
	  		echo 'Ciao mondo';
	
	        break;
			
		
	    default :
	        break;
	}
}
