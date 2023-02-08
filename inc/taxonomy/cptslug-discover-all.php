<?php
/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// Discover All			-> slug della tassonomia
// Discover All		-> slug del post type di riferimento
// Discover All	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// Discover All		-> Textdomain per il gettext
// Discover All		 	-> Nome singolare della tassonomia con la prima lettera maiscola
// Discover All		 	-> Nome singolare della tassonomia con la prima lettera minuscola
// Discover All		 	-> Nome plurale della tassonomia con la prima lettera maiscola
// Discover All		 	-> Nome plurale della tassonomia con la prima lettera minuscola
// o			-> se femminile mettere "a" se maschile mettere "o"
// i			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/

//taxonomies

/* 
Discover All
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
add_action( 'init', 'MR_taxonomy_Discoverall', 0 );

// Gestisco le colonne della tassonomia
add_filter('manage_edit-Discover All_columns', 'MR_Discoverall_manage_taxonomy_columns');

// Popolo le colonne
add_action( 'manage_Discover All_custom_column', 'MR_manage_Discoverall_taxonomy_columns', 10, 3 );

/*=====  End of ACTION & FILTER  ======*/



/**
 *
 * Registro la tassonomia Categoria Partecipazione 
 *
 */

function MR_taxonomy_Discoverall() {
  $labels = array(
	  'name'              => _x( 'Discover All', 'taxonomy general name' ),
	  'singular_name'     => _x( 'Discover all', 'taxonomy singular name' ),
	  'search_items'      => __( 'Cerca nello Discove', 'Discover All' ),
	  'all_items'         => __( 'Tutte le Discover All' , 'Discover All'),
	  'parent_item'       => __( 'Genitore dello Discover All' , 'Discover All'),
	  'parent_item_colon' => __( 'Genitore:', 'Discover All' ),
	  'edit_item'         => __( 'Modifica lo Discover All ' , 'Discover All'), 
	  // 'capabilities' => array(
			// 			      'manage_terms'=> 'manage_Discover All',
			// 			      'edit_terms'=> 'manage_Discover All',
			// 			      'delete_terms'=> 'manage_Discover All',
			// 			      'assign_terms' => 'read'
			// 			    ),
	  'update_item'       => __( 'Aggiorno la Discover All' ),
	  'add_new_item'      => __( 'Aggiungi nuovo Discover All' ),
	  'new_item_name'     => __( 'Nuovo Discover All' ),
	  'menu_name'         => __( 'Discover All' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'show_in_nav_menus' => true,
  );

  register_taxonomy( 'Discover All', array('fellowship', 'parliaments', 'projects', 'spotlight', 'stories'), $args );
 
}




/**
 *
 * Registro le colonne per Race
 *
 */
function MR_Discoverall_manage_taxonomy_columns($columns) {
	if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'Discoverall' ){
		

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
function MR_manage_Discoverall_taxonomy_columns( $value, $column_name, $tax_id) {
	switch( $column_name ) {
	
	   
	    case 'price' :
	
	  		echo 'Ciao mondo';
	
	        break;
			
		
	    default :
	        break;
	}
}
