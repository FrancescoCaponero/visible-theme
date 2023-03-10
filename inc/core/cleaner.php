<?php 

/**
 *
 * Rimuovo i widget di default dalla dashboard
 *
 */
add_action('wp_dashboard_setup', 'MR_remove_dashboard_widgets');

function MR_remove_dashboard_widgets(){
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
    remove_meta_box('dashboard_activity', 'dashboard', 'side');   // Attivit recenti
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
// use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
}



/**
 *
 * Pulisco lo header
 *
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');


/**
 *
 * Rimuovo pingback da header
 *
 */
add_filter('wp_headers', 'MR_remove_x_pingback');
function MR_remove_x_pingback($headers) {
  unset($headers['X-Pingback']);
    return $headers;
}
