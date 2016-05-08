<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Die_Jim_Crow
 */

if( is_home() && is_active_sidebar( 'sidebar-home' ) ) : ?>

    <aside id="secondary" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-home' ); ?>
    </aside><!-- #secondary -->

<?php else : ?>
    <?php
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        return;
    }
    ?>
    
    <aside id="secondary" class="widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside><!-- #secondary -->

<?php endif; ?>


