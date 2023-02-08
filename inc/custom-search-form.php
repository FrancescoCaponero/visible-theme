<?php


/*=============================================
=            CUSTOMIZE SEARCH FORM            =
==============================================*/

function custom_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="" >
      <div class="custom-form"><label class="screen-reader-text hidden-input" for="s">' . __( 'Search:' ) . '</label>
      <input placeholder="search something" class="hidden-input" type="text" value="' . get_search_query() . '" name="s" id="s" />
      <button type="submit" id="searchsubmit" value="'. esc_attr__( 'CERCA' ) .'">
      <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="6.21154" cy="5.71154" r="4.96154" stroke="white" stroke-width="1.5"/>
        <line x1="10.376" y1="8.81342" x2="14.5299" y2="12.9673" stroke="white" stroke-width="1.5"/>
        </svg>
        </button>
    </div>
    </form>';

    return $form;
  }
  add_filter( 'get_search_form', 'custom_search_form', 40 );

  /*=====  End of CUSTOMIZE SEARCH FORM  ======*/

  //set the excerpt num of charaters

  function custom_excerpt_length( $length ) {
    return 20;
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );