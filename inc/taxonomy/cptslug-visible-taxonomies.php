<?php
/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// visibletaxonomies			-> slug della tassonomia
// visibletaxonomies		-> slug del post type di riferimento
// visibletaxonomies	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// visibletaxonomies		-> Textdomain per il gettext
// visibletaxonomies		 	-> Nome singolare della tassonomia con la prima lettera maiscola
// visibletaxonomies		 	-> Nome singolare della tassonomia con la prima lettera minuscola
// visibletaxonomies		 	-> Nome plurale della tassonomia con la prima lettera maiscola
// visibletaxonomies		 	-> Nome plurale della tassonomia con la prima lettera minuscola
// o			-> se femminile mettere "a" se maschile mettere "o"
// i			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/

//taxonomies

/* 
visibletaxonomies
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
add_action( 'init', 'MR_taxonomy_visibletaxonomies', 0 );

// Gestisco le colonne della tassonomia
add_filter('manage_edit-visibletaxonomies_columns', 'MR_visibletaxonomies_manage_taxonomy_columns');

// Popolo le colonne
add_action( 'manage_visibletaxonomies_custom_column', 'MR_manage_visibletaxonomies_taxonomy_columns', 10, 3 );

/*=====  End of ACTION & FILTER  ======*/



/**
 *
 * Registro la tassonomia Categoria Partecipazione 
 *
 */

function MR_taxonomy_visibletaxonomies() {
  $labels = array(
	  'name'              => _x( 'Visible Categories', 'taxonomy general name' ),
	  'singular_name'     => _x( 'visibletaxonomies', 'taxonomy singular name' ),
	  'search_items'      => __( 'Cerca nello visibletaxonomies', 'visibletaxonomies' ),
	  'all_items'         => __( 'Tutte le visibletaxonomies' , 'visibletaxonomies'),
	  'parent_item'       => __( 'Genitore dello visibletaxonomies' , 'visibletaxonomies'),
	  'parent_item_colon' => __( 'Genitore:', 'visibletaxonomies' ),
	  'edit_item'         => __( 'Modifica lo visibletaxonomies ' , 'visibletaxonomies'), 
	  // 'capabilities' => array(
			// 			      'manage_terms'=> 'manage_visibletaxonomies',
			// 			      'edit_terms'=> 'manage_visibletaxonomies',
			// 			      'delete_terms'=> 'manage_visibletaxonomies',
			// 			      'assign_terms' => 'read'
			// 			    ),
	  'update_item'       => __( 'Aggiorno la visibletaxonomies' ),
	  'add_new_item'      => __( 'Aggiungi nuovo visibletaxonomies' ),
	  'new_item_name'     => __( 'Nuovo visibletaxonomies' ),
	  'menu_name'         => __( 'visibletaxonomies' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );

  register_taxonomy( 'visibletaxonomies', array('fellowship', 'parliaments', 'projects', 'spotlight', 'stories'), $args );
 
}




/**
 *
 * Registro le colonne per Race
 *
 */
function MR_visibletaxonomies_manage_taxonomy_columns($columns) {
	if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'visibletaxonomies' ){
		

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
function MR_manage_visibletaxonomies_taxonomy_columns( $value, $column_name, $tax_id) {
	switch( $column_name ) {
	
	   
	    case 'price' :
	
	  		echo 'Ciao mondo';
	
	        break;
			
		
	    default :
	        break;
	}
}
