<?php
/**
 * Enqueue Parent Styles
 *
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/**
 * Add Javascript for searchbar ad covering fix
 */
wp_register_script('topnews-searchfix', get_stylesheet_directory_uri() . '/js/searchfix.js', array('jquery'), '', true);
wp_enqueue_script('topnews-searchfix');


/*
function my_unregister_default_wp_widgets() {
  remove_action( 'widgets_init', 'mvp_ad_load_widgets' );
  unregister_widget('mvp_ad_widget');
}
add_action('widgets_init', 'my_unregister_default_wp_widgets' );

function register_new_ad_widget() {
  require_once( get_stylesheet_directory() . '/widgets/widget-ad.php' );
}
add_action('wp_register_sidebar_widget', 'register_new_ad_widget' );
*/

//require_once( get_stylesheet_directory() . '/widgets/widget-ad.php' );

/**
 * Dequeue the Top News retina script.
 *
 * Hooked to the wp_print_scripts action, with a late priority (100),
 * so that it is after the script was enqueued.
 */
if (!function_exists('fcc_topnews_dequeue_script')) {
  function fcc_topnews_dequeue_script() {
   wp_dequeue_script( 'retina' );
 }
}
add_action( 'wp_print_scripts', 'fcc_topnews_dequeue_script', 100 );


/**
 * Hide WP Admin Bar for users who are not logged in
 */
function hook_wp_head() {
  if ( !is_user_logged_in() ){
    echo '<style>#wpadminbar{ display:none !important; }</style>';
  }
}
add_action('wp_head','hook_wp_head', 20);


/*--------------------------------------------------------------
# "Link" Post Functions
--------------------------------------------------------------*/

/**
 * Add "Link" Post Format
 */
function add_post_formats() {
    add_theme_support( 'post-formats', array( 'link' ) );
}

/**
 * Link URL Replacement
 */
function get_my_url() {
    if ( ! preg_match( '#^<a.+href=[\'"]([^\'"]+).+</a>#', get_the_content(), $matches ) )
        return false;
    return esc_url_raw( $matches[1] );
}
add_action('after_setup_theme', 'add_post_formats', 'get_my_url', 20 );
