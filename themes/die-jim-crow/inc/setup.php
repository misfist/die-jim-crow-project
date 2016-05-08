<?php
/**
 * Enqueue Styles and Scripts
 *
 * @package Die_Jim_Crow
 */

if ( ! function_exists( 'die_jim_crow_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function die_jim_crow_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Die Jim Crow, use a find and replace
     * to change 'die-jim-crow' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'die-jim-crow', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary', 'die-jim-crow' ),
        'social' => esc_html__( 'Social Menu', 'die-jim-crow' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    /*
     * Enable support for Post Formats.
     * See https://developer.wordpress.org/themes/functionality/post-formats/
     */
    add_theme_support( 'post-formats', array(
        'image',
        'video',
        'audio',
        'quote',
        'link',
    ) );

    // Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'die_jim_crow_custom_background_args', array(
        'default-color' => '000000',
        'default-image' => '',
    ) ) );

    /*
     * Enable support for custom logo.
     *
     * @since Die_Jim_Crow 1.0.0
     */
    add_theme_support( 'custom-logo', array(
        'height'      => 240,
        'width'       => 240,
        'flex-height' => true,
    ) );
}
endif;
add_action( 'after_setup_theme', 'die_jim_crow_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function die_jim_crow_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'die_jim_crow_content_width', 930 );
}
add_action( 'after_setup_theme', 'die_jim_crow_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function die_jim_crow_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'die-jim-crow' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'die-jim-crow' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Home Sidebar', 'die-jim-crow' ),
        'id'            => 'sidebar-home',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Content Footer', 'die-jim-crow' ),
        'id'            => 'sidebar-content-footer',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'die_jim_crow_widgets_init' );


?>