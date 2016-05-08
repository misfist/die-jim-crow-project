<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Die_Jim_Crow
 */

?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		?>

		<?php
			if ( has_post_thumbnail() ) {
					the_post_thumbnail( $thumbsize );
				// Else if the post has a mime type that starts with "image/" then show the image directly.
			} elseif ( 'image/' == substr( $post->post_mime_type, 0, 6 ) ) {
				echo wp_get_attachment_image( $post->ID, $thumbsize );
			}
		?>
	</header><!-- .entry-header -->

	<footer class="entry-footer">
		<?php die_jim_crow_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</li><!-- #post-## -->
