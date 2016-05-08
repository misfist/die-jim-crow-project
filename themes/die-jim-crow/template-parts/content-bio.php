<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Die_Jim_Crow
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background-image: url(<?php echo has_post_thumbnail( $id ) ? wp_get_attachment_image_url( get_post_thumbnail_id( $id ), 'photo_album' ) : ''; ?>);">
	<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
</article><!-- #post-## -->
