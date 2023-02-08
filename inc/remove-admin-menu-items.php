<?php

add_action( 'admin_menu', 'remove_posts_menu_item' );
function remove_posts_menu_item() {
    remove_menu_page( 'edit.php' );
}

add_action( 'admin_menu', 'remove_comments_menu_item' );
function remove_comments_menu_item() {
    remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'remove_menu_items_for_non_admins' );
function remove_menu_items_for_non_admins() {
    if ( ! current_user_can( 'manage_options' ) ) {
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'options-general.php' );
    }
}

