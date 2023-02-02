<?php
/*===============================================
=            FIND & REPLACE VARIABLE            =
===============================================*/

// [SLUG]			-> slug della tassonomia
// [CPTSLUG]		-> slug del post type di riferimento
// [REWRITESLUG]	-> Slug per il rewrite
// MR			-> prefisso da appendere ad ogni  funzione 
// [TEXTDOMAIN]		-> Textdomain per il gettext
// [SINUPP]		 	-> Nome singolare della tassonomia con la prima lettera maiscola
// [SINLOW]		 	-> Nome singolare della tassonomia con la prima lettera minuscola
// [PLUUPP]		 	-> Nome plurale della tassonomia con la prima lettera maiscola
// [PLULOW]		 	-> Nome plurale della tassonomia con la prima lettera minuscola
// [GENDERSING]			-> se femminile mettere "a" se maschile mettere "o"
// [GENDERPLUR]			-> se femminile mettere "e" se maschile mettere "i"
// 

/*=====  End of FIND & REPLACE VARIABLE  ======*/

//taxonomies

/* 
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
add_action( 'init', 'MR_taxonomy_[SLUG]', 0 );

// Gestisco le colonne della tassonomia
add_filter('manage_edit-[SLUG]_columns', 'MR_[SLUG]_manage_taxonomy_columns');

// Popolo le colonne
add_action( 'manage_[SLUG]_custom_column', 'MR_manage_[SLUG]_taxonomy_columns', 10, 3 );

/*=====  End of ACTION & FILTER  ======*/



/**
 *
 * Registro la tassonomia Categoria Partecipazione 
 *
 */

function MR_taxonomy_[SLUG]() {
  $labels = array(
	  'name'              => _x( '[SINUPP]', 'taxonomy general name' ),
	  'singular_name'     => _x( '[SINUPP]', 'taxonomy singular name' ),
	  'search_items'      => __( 'Cerca nell[GENDERSING] [SINLOW]', '[TEXTDOMAIN]' ),
	  'all_items'         => __( 'Tutte le [PLULOW]' , '[TEXTDOMAIN]'),
	  'parent_item'       => __( 'Genitore dell[GENDERSING] [SINLOW]' , '[TEXTDOMAIN]'),
	  'parent_item_colon' => __( 'Genitore:', '[TEXTDOMAIN]' ),
	  'edit_item'         => __( 'Modifica l[GENDERSING] [SINLOW] ' , '[TEXTDOMAIN]'), 
	  // 'capabilities' => array(
			// 			      'manage_terms'=> 'manage_[SLUG]',
			// 			      'edit_terms'=> 'manage_[SLUG]',
			// 			      'delete_terms'=> 'manage_[SLUG]',
			// 			      'assign_terms' => 'read'
			// 			    ),
	  'update_item'       => __( 'Aggiorn[GENDERSING] la [SINLOW]' ),
	  'add_new_item'      => __( 'Aggiungi nuov[GENDERSING] [SINLOW]' ),
	  'new_item_name'     => __( 'Nuov[GENDERSING] [SINLOW]' ),
	  'menu_name'         => __( '[PLUUPP]' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( '[SLUG]', '[CPTSLUG]', $args ); // array()
 
}




/**
 *
 * Registro le colonne per Race
 *
 */
function MR_[SLUG]_manage_taxonomy_columns($columns) {
	if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != '[SLUG]' ){
		

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
function MR_manage_[SLUG]_taxonomy_columns( $value, $column_name, $tax_id) {
	switch( $column_name ) {
	
	   
	    case 'price' :
	
	  		echo 'Ciao mondo';
	
	        break;
			
		
	    default :
	        break;
	}
}
