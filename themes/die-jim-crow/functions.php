<?php
/**
 * Die Jim Crow functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Die_Jim_Crow
 */


/**
 * Set-up.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Enqueue Styles and Scripts.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom Functions.
 * May be moved into a core site plugin.
 */
require get_template_directory() . '/inc/custom.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
