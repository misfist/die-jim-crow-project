<?php
/**
 * Enqueue Styles and Scripts
 *
 * @package Die_Jim_Crow
 */

/**
 * Load the Parent Theme Stylesheet
 * @link https://codex.wordpress.org/Child_Themes
 *
 */
function die_jim_crow_scripts() {
    wp_enqueue_style( 'die-jim-crow-style', get_stylesheet_uri() );

    wp_enqueue_script( 'site-scripts', get_template_directory_uri() . '/dist/scripts/main.js', array(), '', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'die_jim_crow_scripts' );

/**
 * Load a Custom Login Stylesheet
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
 *
 */
function djc_enqueue_login_styles() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/admin.css' );
}
add_action( 'login_enqueue_scripts', 'djc_enqueue_login_styles' );

?>